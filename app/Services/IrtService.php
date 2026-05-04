<?php

namespace App\Services;

use App\Models\EstHabilidad;
use App\Models\Intento;
use Illuminate\Support\Collection;

class IrtService
{
    private const MAX_ITERATIONS = 50;
    private const TOLERANCE = 1e-4;
    private const THETA_MIN = -3.0;
    private const THETA_MAX = 3.0;

    private const THETA_BAJO = -0.5;
    private const THETA_MEDIO = 0.5;

    public function __construct(
        private CalculationLogger $logger
    ) {
    }

    /**
     * Estima θ para un usuario y categoría con NR (2PL).
     *
     * @return array{theta: float, iter: int, convergio: bool, n: int, fallback_reason: ?string}|null
     */
    public function calcularTheta(int $userId, int $categoriaId, ?float $thetaSemilla = null): ?array
    {
        $this->logger->subsection("IRT 2PL - Estimación de Theta (θ)");
        $this->logger->data("Usuario ID", $userId);
        $this->logger->data("Categoría ID", $categoriaId);

        $intentos = $this->obtenerHistorialIntentos($userId, $categoriaId);
        $n = $intentos->count();
        $this->logger->data("Número de intentos", $n);

        if ($n < 3) {
            $this->logger->warning("Insuficientes datos para IRT (mínimo 3 intentos)");
            return null; // insuficiente
        }

        $datos = $this->prepararDatosIrt($intentos);
        if (count($datos) < 3) {
            $this->logger->warning("Insuficientes datos IRT válidos");
            return null;
        }

        $theta0 = $this->obtenerThetaInicial($userId, $categoriaId);
        $theta = $thetaSemilla ?? $theta0 ?? 0.0;

        $this->logger->data("θ semilla (logit)", $thetaSemilla);
        $this->logger->data("θ inicial", $theta);
        $this->logger->log("Iniciando Newton-Raphson para θ");

        $iter = 0; $convergio = false; $fallback = null;
        for ($iter = 1; $iter <= self::MAX_ITERATIONS; $iter++) {
            $g = 0.0; // L'
            $h = 0.0; // L''
            foreach ($datos as $item) {
                $a = (float)$item['a'];
                $b = (float)$item['b'];
                $u = (float)$item['respuesta'];

                $p = $this->probabilidadIrt($theta, $a, $b);
                $p = min(max($p, 1e-9), 1 - 1e-9);

                $g += $a * ($u - $p);
                $h -= ($a * $a) * $p * (1 - $p);
            }

            if (abs($h) < 1e-8) {
                // Hessiana casi singular: fallback
                $this->logger->warning("Hessiana singular - usando fallback");
                $fallback = 'Hessian singular';
                $theta = $theta0 ?? $thetaSemilla ?? 0.0;
                $convergio = false;
                break;
            }

            $delta = $g / $h;
            $thetaNew = $theta - $delta;
            $thetaNew = max(self::THETA_MIN, min(self::THETA_MAX, $thetaNew));

            // Log cada 5 iteraciones o si converge
            if ($iter % 5 == 0 || abs($delta) < self::TOLERANCE) {
                $this->logger->iteration($iter, [
                    'θ' => round($thetaNew, 6),
                    'Δ' => round($delta, 8),
                    'L\'' => round($g, 6),
                    'L\"' => round($h, 6)
                ]);
            }

            if (abs($delta) < self::TOLERANCE) {
                $theta = $thetaNew;
                $convergio = true;
                $this->logger->result("Convergencia alcanzada", "Iteración {$iter}");
                break;
            }
            $theta = $thetaNew;
        }

        $this->logger->blank();
        $this->logger->result("θ final", round($theta, 4));
        $this->logger->result("Iteraciones", $iter);
        $this->logger->result("Convergió", $convergio ? 'Sí' : 'No');
        if ($fallback) {
            $this->logger->warning("Fallback: {$fallback}");
        }

        return [
            'theta' => round($theta, 4),
            'iter' => $iter,
            'convergio' => $convergio,
            'n' => $n,
            'fallback_reason' => $fallback,
        ];
    }

    /**
     * Calcula theta global como promedio ponderado por cantidad de categorías con θ.
     * (Para mayor precisión se podría ponderar por número de intentos por categoría.)
     */
    public function calcularThetaGlobal(int $userId): ?float
    {
        $habilidad = EstHabilidad::where('user_id', $userId)->first();
        if (!$habilidad || !$habilidad->theta_por_cat || !is_array($habilidad->theta_por_cat)) {
            return null;
        }
        $thetas = array_values(array_filter($habilidad->theta_por_cat, fn($v) => $v !== null));
        if (empty($thetas)) { return null; }
        $prom = array_sum($thetas) / count($thetas);
        return round($prom, 4);
    }

