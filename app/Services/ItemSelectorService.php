<?php

namespace App\Services;

use App\Models\Categoria;
use App\Models\Dificultad;
use App\Models\Evaluacion;
use Illuminate\Support\Collection;

/**
 * Servicio para selección adaptativa de evaluaciones basado en IRT + Markov
 * 
 * Implementa la política de decisión que combina:
 * - Rendimiento por categoría (r_c)
 * - Entropía de estados Markov (H(s_c))
 * - Probabilidad de subir de nivel (T_c,i→i+1)
 */
class ItemSelectorService
{
    // Coeficientes de la política (MVP según documentación)
    private const ALPHA = 0.5;  // Peso para rendimiento
    private const BETA = 0.3;    // Peso para entropía
    private const GAMMA = 0.2;   // Peso para probabilidad de subir

    // Épsilon para exploración (ε-greedy)
    private const EPSILON = 0.2;

    public function __construct(
        private IrtService $irtService,
        private MarkovService $markovService
    ) {
    }

    /**
     * Selecciona la siguiente categoría para un estudiante usando política Markov+IRT
     * 
     * Score_c = α(1-r_c) + βH(s_c) + γ(1-T_c,i→i+1)
     * 
     * @param int $userId ID del usuario
     * @return int|null ID de la categoría recomendada o null si no hay datos
     */
    public function seleccionarCategoria(int $userId): ?int
    {
        // Si historial corto, usar exploración ε-greedy
        if ($this->tieneHistorialSuficiente($userId)) {
            return $this->politicaMarkovIrt($userId);
        } else {
            return $this->exploracionEpsilon($userId);
        }
    }

    /**
     * Selecciona una evaluación adaptativa para un estudiante en una categoría
     * basado en theta y nivel
     * 
     * @param int $userId ID del usuario
     * @param int $categoriaId ID de la categoría
     * @param int|null $periodoId ID del período (opcional)
     * @return Evaluacion|null Evaluación recomendada
     */
    public function seleccionarEvaluacion(int $userId, int $categoriaId, ?int $periodoId = null): ?Evaluacion
    {
        // Obtener theta del estudiante en esta categoría
        $thetaData = $this->irtService->calcularTheta($userId, $categoriaId);
        $theta = $thetaData['theta'] ?? null;
        $nivel = $theta !== null ? $this->irtService->obtenerNivel($theta) : 'medio';

        // Mapear nivel a dificultad recomendada
        $dificultadId = $this->mapearNivelADificultad($nivel);

        // Obtener IDs de evaluaciones ya completadas (con intento correcto)
        $evaluacionesCompletadas = \App\Models\Intento::where('user_id', $userId)
            ->where('es_correcto_int', true)
            ->pluck('evaluacion_id')
            ->toArray();

        // Buscar evaluaciones disponibles (excluyendo las completadas)
        $query = Evaluacion::query()
            ->where('categoria_id', $categoriaId)
            ->where('estado_eval', 2) // Publicadas
            ->where('dificultad_id', $dificultadId)
            ->whereNotIn('id_eval', $evaluacionesCompletadas); // NUEVO: Excluir completadas

        if ($periodoId) {
            $query->where('periodo_id', $periodoId);
        }

        // Si hay parámetros IRT, priorizar evaluaciones con b cercano a theta
        $evaluaciones = $query->with('irtParametros')->get();

        if ($evaluaciones->isEmpty()) {
            // Si no hay evaluaciones de la dificultad exacta, buscar la más cercana
            return $this->buscarEvaluacionCercana($categoriaId, $dificultadId, $periodoId, $evaluacionesCompletadas);
        }

        // Si hay theta, priorizar evaluaciones con b ~ theta
        if ($theta !== null) {
            return $this->seleccionarPorInformacionIrt($evaluaciones, $theta);
        }

        // Si no hay theta, seleccionar aleatoriamente
        return $evaluaciones->random();
    }

