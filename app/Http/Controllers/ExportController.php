<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Periodo;
use App\Services\RankingService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function __construct(private RankingService $rankingService)
    {
    }

    public function rankingsCsv(Request $request): StreamedResponse
    {
        $periodoId = (int) $request->input('periodo_id');
        $skillId = $request->filled('skill_id') ? (int) $request->skill_id : null;

        abort_if($periodoId === 0, 422, 'El período es obligatorio.');

        $this->rankingService->recalcForPeriodo($periodoId, $skillId);
        $dataset = $this->rankingService->buildDataset($periodoId, $skillId);

        $periodo = Periodo::find($periodoId);
        $skill = $skillId ? Categoria::find($skillId) : null;

        $filename = sprintf('rankings_%s%s.csv',
            $periodo?->nombre_per ?? 'periodo',
            $skill ? '_' . $skill->codigo_cat : ''
        );

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . str_replace(' ', '_', $filename) . '"',
        ];

        $callback = function () use ($dataset) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Posición', 'Estudiante', 'Puntaje total', '# Evaluaciones', 'Última actualización']);
            foreach ($dataset as $item) {
                $ranking = $item->get('ranking');
                $ultima = $item->get('ultima_actualizacion');
                fputcsv($out, [
                    $ranking->posicion,
                    $ranking->user?->name,
                    number_format($ranking->puntaje_total, 2, '.', ''),
                    $item->get('evaluaciones'),
                    $ultima ? $ultima : 'N/D',
                ]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function rankingsPdf(Request $request)
    {
        $periodoId = (int) $request->input('periodo_id');
        $skillId = $request->filled('skill_id') ? (int) $request->skill_id : null;

        abort_if($periodoId === 0, 422, 'El período es obligatorio.');

        $this->rankingService->recalcForPeriodo($periodoId, $skillId);
        $dataset = $this->rankingService->buildDataset($periodoId, $skillId);

        $periodo = Periodo::find($periodoId);
        $skill = $skillId ? Categoria::find($skillId) : null;

        $pdf = Pdf::loadView('admin.rankings.pdf', [
            'dataset' => $dataset,
            'periodo' => $periodo,
            'skill' => $skill,
        ])->setPaper('a4', 'portrait');

        $filename = sprintf('rankings_%s%s.pdf',
            $periodo?->nombre_per ?? 'periodo',
            $skill ? '_' . $skill->codigo_cat : ''
        );

        return $pdf->download(str_replace(' ', '_', $filename));
    }
}
