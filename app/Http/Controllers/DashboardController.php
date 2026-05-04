<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Intento;
use App\Models\Periodo;
use App\Models\Ranking;
use App\Models\Score;
use App\Models\User;
use App\Services\RankingService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect; // Asegúrate de que esta línea esté presente
use App\Models\EstHabilidad; // Importar el modelo EstHabilidad
use App\Http\Controllers\AdminDashboardController; // Importar AdminDashboardController
use App\Http\Controllers\DocenteDashboard\DocenteDashboardController; // Importar DocenteDashboardController

class DashboardController extends Controller
{
    public function __construct(private RankingService $rankingService)
    {
    }

    public function index()
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        // Redirigir a la página de login si no hay usuario autenticado
        if (!$user) {
            return Redirect::route('login');
        }

        // --- Lógica para el dashboard de ADMINISTRADOR ---
        if ($user->hasRole('admin')) {
            // Reutilizamos la lógica de carga de datos que ya tienes en AdminDashboardController
            $adminDashboardController = app(AdminDashboardController::class);
            return $adminDashboardController->index(); // Llamamos al método index de AdminDashboardController
        }

        // --- Lógica para el dashboard de DOCENTE ---
        if ($user->hasRole('docente')) {
            // Aquí deberías integrar la lógica para cargar los datos específicos del dashboard del docente.
            // Asumo que tienes un DocenteDashboardController similar al AdminDashboardController.
            $docenteDashboardController = app(DocenteDashboardController::class);
            return $docenteDashboardController->index();
        }

        // --- Lógica para el dashboard de ESTUDIANTE (TU DISEÑO PERSONALIZADO) ---
        if ($user->hasRole('estudiante')) {
            // Movemos la lógica que estaba en studentOverview() directamente aquí
            $periodoActual = Periodo::orderByDesc('id_per')->first();
            $periodoId = $periodoActual?->id_per;

            $totalIntentos = Intento::where('user_id', $user->id)->count();

            // Eliminamos la redirección directa aquí. El botón "Comenzar" del dashboard lo manejará.
            // if ($totalIntentos === 0) {
            //     $demoEvaluacion = $this->resolveDemoEvaluacion($periodoId);
            //     if ($demoEvaluacion) {
            //         return Redirect::route('evaluaciones.show', $demoEvaluacion);
            //     }
            // }

            $data = $this->buildStudentDashboard($user, $periodoActual, $totalIntentos);
            return view('estudiante.dashboard.index', $data);
        }