    /**
     * Obtiene todas las evaluaciones recomendadas para un estudiante
     * agrupadas por categoría
     */
    public function obtenerEvaluacionesRecomendadas(int $userId, ?int $periodoId = null): Collection
    {
        $categorias = Categoria::where('activo_cat', true)->get();
        $recomendadas = collect();

        foreach ($categorias as $categoria) {
            $evaluacion = $this->seleccionarEvaluacion($userId, $categoria->id_cat, $periodoId);
            
            if ($evaluacion) {
                $thetaData = $this->irtService->calcularTheta($userId, $categoria->id_cat);
                $theta = $thetaData['theta'] ?? null;
                $nivel = $theta !== null ? $this->irtService->obtenerNivel($theta) : null;
                
                $recomendadas->push([
                    'categoria' => $categoria,
                    'evaluacion' => $evaluacion,
                    'theta' => $theta,
                    'nivel' => $nivel,
                    'razon' => $this->generarRazon($nivel, $evaluacion->dificultad),
                ]);
            }
        }

        return $recomendadas;
    }

    /**
     * Política de decisión: Score_c = α(1-r_c) + βH(s_c) + γ(1-T_c,i→i+1)
     */
    private function politicaMarkovIrt(int $userId): ?int
    {
        $categorias = Categoria::where('activo_cat', true)->get();
        $scores = [];

        foreach ($categorias as $categoria) {
            $categoriaId = $categoria->id_cat;

            // Rendimiento (r_c): último rendimiento EMA
            $rendimiento = \App\Models\Rendimiento::where('user_id', $userId)
                ->where('categoria_id', $categoriaId)
                ->first();
            $r_c = $rendimiento ? $rendimiento->r_ema : 0.5;

            // Entropía (H(s_c))
            $distribucion = $this->markovService->obtenerDistribucionEstados($userId, $categoriaId);
            $H_sc = $this->markovService->calcularEntropia($distribucion);

            // Probabilidad de subir (T_c,i→i+1)
            $estadoActual = $this->markovService->obtenerEstado($userId, $categoriaId, $this->irtService);
            $matriz = $this->markovService->calcularMatrizTransicion($categoriaId, 'user', $userId);
            $T_subir = $estadoActual ? $this->markovService->probabilidadSubirNivel($matriz, $estadoActual) : 0.5;

            // Score_c = α(1-r_c) + βH(s_c) + γ(1-T_c,i→i+1)
            $score = self::ALPHA * (1 - $r_c) 
                   + self::BETA * $H_sc 
                   + self::GAMMA * (1 - $T_subir);

            $scores[$categoriaId] = $score;
        }

        if (empty($scores)) {
            return null;
        }

        // Seleccionar categoría con mayor score
        arsort($scores);
        return array_key_first($scores);
    }

    /**
     * Exploración ε-greedy: con probabilidad ε, seleccionar aleatoriamente
     */
    private function exploracionEpsilon(int $userId): ?int
    {
        if (rand(1, 100) <= (self::EPSILON * 100)) {
            // Explorar: seleccionar categoría aleatoria
            $categoria = Categoria::where('activo_cat', true)->inRandomOrder()->first();
            return $categoria ? $categoria->id_cat : null;
        } else {
            // Explotar: usar política normal
            return $this->politicaMarkovIrt($userId);
        }
    }

    /**
     * Mapea nivel del estudiante a dificultad de evaluación
     */
    private function mapearNivelADificultad(string $nivel): int
    {
        return match ($nivel) {
            'bajo' => 1,      // 1_facil
            'medio' => 3,      // 3_media
            'alto' => 5,      // 5_dificil
            default => 3,     // Por defecto: media
        };
    }

