<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Periodo;
use App\Models\Score;
use App\Models\User;
use App\Models\EstHabilidad;
use App\Models\Intento;
use App\Models\Ranking; // Asegúrate de que esta línea esté presente
use App\Services\RankingService;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function __construct(private RankingService $rankingService)
    {
    }

    public function index(?Periodo $periodoActual = null)
    {
        // Si no se proporciona un periodo, intentar buscar '2025-1' específicamente como pide el usuario
        if (!$periodoActual) {
            $periodoActual = Periodo::where('nombre_per', '2025-1')->first();
            
            // Si no existe 2025-1, usar el último creado como fallback
            if (!$periodoActual) {
                $periodoActual = Periodo::orderByDesc('id_per')->first();
            }
        }

        $periodoId = $periodoActual?->id_per;
        if ($periodoId) {
            $this->rankingService->recalcForPeriodo($periodoId, null);
        }

        $top = $periodoId ? $this->rankingService->buildDataset($periodoId)->take(5) : collect();

        // ****** INICIO DE LA MODIFICACIÓN PARA EL ERROR "Property [user] does not exist" ******

        // Aseguramos que cada elemento en $topRanking tenga una propiedad 'user'
        // que sea una instancia del modelo User.
        $topRanking = $top->map(function ($rankingEntry) {
            // Convertir a objeto si es un array para facilitar el acceso a propiedades
            $rankingEntry = (object) $rankingEntry;

            // Verificar si el rankingEntry ya tiene una relación 'user' cargada (ideal)
            // o si tiene un user_id del cual podemos obtener el usuario.
            if (!isset($rankingEntry->user) || !($rankingEntry->user instanceof User)) {
                if (isset($rankingEntry->user_id)) {
                    $rankingEntry->user = User::find($rankingEntry->user_id);
                } else {
                    // Si no hay user_id o user, podemos asignar un objeto User vacío o null
                    $rankingEntry->user = new User(); // O null, dependiendo de cómo quieras manejarlo en la vista
                }
            }
            return $rankingEntry;
        });

        // ****** FIN DE LA MODIFICACIÓN ******


        $heatmap = Score::query()
            ->selectRaw('categorias.nombre_cat as categoria, SUM(scores.puntaje) as total')
            ->join('evaluaciones', 'evaluaciones.id_eval', '=', 'scores.evaluacion_id')
            ->join('categorias', 'categorias.id_cat', '=', 'evaluaciones.categoria_id')
            ->when($periodoId, fn($q) => $q->where('evaluaciones.periodo_id', $periodoId))
            ->groupBy('categorias.nombre_cat')
            ->orderByDesc('total')
            ->get();

        // Lógica para la distribución de habilidades
        $habilidadDistribucion = EstHabilidad::query()
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

        // Obtener actividad reciente del sistema
        $recentActivities = \App\Models\AuditLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard.index', [
            'mode' => 'manager',
            'studentCount' => User::role('estudiante')->count(),
            'evaluacionesPublicadas' => Evaluacion::where('estado_eval', 2)->count(),
            'evaluacionesCerradas' => Evaluacion::where('estado_eval', 3)->count(),
            'totalDocentes' => User::role('docente')->count(),
            'topRanking' => $topRanking,
            'heatmap' => $heatmap,
            'periodoActual' => $periodoActual,
            'habilidadDistribucion' => array_values($orderedHabilidad),
            'habilidadLabels' => array_keys($orderedHabilidad),
            'recentActivities' => $recentActivities, // Pasar la actividad reciente a la vista
        ]);
    }
}
