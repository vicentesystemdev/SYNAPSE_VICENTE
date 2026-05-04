<?php

namespace App\Services;

use App\Models\EstHabilidad;
use App\Models\Transition;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Servicio para gestión de cadenas de Markov de estados (Bajo/Medio/Alto)
 * 
 * Implementa:
 * - Seguimiento de transiciones de estados por categoría
 * - Cálculo de matriz de transición
 * - Entropía de estados para política de decisión
 */
class MarkovService
{
    private const ESTADO_BAJO = 'bajo';
    private const ESTADO_MEDIO = 'medio';
    private const ESTADO_ALTO = 'alto';
    
    private const ESTADOS = [self::ESTADO_BAJO, self::ESTADO_MEDIO, self::ESTADO_ALTO];

    public function __construct(
        private CalculationLogger $logger
    ) {
    }

    /**
     * Obtiene el estado actual del estudiante en una categoría
     */
    public function obtenerEstado(int $userId, int $categoriaId, IrtService $irtService): ?string
    {
        return $irtService->obtenerNivelPorCategoria($userId, $categoriaId);
    }

    /**
     * Registra una transición de estado si cambió
     */
    public function registrarTransicion(int $userId, int $categoriaId, ?string $estadoAnterior, ?string $estadoNuevo): void
    {
        $this->logger->subsection("MARKOV - Transición de Estado");
        $this->logger->data("Estado anterior", $estadoAnterior ?? 'null');
        $this->logger->data("Estado nuevo", $estadoNuevo ?? 'null');

        // Solo registrar si hay cambio de estado
        if ($estadoAnterior === null || $estadoNuevo === null || $estadoAnterior === $estadoNuevo) {
            $this->logger->log("No hay cambio de estado - no se registra transición");
            return;
        }

        // Validar que ambos estados sean válidos
        if (!in_array($estadoAnterior, self::ESTADOS) || !in_array($estadoNuevo, self::ESTADOS)) {
            $this->logger->warning("Estados inválidos - no se registra transición");
            return;
        }

        Transition::create([
            'user_id' => $userId,
            'categoria_id' => $categoriaId,
            'estado_origen' => $estadoAnterior,
            'estado_destino' => $estadoNuevo,
        ]);

        $this->logger->result("Transición registrada", "{$estadoAnterior} → {$estadoNuevo}");
    }

    /**
     * Calcula la matriz de transición para una categoría
     * 
     * @param int $categoriaId ID de la categoría
     * @param string|null $scope 'user'|'global' - si es 'user', solo para un usuario específico
     * @param int|null $userId ID del usuario (requerido si scope='user')
     * @return array Matriz 3x3: [origen][destino] => probabilidad
     */
    public function calcularMatrizTransicion(int $categoriaId, ?string $scope = 'global', ?int $userId = null): array
    {
        $query = Transition::where('categoria_id', $categoriaId);
        
        if ($scope === 'user' && $userId) {
            $query->where('user_id', $userId);
        }

        $transiciones = $query->get();

        // Inicializar matriz de conteos
        $matriz = [];
        foreach (self::ESTADOS as $origen) {
            $matriz[$origen] = [];
            foreach (self::ESTADOS as $destino) {
                $matriz[$origen][$destino] = 0;
            }
        }

        // Contar transiciones
        foreach ($transiciones as $transicion) {
            $origen = $transicion->estado_origen;
            $destino = $transicion->estado_destino;
            
            if (in_array($origen, self::ESTADOS) && in_array($destino, self::ESTADOS)) {
                $matriz[$origen][$destino]++;
            }
        }

        // Convertir conteos a probabilidades
        foreach (self::ESTADOS as $origen) {
            $total = array_sum($matriz[$origen]);
            
            if ($total > 0) {
                foreach (self::ESTADOS as $destino) {
                    $matriz[$origen][$destino] = $matriz[$origen][$destino] / $total;
                }
            } else {
                // Si no hay transiciones desde este estado, usar distribución uniforme
                foreach (self::ESTADOS as $destino) {
                    $matriz[$origen][$destino] = 1.0 / count(self::ESTADOS);
                }
            }
        }

        return $matriz;
    }

    /**
     * Calcula la probabilidad de subir de nivel desde un estado
     * 
     * @param array $matriz Matriz de transición
     * @param string $estadoActual Estado actual
     * @return float Probabilidad de transición a un estado superior
     */
    public function probabilidadSubirNivel(array $matriz, string $estadoActual): float
    {
        if (!isset($matriz[$estadoActual])) {
            return 0.0;
        }

        $probabilidad = 0.0;

        switch ($estadoActual) {
            case self::ESTADO_BAJO:
                // Subir: bajo -> medio o bajo -> alto
                $probabilidad = ($matriz[$estadoActual][self::ESTADO_MEDIO] ?? 0) 
                             + ($matriz[$estadoActual][self::ESTADO_ALTO] ?? 0);
                break;
                
            case self::ESTADO_MEDIO:
                // Subir: medio -> alto
                $probabilidad = $matriz[$estadoActual][self::ESTADO_ALTO] ?? 0;
                break;
                
            case self::ESTADO_ALTO:
                // Ya está en el máximo, probabilidad de mantenerse
                $probabilidad = $matriz[$estadoActual][self::ESTADO_ALTO] ?? 0;
                break;
        }

        return $probabilidad;
    }

    /**
     * Calcula la entropía del vector de estado (incertidumbre)
     * 
     * H(s) = -Σ P(s) * log(P(s))
     * 
     * @param array $distribucion Vector de probabilidades de estados
     * @return float Entropía
     */
    public function calcularEntropia(array $distribucion): float
    {
        $entropia = 0.0;
        
        foreach ($distribucion as $probabilidad) {
            if ($probabilidad > 0) {
                $entropia -= $probabilidad * log($probabilidad, 2);
            }
        }
        
        return $entropia;
    }

    /**
     * Obtiene la distribución de estados para un usuario en una categoría
     * basado en el historial de transiciones
     */
    public function obtenerDistribucionEstados(int $userId, int $categoriaId): array
    {
        $transiciones = Transition::where('user_id', $userId)
            ->where('categoria_id', $categoriaId)
            ->orderBy('created_at', 'desc')
            ->take(10) // Últimas 10 transiciones
            ->get();

        if ($transiciones->isEmpty()) {
            // Distribución uniforme si no hay historial
            return [
                self::ESTADO_BAJO => 1.0 / 3,
                self::ESTADO_MEDIO => 1.0 / 3,
                self::ESTADO_ALTO => 1.0 / 3,
            ];
        }

        // Contar ocurrencias de cada estado destino
        $conteos = [
            self::ESTADO_BAJO => 0,
            self::ESTADO_MEDIO => 0,
            self::ESTADO_ALTO => 0,
        ];

        foreach ($transiciones as $transicion) {
            $destino = $transicion->estado_destino;
            if (isset($conteos[$destino])) {
                $conteos[$destino]++;
            }
        }

        $total = array_sum($conteos);
        
        if ($total === 0) {
            return [
                self::ESTADO_BAJO => 1.0 / 3,
                self::ESTADO_MEDIO => 1.0 / 3,
                self::ESTADO_ALTO => 1.0 / 3,
            ];
        }

        // Normalizar a probabilidades
        return [
            self::ESTADO_BAJO => $conteos[self::ESTADO_BAJO] / $total,
            self::ESTADO_MEDIO => $conteos[self::ESTADO_MEDIO] / $total,
            self::ESTADO_ALTO => $conteos[self::ESTADO_ALTO] / $total,
        ];
    }
}