    /**
     * Selecciona evaluación basada en información IRT (maximizar I_i(θ))
     */
    private function seleccionarPorInformacionIrt(Collection $evaluaciones, float $theta): ?Evaluacion
    {
        $mejorEvaluacion = null;
        $maxInformacion = -1.0;

        foreach ($evaluaciones as $evaluacion) {
            $irtParametro = $evaluacion->irtParametros;
            
            if (!$irtParametro) {
                continue;
            }

            $a = (float) $irtParametro->a_discriminacion;
            $b = (float) $irtParametro->b_dificultad;

            // Información del ítem: I_i(θ) = a² * P(θ) * (1 - P(θ))
            $probabilidad = $this->probabilidadIrt($theta, $a, $b);
            $informacion = $a * $a * $probabilidad * (1 - $probabilidad);

            // Priorizar evaluaciones con b cercano a theta (mantener P en [0.4, 0.8])
            if ($probabilidad >= 0.4 && $probabilidad <= 0.8) {
                if ($informacion > $maxInformacion) {
                    $maxInformacion = $informacion;
                    $mejorEvaluacion = $evaluacion;
                }
            }
        }

        // Si no hay evaluación ideal, seleccionar la más cercana en b
        if (!$mejorEvaluacion && $evaluaciones->isNotEmpty()) {
            $mejorEvaluacion = $evaluaciones->first();
            $diferenciaMin = abs($this->obtenerB($mejorEvaluacion) - $theta);

            foreach ($evaluaciones as $evaluacion) {
                $b = $this->obtenerB($evaluacion);
                $diferencia = abs($b - $theta);

                if ($diferencia < $diferenciaMin) {
                    $diferenciaMin = $diferencia;
                    $mejorEvaluacion = $evaluacion;
                }
            }
        }

        return $mejorEvaluacion;
    }

    /**
     * Probabilidad IRT-2PL
     */
    private function probabilidadIrt(float $theta, float $a, float $b): float
    {
        $exponente = -$a * ($theta - $b);
        
        if ($exponente > 700) {
            return 1.0;
        } elseif ($exponente < -700) {
            return 0.0;
        }
        
        return 1.0 / (1.0 + exp($exponente));
    }

    /**
     * Obtiene valor b de una evaluación
     */
    private function obtenerB(Evaluacion $evaluacion): float
    {
        $irtParametro = $evaluacion->irtParametros;
        
        if ($irtParametro) {
            return (float) $irtParametro->b_dificultad;
        }
        
        // Mapear dificultad_id a b
        return match ($evaluacion->dificultad_id) {
            1 => -2.0,
            2 => -1.0,
            3 => 0.0,
            4 => 1.0,
            5 => 2.0,
            default => 0.0,
        };
    }

    /**
     * Busca evaluación cercana cuando no hay de la dificultad exacta
     */
    private function buscarEvaluacionCercana(int $categoriaId, int $dificultadId, ?int $periodoId, array $evaluacionesCompletadas = []): ?Evaluacion
    {
        $query = Evaluacion::query()
            ->where('categoria_id', $categoriaId)
            ->where('estado_eval', 2)
            ->whereNotIn('id_eval', $evaluacionesCompletadas); // Excluir completadas

        if ($periodoId) {
            $query->where('periodo_id', $periodoId);
        }

        // Buscar dificultades cercanas
        $dificultadesCercanas = $this->obtenerDificultadesCercanas($dificultadId);
        
        return $query->whereIn('dificultad_id', $dificultadesCercanas)
            ->inRandomOrder()
            ->first();
    }

    /**
     * Obtiene dificultades cercanas a una dificultad dada
     */
    private function obtenerDificultadesCercanas(int $dificultadId): array
    {
        return match ($dificultadId) {
            1 => [1, 2],      // fácil -> fácil o baja
            2 => [1, 2, 3],   // baja -> fácil, baja o media
            3 => [2, 3, 4],   // media -> baja, media o alta
            4 => [3, 4, 5],   // alta -> media, alta o difícil
            5 => [4, 5],      // difícil -> alta o difícil
            default => [3],   // Por defecto: media
        };
    }

    /**
     * Genera razón de asignación para logging/auditoría
     */
    private function generarRazon(?string $nivel, ?Dificultad $dificultad): string
    {
        if (!$nivel || !$dificultad) {
            return 'Sin datos suficientes para determinar nivel';
        }

        $nombreDificultad = $dificultad->nombre_dif ?? 'N/A';

        return sprintf(
            'Estudiante nivel %s → Evaluación dificultad %s',
            ucfirst($nivel),
            $nombreDificultad
        );
    }

    /**
     * Verifica si el estudiante tiene historial suficiente
     */
    private function tieneHistorialSuficiente(int $userId): bool
    {
        $totalIntentos = \App\Models\Intento::where('user_id', $userId)->count();
        return $totalIntentos >= 5; // Mínimo 5 intentos para usar política completa
    }
}