        // --- Lógica por defecto (si el usuario no tiene un rol con dashboard personalizado) ---
        // Esto sirve para usuarios autenticados sin un rol específico (o un rol inesperado)
        // Podrías mostrar una página de error, un dashboard genérico o redirigir.
        // Por ahora, redirigimos al inicio de sesión si no hay un rol de dashboard definido.
        return Redirect::route('login');
    }

    public function studentOverview()
    {
        // Este método ahora se vuelve secundario, ya que index() maneja la ruta principal.
        // Lo mantengo por si otras partes del código lo llaman, pero su lógica principal
        // para el dashboard del estudiante se ha movido a index().
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        abort_unless($user?->hasRole('estudiante'), 403);

        $periodoActual = Periodo::orderByDesc('id_per')->first();
        $periodoId = $periodoActual?->id_per;

        $totalIntentos = Intento::where('user_id', $user->id)->count();
        if ($totalIntentos === 0) {
            $demoEvaluacion = $this->resolveDemoEvaluacion($periodoId);
            if ($demoEvaluacion) {
                return Redirect::route('evaluaciones.show', $demoEvaluacion);
            }
        }

        $data = $this->buildStudentDashboard($user, $periodoActual, $totalIntentos);

        return view('estudiante.dashboard.index', $data);
    }

    private function buildStudentDashboard(User $user, ?Periodo $periodoActual, int $totalIntentos): array
    {
        $periodoId = $periodoActual?->id_per;
        if ($periodoId) {
            $this->rankingService->recalcForPeriodo($periodoId, null);
        }

        $estHabilidad = EstHabilidad::where('user_id', $user->id)->first();
        $thetaGlobal = $estHabilidad->theta_global ?? 0;
        $thetaPorCat = $estHabilidad->theta_por_cat ?? [];

        $nivelEstudiante = 'Desconocido';
        if ($thetaGlobal < -0.5) {
            $nivelEstudiante = 'Bajo';
        } elseif ($thetaGlobal >= -0.5 && $thetaGlobal < 0.5) {
            $nivelEstudiante = 'Medio';
        } elseif ($thetaGlobal >= 0.5) {
            $nivelEstudiante = 'Alto';
        }

        $puntajeTotal = Score::where('user_id', $user->id)->sum('puntaje');

        $ultimosScores = Score::with('evaluacion')
            ->where('user_id', $user->id)
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        $categorias = Intento::query()
            ->selectRaw('categorias.nombre_cat as categoria, SUM(intentos.es_correcto_int) as correctos, COUNT(*) as intentos')
            ->join('evaluaciones', 'evaluaciones.id_eval', '=', 'intentos.evaluacion_id')
            ->join('categorias', 'categorias.id_cat', '=', 'evaluaciones.categoria_id')
            ->where('intentos.user_id', $user->id)
            ->groupBy('categorias.nombre_cat')
            ->orderBy('categorias.nombre_cat')
            ->get();

        $posicion = null;
        if ($periodoId) {
            $posicion = Ranking::where('user_id', $user->id)
                ->where('periodo_id', $periodoId)
                ->whereNull('skill_id')
                ->value('posicion');
        }

        // Aquí añadimos $proximaEvaluacion para el botón "Comenzar" del Hero Section
        $proximaEvaluacion = null;
        // Lógica para obtener la próxima evaluación recomendada (puedes usar ItemSelectorService si lo tienes)
        // Por ahora, simplemente intentamos obtener una evaluación demo si es un nuevo estudiante.
        // Para una recomendación más avanzada, necesitarías inyectar y usar ItemSelectorService aquí.
        if ($totalIntentos === 0) {
            $proximaEvaluacion = $this->resolveDemoEvaluacion($periodoId);
        } else {
            // Lógica para obtener la siguiente evaluación basada en theta, etc.
            // Ejemplo simplificado: buscar una evaluación no completada
            $proximaEvaluacion = Evaluacion::where('estado_eval', 2)
                ->whereDoesntHave('intentos', function($q) use ($user) {
                    $q->where('user_id', $user->id)->where('es_correcto_int', true);
                })
                ->orderBy('id_eval') // O alguna lógica de recomendación
                ->first();
        }

        return [
            'mode' => 'student',
            'user' => $user,
            'puntajeTotal' => $puntajeTotal,
            'ultimosScores' => $ultimosScores,
            'categorias' => $categorias,
            'posicionActual' => $posicion,
            'periodoActual' => $periodoActual,
            'estHabilidad' => $estHabilidad,
            'thetaGlobal' => $thetaGlobal,
            'thetaPorCat' => $thetaPorCat,
            'nivelEstudiante' => $nivelEstudiante,
            'proximaEvaluacion' => $proximaEvaluacion, // Pasamos la próxima evaluación
        ];
    }

    private function resolveDemoEvaluacion(?int $periodoId): ?Evaluacion
    {
        $baseQuery = Evaluacion::query()->where('estado_eval', 2);

        $scopedQuery = (clone $baseQuery)
            ->when($periodoId, fn($query) => $query->where('periodo_id', $periodoId));

        $demo = $this->pickDemoEvaluacion($scopedQuery);
        if ($demo) {
            return $demo;
        }

        return $periodoId ? $this->pickDemoEvaluacion($baseQuery) : null;
    }

    private function pickDemoEvaluacion(Builder $query): ?Evaluacion
    {
        $demoQuery = (clone $query)
            ->where(function ($query) {
                $query
                    ->where('metadata_eval->es_demo', true)
                    ->orWhere('metadata_eval->demo', true)
                    ->orWhere('metadata_eval->tipo', 'demo')
                    ->orWhereHas('categoria', fn($categoria) => $categoria->where('codigo_cat', 'DEMO'));
            });

        $demoEvaluacion = $this->orderDemoCandidates($demoQuery)->first();

        if ($demoEvaluacion) {
            return $demoEvaluacion;
        }

        return $this->orderDemoCandidates($query)->first();
    }

    private function orderDemoCandidates(Builder $query)
    {
        return $query
            ->orderByRaw('fecha_inicio_eval IS NULL')
            ->orderBy('fecha_inicio_eval')
            ->orderBy('id_eval');
    }
}