    /**
     * Actualiza θ tras un intento, usando semilla opcional (logit).
     *
     * @return array{thetaCat: ?float, thetaGlobal: ?float, iter: ?int, convergio: ?bool, fallback_reason: ?string}
     */
    public function actualizarThetaDespuesIntento(Intento $intento, ?float $thetaSemilla = null): array
    {
        $evaluacion = $intento->evaluacion;
        if (!$evaluacion) {
            return [
                'thetaCat' => null, 
                'thetaGlobal' => null, 
                'nivelCategoria' => null,
                'nivelGlobal' => null,
                'iter' => null, 
                'convergio' => null, 
                'fallback_reason' => null
            ];
        }
        $userId = $intento->user_id;
        $categoriaId = $evaluacion->categoria_id;

        $res = $this->calcularTheta($userId, $categoriaId, $thetaSemilla);
        if ($res === null) {
            return [
                'thetaCat' => null, 
                'thetaGlobal' => null, 
                'nivelCategoria' => null,
                'nivelGlobal' => null,
                'iter' => null, 
                'convergio' => null, 
                'fallback_reason' => 'insufficient_data'
            ];
        }

        // Persistir en est_habilidades
        $habilidad = EstHabilidad::firstOrCreate(
            ['user_id' => $userId],
            ['theta_global' => null, 'theta_por_cat' => []]
        );
        $thetaPorCat = $habilidad->theta_por_cat ?? [];
        $thetaPorCat[$categoriaId] = $res['theta'];
        $habilidad->theta_por_cat = $thetaPorCat;
        // Recalcular theta_global sobre el arreglo ACTUALIZADO (incluye la categoría recién calculada)
        $vals = array_values(array_filter($thetaPorCat, fn($v) => $v !== null));
        $habilidad->theta_global = !empty($vals) ? round(array_sum($vals) / count($vals), 4) : $res['theta'];
        $habilidad->save();

        // Calcular AMBOS niveles
        $nivelCategoria = $this->obtenerNivel($res['theta']); // Nivel basado en θ de esta categoría
        $nivelGlobal = $this->obtenerNivel($habilidad->theta_global); // Nivel basado en θ global

        $this->logger->blank();
        $this->logger->result("θ por categoría", $res['theta']);
        $this->logger->result("Nivel en esta categoría", strtoupper($nivelCategoria));
        $this->logger->blank();
        $this->logger->result("θ global", $habilidad->theta_global);
        $this->logger->result("Nivel global del estudiante", strtoupper($nivelGlobal));

        return [
            'thetaCat' => $res['theta'],
            'thetaGlobal' => $habilidad->theta_global,
            'nivelCategoria' => $nivelCategoria,
            'nivelGlobal' => $nivelGlobal,
            'iter' => $res['iter'],
            'convergio' => $res['convergio'],
            'fallback_reason' => $res['fallback_reason'],
        ];
    }

    public function obtenerNivel(float $theta): string
    {
        if ($theta < self::THETA_BAJO) { return 'bajo'; }
        if ($theta < self::THETA_MEDIO) { return 'medio'; }
        return 'alto';
    }

    /**
     * Obtiene el nivel del estudiante en una categoría específica
     * leyendo el valor persistido en est_habilidades.
     */
    public function obtenerNivelPorCategoria(int $userId, int $categoriaId): ?string
    {
        $habilidad = EstHabilidad::where('user_id', $userId)->first();
        $thetaPorCat = $habilidad?->theta_por_cat ?? null;
        if (!$thetaPorCat || !array_key_exists($categoriaId, $thetaPorCat)) {
            return null;
        }

        $theta = (float) $thetaPorCat[$categoriaId];
        return $this->obtenerNivel($theta);
    }

    // Utilidades privadas

    private function probabilidadIrt(float $theta, float $a, float $b): float
    {
        $exponente = -$a * ($theta - $b);
        if ($exponente > 30) { $exponente = 30; }
        if ($exponente < -30) { $exponente = -30; }
        return 1.0 / (1.0 + exp($exponente));
    }

    private function obtenerHistorialIntentos(int $userId, int $categoriaId): Collection
    {
        return Intento::query()
            ->where('user_id', $userId)
            ->whereHas('evaluacion', fn($q) => $q->where('categoria_id', $categoriaId))
            ->orderBy('created_at')
            ->get();
    }

    private function prepararDatosIrt(Collection $intentos): array
    {
        $datos = [];
        foreach ($intentos as $intento) {
            $eval = $intento->evaluacion;
            if (!$eval) { continue; }
            $param = $eval->irtParametros;
            $a = $param ? (float)$param->a_discriminacion : 1.0;
            $b = $param ? (float)$param->b_dificultad : $this->mapearDificultadAB($eval->dificultad_id);
            $datos[] = ['a' => $a, 'b' => $b, 'respuesta' => $intento->es_correcto_int ? 1 : 0];
        }
        return $datos;
    }

    private function mapearDificultadAB(?int $dificultadId): float
    {
        $mapeo = [1 => -2.0, 2 => -1.0, 3 => 0.0, 4 => 1.0, 5 => 2.0];
        return $mapeo[$dificultadId ?? 3] ?? 0.0;
    }

    private function obtenerThetaInicial(int $userId, int $categoriaId): float
    {
        $habilidad = EstHabilidad::where('user_id', $userId)->first();
        if ($habilidad && isset($habilidad->theta_por_cat[$categoriaId])) {
            return (float)$habilidad->theta_por_cat[$categoriaId];
        }
        return 0.0;
    }
}

