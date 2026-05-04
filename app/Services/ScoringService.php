<?php

namespace App\Services;

use App\Models\Intento;
use App\Models\Rendimiento;
use App\Models\Score;
use Illuminate\Support\Facades\DB;

class ScoringService
{
    private float $alpha = 0.20;
    private float $rInit = 0.50;

    public function __construct(
        private RankingService $rankingService,
        private IrtService $irtService,
        private MarkovService $markovService,
        private LogisticInitService $logisticInitService,
        private CalculationLogger $logger
    ) {
    }

    public function procesarIntento(Intento $intento): void
    {
        DB::transaction(function () use ($intento) {
            $evaluacion = $intento->evaluacion()->first();
            if (!$evaluacion) {
                return;
            }

            $categoriaId = $evaluacion->categoria_id;
            $userId = $intento->user_id;

            // === INICIO DEL LOGGING ===
            $this->logger->section("PROCESAMIENTO DE INTENTO - MOTOR INTELIGENTE");
            $this->logger->subsection("ENTRADA DE DATOS");
            $this->logger->data("Usuario ID", $userId);
            $this->logger->data("Evaluación ID", $evaluacion->id_eval);
            $this->logger->data("Categoría ID", $categoriaId);
            $this->logger->data("Respuesta correcta", $intento->es_correcto_int ? 'Sí' : 'No');
            $this->logger->data("Número de intento", $intento->nro_intento_int);
            $this->logger->blank();

            // === CÁLCULO TRADICIONAL (EMA) ===
            $this->logger->subsection("CÁLCULO TRADICIONAL - EMA (Rendimiento)");
            $intentoCorrecto = $intento->es_correcto_int;
            $penalizacion = max(0.0, 1 - 0.05 * max(0, ($intento->nro_intento_int - 1)));

            $envioTimestamp = $intento->tiempo_envio_int ?? now()->timestamp;
            $inicio = optional($evaluacion->fecha_inicio_eval)?->timestamp;
            $fin = optional($evaluacion->fecha_fin_eval)?->timestamp;
            $ventana = $inicio && $fin ? max($fin - $inicio, 0) : null;
            $delta = $inicio ? max($envioTimestamp - $inicio, 0) : null;
            $bonoTiempo = ($ventana && $ventana > 0 && $delta !== null && ($delta / $ventana) <= 0.8) ? 1.10 : 1.00;

            $factorResultado = ($intentoCorrecto ? 1.0 : 0.0) * $penalizacion * $bonoTiempo;

            $rendimiento = Rendimiento::firstOrCreate(
                ['user_id' => $userId, 'categoria_id' => $categoriaId],
                ['r_ema' => $this->rInit, 'muestras' => 0]
            );

            $emaPrev = $rendimiento->r_ema ?? $this->rInit;
            $nuevoEma = $emaPrev + $this->alpha * ($factorResultado - $emaPrev);
            $rendimiento->r_ema = round($nuevoEma, 4);
            $rendimiento->muestras = ($rendimiento->muestras ?? 0) + 1;
            $rendimiento->save();

            $this->logger->data("Penalización por intentos", round($penalizacion, 4));
            $this->logger->data("Bono de tiempo", round($bonoTiempo, 2));
            $this->logger->data("Factor resultado", round($factorResultado, 4));
            $this->logger->data("EMA anterior", round($emaPrev, 4));
            $this->logger->result("EMA nuevo", round($nuevoEma, 4));
            $this->logger->data("Muestras totales", $rendimiento->muestras);
            $this->logger->blank();

            $puntajeBase = $evaluacion->puntaje_base_eval ?? 0;
            $puntaje = round($puntajeBase * $factorResultado, 2);
            $porcentaje = $puntajeBase > 0 ? round(($puntaje / $puntajeBase) * 100, 2) : 0.0;

            // === Semilla logística (logit) ===
            $this->logger->blank();
            $seed = $this->logisticInitService->estimarProbabilidadEmpirica($userId, $categoriaId);
            $thetaSemilla = $seed['logit_p'] ?? null;

            // === CÁLCULO IRT (THETA) ===
            $this->logger->blank();
            $estadoAnterior = $this->markovService->obtenerEstado($userId, $categoriaId, $this->irtService);

            $resIrt = $this->irtService->actualizarThetaDespuesIntento($intento, $thetaSemilla);

            $estadoNuevo = $this->markovService->obtenerEstado($userId, $categoriaId, $this->irtService);
            
            $this->logger->blank();
            $this->markovService->registrarTransicion($userId, $categoriaId, $estadoAnterior, $estadoNuevo);

            // Usar nivel de CATEGORÍA (no global) para el contexto de esta evaluación
            $nivelCategoria = $resIrt['nivelCategoria'] ?? null;
            $nivelGlobal = $resIrt['nivelGlobal'] ?? null;

            // === RESUMEN FINAL ===
            $this->logger->blank();
            $this->logger->section("RESUMEN FINAL");
            $this->logger->result("Puntaje obtenido", $puntaje);
            $this->logger->result("Porcentaje", "{$porcentaje}%");
            $this->logger->result("Nivel en esta categoría", $nivelCategoria ? strtoupper($nivelCategoria) : 'N/A');
            $this->logger->result("Nivel global", $nivelGlobal ? strtoupper($nivelGlobal) : 'N/A');
            $this->logger->blank();

            $meta = [
                'intento_correcto' => $intentoCorrecto,
                'penalizacion'     => $penalizacion,
                'bono_tiempo'      => $bonoTiempo,
                'factor_resultado' => $factorResultado,
                'ema_prev'         => $emaPrev,
                'ema_post'         => $rendimiento->r_ema,
                'muestras'         => $rendimiento->muestras,
                // Semilla logística
                'seed_logistica'   => $seed,
                // IRT
                'irt' => [
                    'theta_cat'       => $resIrt['thetaCat'] ?? null,
                    'theta_global'    => $resIrt['thetaGlobal'] ?? null,
                    'nivel_categoria' => $resIrt['nivelCategoria'] ?? null,
                    'nivel_global'    => $resIrt['nivelGlobal'] ?? null,
                    'iter'            => $resIrt['iter'] ?? null,
                    'convergio'       => $resIrt['convergio'] ?? null,
                    'fallback_reason' => $resIrt['fallback_reason'] ?? null,
                    'estado_anterior' => $estadoAnterior,
                    'estado_nuevo'    => $estadoNuevo,
                ],
            ];

            Score::updateOrCreate(
                ['user_id' => $userId, 'evaluacion_id' => $evaluacion->id_eval],
                ['puntaje' => $puntaje, 'porcentaje' => $porcentaje, 'calculo_meta' => $meta]
            );

            if ($evaluacion->periodo_id) {
                $this->rankingService->recalcForPeriodo((int) $evaluacion->periodo_id, $categoriaId);
            }
        });
    }
}
