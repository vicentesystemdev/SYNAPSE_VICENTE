<?php

namespace App\Services;

use App\Models\Intento;
use Illuminate\Support\Collection;

class LogisticInitService
{
    private const MAX_ITER = 50;
    private const TOL = 1e-4;

    public function __construct(
        private CalculationLogger $logger
    ) {
    }

    /**
     * Estima β por Newton–Raphson para una logística binaria
     * y devuelve p_empirico y logit(p) como semilla de θ.
     *
     * @return array{p_empirico: float, logit_p: float, iter: int, convergio: bool, beta: array{0: float,1: float}, n: int, loglik: float}|null
     */
    public function estimarProbabilidadEmpirica(int $userId, int $categoriaId): ?array
    {
        $this->logger->subsection("REGRESIÓN LOGÍSTICA - Estimación de Probabilidad Empírica");
        $this->logger->data("Usuario ID", $userId);
        $this->logger->data("Categoría ID", $categoriaId);

        $intentos = Intento::query()
            ->where('user_id', $userId)
            ->whereHas('evaluacion', fn($q) => $q->where('categoria_id', $categoriaId))
            ->orderBy('created_at')
            ->get(['es_correcto_int', 'latencia_seg_int', 'created_at']);

        $n = $intentos->count();
        $this->logger->data("Número de intentos", $n);

        if ($n < 3) { // mínimo recomendado
            $this->logger->warning("Insuficientes datos (mínimo 3 intentos requeridos)");
            return null;
        }

        // Construir pares (x_i, u_i); x = índice temporal (1..n)
        $x = [];
        $u = [];
        $i = 1;
        foreach ($intentos as $row) {
            $x[] = (float)$i; // predictor simple temporal
            $u[] = $row->es_correcto_int ? 1.0 : 0.0;
            $i++;
        }

        // Normalización opcional para estabilidad numérica
        $mean = array_sum($x) / $n;
        $var = 0.0; foreach ($x as $xi) { $var += ($xi - $mean) * ($xi - $mean); }
        $std = $var > 0 ? sqrt($var / $n) : 1.0;
        $xNorm = array_map(fn($xi) => ($std > 0 ? ($xi - $mean) / $std : $xi), $x);

        // Inicialización β = (0, 0)
        $beta0 = 0.0; $beta1 = 0.0;
        $iter = 0; $convergio = false; $loglik = 0.0;

        $this->logger->log("Iniciando Newton-Raphson (β₀=0, β₁=0)");

        while ($iter < self::MAX_ITER) {
            $iter++;
            $g0 = 0.0; $g1 = 0.0; // gradiente
            $h00 = 0.0; $h01 = 0.0; $h11 = 0.0; // Hessiano (simétrico)
            $loglik = 0.0;

            for ($k = 0; $k < $n; $k++) {
                $z = $beta0 + $beta1 * $xNorm[$k];
                // clamp z para evitar overflow
                if ($z > 30) { $z = 30; }
                if ($z < -30) { $z = -30; }
                $p = 1.0 / (1.0 + exp(-$z));
                $p = min(max($p, 1e-6), 1 - 1e-6);

                $uk = $u[$k];
                $loglik += $uk * log($p) + (1 - $uk) * log(1 - $p);

                $w = $p * (1 - $p); // varianza
                $g0 += ($uk - $p);
                $g1 += ($uk - $p) * $xNorm[$k];

                $h00 -= $w;
                $h01 -= $w * $xNorm[$k];
                $h11 -= $w * $xNorm[$k] * $xNorm[$k];
            }

            // Resolver paso NR: H * d = g  => d = H^{-1} g
            $det = $h00 * $h11 - $h01 * $h01;
            if (abs($det) < 1e-8) {
                // Hessiano singular: regularizar ligeramente
                $h00 -= 1e-6; $h11 -= 1e-6;
                $det = $h00 * $h11 - $h01 * $h01;
                if (abs($det) < 1e-10) {
                    $this->logger->warning("Hessiano singular - no converge");
                    break; // no progresa
                }
            }

            $d0 = ($h11 * $g0 - $h01 * $g1) / $det;
            $d1 = (-$h01 * $g0 + $h00 * $g1) / $det;

            $beta0New = $beta0 - $d0;
            $beta1New = $beta1 - $d1;

            $normDelta = sqrt($d0 * $d0 + $d1 * $d1);
            
            // Log cada 5 iteraciones o si converge
            if ($iter % 5 == 0 || $normDelta < self::TOL) {
                $this->logger->iteration($iter, [
                    'β₀' => round($beta0New, 6),
                    'β₁' => round($beta1New, 6),
                    'logLik' => round($loglik, 4),
                    'Δ' => round($normDelta, 8)
                ]);
            }

            $beta0 = $beta0New; $beta1 = $beta1New;

            if ($normDelta < self::TOL) { 
                $convergio = true; 
                $this->logger->result("Convergencia alcanzada", "Iteración {$iter}");
                break; 
            }
        }

        // Calcular probabilidades con betas finales
        $pList = [];
        for ($k = 0; $k < $n; $k++) {
            $z = $beta0 + $beta1 * $xNorm[$k];
            if ($z > 30) { $z = 30; }
            if ($z < -30) { $z = -30; }
            $pList[] = 1.0 / (1.0 + exp(-$z));
        }
        $pEmp = array_sum($pList) / $n;
        // Evitar logit(0) y logit(1)
        $pSafe = max(min($pEmp, 1 - 1e-6), 1e-6);
        $logit = log($pSafe / (1 - $pSafe));

        $this->logger->blank();
        $this->logger->result("p_empírico", round($pEmp, 6));
        $this->logger->result("logit(p)", round($logit, 6));
        $this->logger->result("β₀ final", round($beta0, 6));
        $this->logger->result("β₁ final", round($beta1, 6));
        $this->logger->result("Convergió", $convergio ? 'Sí' : 'No');

        return [
            'p_empirico' => round($pEmp, 6),
            'logit_p' => round($logit, 6),
            'iter' => $iter,
            'convergio' => $convergio,
            'beta' => [round($beta0, 6), round($beta1, 6)],
            'n' => $n,
            'loglik' => $loglik,
        ];
    }
}
