<?php

namespace App\Http\Controllers\DocenteDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Importar el modelo User
use App\Models\Periodo; // Importar el modelo Periodo
use App\Services\RankingService; // Importar RankingService

class DocenteDashboardController extends Controller
{
    public function __construct(private RankingService $rankingService)
    {
    }

    public function index(?Periodo $periodoActual = null)
    {
        // Si no se proporciona un periodo, intenta obtener el actual
        if (!$periodoActual) {
            $periodoActual = Periodo::orderByDesc('id_per')->first();
        }

        $periodoId = $periodoActual?->id_per;
        if ($periodoId) {
            $this->rankingService->recalcForPeriodo($periodoId, null);
        }

        $top = $periodoId ? $this->rankingService->buildDataset($periodoId)->take(5) : collect();

        // Aseguramos que cada elemento en $topRanking tenga una propiedad 'user'
        $topRanking = $top->map(function ($rankingEntry) {
            $rankingEntry = (object) $rankingEntry;
            if (!isset($rankingEntry->user) || !($rankingEntry->user instanceof User)) {
                if (isset($rankingEntry->user_id)) {
                    $rankingEntry->user = User::find($rankingEntry->user_id);
                } else {
                    $rankingEntry->user = new User();
                }
            }
            return $rankingEntry;
        });

        $heatmap = \App\Models\Score::query()
            ->selectRaw('categorias.nombre_cat as categoria, SUM(scores.puntaje) as total')
            ->join('evaluaciones', 'evaluaciones.id_eval', '=', 'scores.evaluacion_id')
            ->join('categorias', 'categorias.id_cat', '=', 'evaluaciones.categoria_id')
            ->when($periodoId, fn($q) => $q->where('evaluaciones.periodo_id', $periodoId))
            ->groupBy('categorias.nombre_cat')
            ->orderByDesc('total')
            ->get();

        // Lógica para la distribución de habilidades
        $habilidadDistribucion = \App\Models\EstHabilidad::query()
            ->selectRaw('CASE
                WHEN theta_global < 0 THEN \'Bajo\'
                WHEN theta_global >= 0 AND theta_global < 1 THEN \'Medio\'
                ELSE \'Alto\'
            END as nivel, COUNT(*) as count')
            ->groupBy('nivel')
            ->pluck('count', 'nivel')
            ->toArray();

        $orderedHabilidad = ['Bajo' => 0, 'Medio' => 0, 'Alto' => 0];
        foreach ($habilidadDistribucion as $nivel => $count) {
            if (isset($orderedHabilidad[$nivel])) {
                $orderedHabilidad[$nivel] = $count;
            }
        }

        return view('docente.dashboard.index', [
            'mode' => 'docente',
            'studentCount' => User::role('estudiante')->count(),
            'evaluacionesPublicadas' => \App\Models\Evaluacion::where('estado_eval', 2)->count(),
            'evaluacionesCerradas' => \App\Models\Evaluacion::where('estado_eval', 3)->count(),
            'totalDocentes' => User::role('docente')->count(),
            'topRanking' => $topRanking,
            'heatmap' => $heatmap,
            'periodoActual' => $periodoActual,
            'habilidadDistribucion' => array_values($orderedHabilidad),
            'habilidadLabels' => array_keys($orderedHabilidad),
        ]);
    }

    public function intentos(Request $request)
    {
        $query = \App\Models\Intento::with(['user', 'evaluacion.categoria']); 

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function ($qUser) use ($search) {
                    $qUser->where('name', 'like', '%' . $search . '%')
                          ->orWhere('app_usu', 'like', '%' . $search . '%')
                          ->orWhere('apm_usu', 'like', '%' . $search . '%');
                })
                ->orWhereHas('evaluacion', function ($qEvaluacion) use ($search) {
                    $qEvaluacion->where('titulo_eval', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if (in_array($status, ['1', '0'])) {
                $query->where('es_correcto_int', (bool)$status);
            }
        }

        if ($request->filled('evaluacion_id')) {
            $evaluacionId = $request->input('evaluacion_id');
            $query->where('evaluacion_id', $evaluacionId);
        }

        $sortBy = $request->input('sort_by', 'id_int');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSortColumns = ['id_int', 'nro_intento_int', 'tiempo_envio_int', 'latencia_seg_int'];

        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id_int';
        }
        
        $query->orderBy($sortBy, $sortDirection);

        $intentos = $query->paginate(15);
        $evaluaciones = \App\Models\Evaluacion::orderBy('titulo_eval')->get(['id_eval', 'titulo_eval']);

        return view('docente.intentos.index', compact('intentos', 'evaluaciones'));
    }

    public function showIntento(\App\Models\Intento $intento)
    {
        $intento->load(['user', 'evaluacion.categoria']);
        
        $score = \App\Models\Score::where('user_id', $intento->user_id)
                      ->where('evaluacion_id', $intento->evaluacion_id)
                      ->orderByDesc('updated_at')
                      ->first();

        // Aseguramos de que el docente use una vista similar a admin.intentos.show
        // Idealmente, crear docente.intentos.show duplicando o extendiendo la admin
        return view('docente.intentos.show', compact('intento', 'score'));
    }

    public function exportPdf(Request $request)
    {
        $query = \App\Models\Intento::with(['user', 'evaluacion']); 

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function ($qUser) use ($search) {
                    $qUser->where('name', 'like', '%' . $search . '%')
                          ->orWhere('app_usu', 'like', '%' . $search . '%')
                          ->orWhere('apm_usu', 'like', '%' . $search . '%');
                })
                ->orWhereHas('evaluacion', function ($qEvaluacion) use ($search) {
                    $qEvaluacion->where('titulo_eval', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            if (in_array($status, ['1', '0'])) {
                $query->where('es_correcto_int', (bool)$status);
            }
        }

        if ($request->filled('evaluacion_id')) {
            $evaluacionId = $request->input('evaluacion_id');
            $query->where('evaluacion_id', $evaluacionId);
        }

        $intentos = $query->latest('tiempo_envio_int')->get(); 

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.intentos.pdf_report', compact('intentos'));
        return $pdf->download('auditoria_intentos_' . now()->format('Ymd_His') . '.pdf'); 
    }

    public function exportPdfShow(\App\Models\Intento $intento)
    {
        $intento->load(['user', 'evaluacion.categoria']);
        $score = \App\Models\Score::where('user_id', $intento->user_id)
                      ->where('evaluacion_id', $intento->evaluacion_id)
                      ->orderByDesc('updated_at')
                      ->first();

        if ($score && !isset($score->calculo_meta)) {
            $score->calculo_meta = null;
        }

        // Reusing the admin view for PDF since it's just a report
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.intentos.show_pdf_report', compact('intento', 'score'));
        return $pdf->download('reporte_intento_' . $intento->id_int . '_' . now()->format('Ymd_His') . '.pdf');
    }

    public function reportesIrt()
    {
        $estudiantes = User::role('estudiante')
            ->select('id', 'name', 'app_usu', 'apm_usu')
            ->orderBy('name')
            ->get();
        
        $categorias = \App\Models\Categoria::orderBy('nombre_cat')->get();

        return view('docente.reportes_irt.index', compact('estudiantes', 'categorias'));
    }

    public function exportaciones()
    {
        return view('docente.exportaciones.index');
    }
}

