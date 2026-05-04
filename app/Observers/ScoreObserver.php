<?php

namespace App\Observers;

use App\Models\Score;
use App\Services\RankingService;

class ScoreObserver
{
    public function __construct(private RankingService $rankingService)
    {
    }

    public function saved(Score $score): void
    {
        $score->loadMissing('evaluacion');
        $evaluacion = $score->evaluacion;
        if (!$evaluacion || !$evaluacion->periodo_id) {
            return;
        }

        $this->rankingService->recalcForPeriodo((int) $evaluacion->periodo_id, null);
        if ($evaluacion->categoria_id) {
            $this->rankingService->recalcForPeriodo((int) $evaluacion->periodo_id, (int) $evaluacion->categoria_id);
        }
    }
}
