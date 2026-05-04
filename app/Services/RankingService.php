<?php

namespace App\Services;

use App\Models\Ranking;
use App\Models\Score;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RankingService
{
    public function recalcForPeriodo(int $periodoId, ?int $skillId = null): void
    {
        $rows = Score::query()
            ->selectRaw('scores.user_id, SUM(scores.puntaje) as total_puntaje, COUNT(DISTINCT scores.evaluacion_id) as evaluaciones')
            ->join('evaluaciones', 'evaluaciones.id_eval', '=', 'scores.evaluacion_id')
            ->join('users', 'users.id', '=', 'scores.user_id')
            ->where('evaluaciones.periodo_id', $periodoId)
            ->when($skillId, fn($q) => $q->where('evaluaciones.categoria_id', $skillId))
            ->groupBy('scores.user_id', 'users.name')
            ->orderByDesc('total_puntaje')
            ->orderBy('users.name')
            ->get();

        DB::transaction(function () use ($rows, $periodoId, $skillId) {
            foreach ($rows as $index => $row) {
                Ranking::updateOrCreate(
                    ['periodo_id' => $periodoId, 'user_id' => $row->user_id, 'skill_id' => $skillId],
                    ['puntaje_total' => (float) $row->total_puntaje, 'posicion' => $index + 1]
                );
            }

            Ranking::where('periodo_id', $periodoId)
                ->where('skill_id', $skillId)
                ->whereNotIn('user_id', $rows->pluck('user_id'))
                ->delete();
        });
    }

    public function obtenerRanking(int $periodoId, ?int $skillId = null): Collection
    {
        return Ranking::with(['user', 'periodo'])
            ->where('periodo_id', $periodoId)
            ->where(function ($query) use ($skillId) {
                if ($skillId) {
                    $query->where('skill_id', $skillId);
                } else {
                    $query->whereNull('skill_id');
                }
            })
            ->orderBy('posicion')
            ->get();
    }

    public function buildDataset(int $periodoId, ?int $skillId = null, ?string $nivel = null): Collection
    {
        $stats = Score::query()
            ->selectRaw('scores.user_id, COUNT(DISTINCT scores.evaluacion_id) as total_evaluaciones, MAX(scores.updated_at) as ultima_actualizacion')
            ->join('evaluaciones', 'evaluaciones.id_eval', '=', 'scores.evaluacion_id')
            ->where('evaluaciones.periodo_id', $periodoId)
            ->when($skillId, fn($q) => $q->where('evaluaciones.categoria_id', $skillId))
            ->groupBy('scores.user_id')
            ->get()
            ->keyBy('user_id');

        $rankings = $this->obtenerRanking($periodoId, $skillId)->map(function (Ranking $ranking) use ($stats) {
            $stat = $stats->get($ranking->user_id);
            $ultima = $stat?->ultima_actualizacion ? Carbon::parse($stat->ultima_actualizacion) : null;

            return collect([
                'ranking' => $ranking,
                'evaluaciones' => $stat?->total_evaluaciones ?? 0,
                'ultima_actualizacion' => $ultima,
            ]);
        });

        // Aplicar el filtro por nivel si se especifica
        if ($nivel) {
            $rankings = $rankings->filter(function ($item) use ($nivel) {
                $rankingData = $item['ranking']; // Acceder directamente al objeto Ranking
                $derivedNivel = 'N/D'; // Default

                if (isset($rankingData->theta_global)) {
                    if ($rankingData->theta_global > 1) {
                        $derivedNivel = 'alto';
                    } elseif ($rankingData->theta_global >= 0) {
                        $derivedNivel = 'medio';
                    } else {
                        $derivedNivel = 'bajo';
                    }
                } elseif (isset($rankingData->puntaje_total)) { // Fallback si no hay theta_global
                    if ($rankingData->puntaje_total > 200) { // Umbral de ejemplo, ajusta según tus necesidades
                        $derivedNivel = 'alto';
                    } elseif ($rankingData->puntaje_total > 100) { // Umbral de ejemplo, ajusta según tus necesidades
                        $derivedNivel = 'medio';
                    } else {
                        $derivedNivel = 'bajo';
                    }
                }
                return $derivedNivel === $nivel;
            });
        }

        return $rankings;
    }
}
