<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Periodo;
use App\Services\RankingService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse; // Para exportar CSV
use Barryvdh\DomPDF\Facade\Pdf; // Para exportar PDF (Necesitarás instalarlo)


class RankingController extends Controller
{
    public function __construct(private RankingService $rankingService)
    {
    }

    public function index(Request $request)
    {
        $periodos = Periodo::orderByDesc('id_per')->get();
        $skills = Categoria::orderBy('nombre_cat')->get();

        $periodoId = (int) ($request->input('periodo_id') ?: $periodos->first()?->id_per);
        $skillId = $request->filled('skill_id') ? (int) $request->skill_id : null;
        $nivel = $request->filled('nivel') ? $request->input('nivel') : null; // Nuevo: Obtener el nivel de la solicitud

        $dataset = collect();
        $periodo = null;
        $skill = null;

        if ($periodoId) {
            // Se puede comentar esta línea si no quieres que recalcule en cada visita
            // Si el ranking se recalcula por un observer o un cronjob, no sería necesario aquí
            $this->rankingService->recalcForPeriodo($periodoId, $skillId); // Considerar pasar $nivel si la recalulación lo requiere
            $fullDataset = $this->rankingService->buildDataset($periodoId, $skillId, $nivel); // Modificado: Pasar $nivel

            $top10Dataset = $fullDataset->take(10);

            $userRanking = null;
            if ($user = $request->user()) {
                // DEBUG: Muestra el ID del usuario logueado
                // dd("Logged in User ID: " . $user->id);
                $userRanking = $fullDataset->first(function ($item) use ($user) {
                    return optional($item['ranking']->user)->id === $user->id;
                });
            }

            

            // **Añade estas líneas para debuggear:**
            /*dd([
            'periodos' => $periodos->toArray(),
            'periodoId' => $periodoId, 
            'skillId' => $skillId,
            'datasetCount' => $dataset->count(),
            'dataset' => $dataset->toArray(), // Convierte a array para ver el contenido
            ]);*/

            $periodo = $periodos->firstWhere('id_per', $periodoId);
            $skill = $skillId ? $skills->firstWhere('id_cat', $skillId) : null;
        }

        $user = $request->user();
        $view = 'estudiante.rankings.index';

        if ($user?->hasRole('admin')) {
            $view = 'admin.rankings.index';
        } elseif ($user?->hasRole('docente')) {
            $view = 'docente.rankings.index';
        }

        // DEBUG: Check which view is being returned
        // dd($view);

        return view($view, [
            'periodos' => $periodos,
            'skills' => $skills,
            'dataset' => $top10Dataset, // Ahora pasamos solo el top 10
            'fullDataset' => $fullDataset, // Pasamos el dataset completo para la posición del usuario
            'userRanking' => $userRanking, // La posición del usuario logueado
            'periodoSeleccionado' => $periodo,
            'skillSeleccionado' => $skill,
            'filters' => ['periodo_id' => $periodoId, 'skill_id' => $skillId, 'nivel' => $nivel], // Modificado: Añadir 'nivel' a los filtros
            'title' => 'Ranking de Estudiantes' // Añadir title para el layout main_menu
        ]);
    }

    /**
     * Exporta el ranking actual a un archivo CSV.
     */
    public function exportCsv(Request $request): StreamedResponse
    {
        $periodos = Periodo::orderByDesc('id_per')->get();
        $skills = Categoria::orderBy('nombre_cat')->get();

        $periodoId = (int) ($request->input('periodo_id') ?: $periodos->first()?->id_per);
        $skillId = $request->filled('skill_id') ? (int) $request->skill_id : null;
        $nivel = $request->filled('nivel') ? $request->input('nivel') : null; // Nuevo: Obtener el nivel de la solicitud

        $dataset = collect();
        $periodo = null;
        $skill = null;

        if ($periodoId) {
            $dataset = $this->rankingService->buildDataset($periodoId, $skillId, $nivel); // Modificado: Pasar $nivel
            $periodo = $periodos->firstWhere('id_per', $periodoId);
            $skill = $skillId ? $skills->firstWhere('id_cat', $skillId) : null;
        }

        $filename = 'ranking_' . ($periodo?->nombre_per ?? 'general') . ($skill?->nombre_cat ? '_' . $skill->nombre_cat : '') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($dataset) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Posicion', 'Estudiante', 'Puntaje total', '# Evaluaciones', 'Ultima actualizacion']);

            foreach ($dataset as $item) {
                $ranking = $item->get('ranking');
                $user_name = $ranking->user?->name ?? 'N/D';
                $updated_at = optional($item->get('ultima_actualizacion'))->timezone('America/La_Paz')->format('d/m/Y H:i') ?? 'N/D';
                fputcsv($file, [
                    $ranking->posicion,
                    $user_name,
                    number_format($ranking->puntaje_total, 2),
                    $item->get('evaluaciones'),
                    $updated_at,
                ]);
            }
            fclose($file);
        }, 200, $headers);
    }

    /**
     * Exporta el ranking actual a un archivo PDF.
     */
    public function exportPdf(Request $request)
    {
        // La lógica de obtención de datos es la misma que para CSV
        $periodos = Periodo::orderByDesc('id_per')->get();
        $skills = Categoria::orderBy('nombre_cat')->get();

        $periodoId = (int) ($request->input('periodo_id') ?: $periodos->first()?->id_per);
        $skillId = $request->filled('skill_id') ? (int) $request->skill_id : null;
        $nivel = $request->filled('nivel') ? $request->input('nivel') : null; // Nuevo: Obtener el nivel de la solicitud

        $dataset = collect();
        $periodo = null;
        $skill = null;

        if ($periodoId) {
            $dataset = $this->rankingService->buildDataset($periodoId, $skillId, $nivel); // Modificado: Pasar $nivel
            $periodo = $periodos->firstWhere('id_per', $periodoId);
            $skill = $skillId ? $skills->firstWhere('id_cat', $skillId) : null;
        }

        // Renderiza la vista 'admin.rankings.pdf' con los datos y la convierte a PDF
        $pdf = Pdf::loadView('admin.rankings.pdf', compact('dataset', 'periodo', 'skill'));

        $filename = 'ranking_' . ($periodo?->nombre_per ?? 'general') . ($skill?->nombre_cat ? '_' . $skill->nombre_cat : '') . '.pdf';

        return $pdf->download($filename);
    }
}
