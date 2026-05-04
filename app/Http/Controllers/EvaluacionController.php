<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEvaluacionRequest;
use App\Http\Requests\UpdateEvaluacionRequest;
use App\Models\{Evaluacion, Categoria, Dificultad, Periodo, Score, User};
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EvaluacionController extends Controller
{
    // El middleware se aplica en las rutas (routes/web.php)
    // usando Route::middleware(['role:admin|docente'])

    public function index(Request $request)
    {
        if (Auth::user()->hasRole('estudiante')) {
            return redirect()->route('estudiante.evaluaciones.index');
        }

        $evaluaciones = Evaluacion::with(['categoria', 'dificultad', 'periodo', 'docente'])
            ->withCount([
                'intentos as intentos_totales_count',
                'intentos as intentos_correctos_count' => fn ($qq) => $qq->where('es_correcto_int', true),
            ])
            ->when($request->filled('categoria_id'), fn($qq) => $qq->where('categoria_id', $request->categoria_id))
            ->when($request->filled('estado_eval'), fn($qq) => $qq->where('estado_eval', $request->estado_eval))
            ->orderByDesc('id_eval')
            ->paginate(10)
            ->withQueryString();

        $categorias = Categoria::orderBy('nombre_cat')->get();

        $view = Auth::user()->hasRole('admin') 
            ? 'admin.evaluaciones.index' 
            : 'docente.evaluaciones.index';

        return view($view, compact('evaluaciones', 'categorias'));
    }

    public function create()
    {
        $categorias = Categoria::orderBy('nombre_cat')->get();
        $dificultades = Dificultad::orderBy('orden_dif')->get();
        $periodos = Periodo::orderByDesc('id_per')->get();
        $docentes = User::role(['admin', 'docente'])->orderBy('name')->get();

        $view = Auth::user()->hasRole('admin') 
            ? 'admin.evaluaciones.create' 
            : 'docente.evaluaciones.create';

        return view($view, compact('categorias', 'dificultades', 'periodos', 'docentes'));
    }

    public function store(StoreEvaluacionRequest $request)
    {
        $payload = $request->validated();
        $this->assertVentanaDisponible($payload);

        if ($request->hasFile('archivo_adjunto')) {
            $path = $request->file('archivo_adjunto')->store('evaluaciones', 'public');
            $payload['archivo_adjunto'] = $path;
        }

        $eval = Evaluacion::create($payload);
        $route = Auth::user()->hasRole('docente') ? 'docente.evaluaciones.index' : 'evaluaciones.index';
        return redirect()->route($route)->with('ok', 'Evaluación creada (#' . $eval->id_eval . ')');
    }

    /**
     * Vista para realizar la evaluación (trabajo del estudiante)
     * Enfocada en mostrar el desafío y permitir entregar la flag
     */
    public function realizar(Evaluacion $evaluacion)
    {
        $evaluacion->load(['categoria', 'dificultad', 'periodo', 'docente']);

        // Obtener estadísticas básicas del usuario para esta evaluación
        $statsUsuario = null;
        if (Auth::check()) {
            $statsUsuario = $evaluacion->intentos()
                ->where('user_id', Auth::id())
                ->selectRaw('COUNT(*) as total_intentos')
                ->selectRaw('SUM(CASE WHEN es_correcto_int = 1 THEN 1 ELSE 0 END) as correctos')
                ->selectRaw('SUM(CASE WHEN es_correcto_int = 0 THEN 1 ELSE 0 END) as incorrectos')
                ->first();
        }

        // Verificar si la evaluación está disponible
        $now = now();
        $disponible = true;
        $mensajeDisponibilidad = null;

        if ($evaluacion->estado_eval !== 2) {
            $disponible = false;
            $mensajeDisponibilidad = 'Esta evaluación no está publicada.';
        } elseif ($evaluacion->fecha_inicio_eval && $now->lt($evaluacion->fecha_inicio_eval)) {
            $disponible = false;
            $mensajeDisponibilidad = 'La evaluación aún no está disponible.';
        } elseif ($evaluacion->fecha_fin_eval && $now->gt($evaluacion->fecha_fin_eval)) {
            $disponible = false;
            $mensajeDisponibilidad = 'La ventana de entrega ya cerró.';
        }

        return view('estudiante.evaluaciones.realizar', compact(
            'evaluacion',
            'statsUsuario',
            'disponible',
            'mensajeDisponibilidad'
        ));
    }

    /**
     * Vista de detalles y estadísticas (sin formulario de entrega)
     */
    public function show(Evaluacion $evaluacion)
    {
        if (Auth::user()->hasRole('estudiante')) {
            return redirect()->route('estudiante.evaluaciones.show', $evaluacion);
        }

        $evaluacion->load(['categoria', 'dificultad', 'periodo', 'docente']);

        $intentosRecientes = $evaluacion->intentos()
            ->with('user')
            ->orderByDesc(DB::raw('COALESCE(tiempo_envio_int, UNIX_TIMESTAMP(created_at))'))
            ->orderByDesc('id_int')
            ->take(10)
            ->get();

        $resumenIntentos = $evaluacion->intentos()
            ->select('user_id')
            ->selectRaw('COUNT(*) as total_intentos')
            ->selectRaw('SUM(CASE WHEN es_correcto_int = 1 THEN 1 ELSE 0 END) as correctos')
            ->selectRaw('SUM(CASE WHEN es_correcto_int = 0 THEN 1 ELSE 0 END) as incorrectos')
            ->selectRaw('MAX(COALESCE(tiempo_envio_int, UNIX_TIMESTAMP(created_at))) as ultimo_envio')
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('correctos')
            ->orderByDesc('total_intentos')
            ->get();

        $statsUsuario = null;
        if (Auth::check()) {
            $statsUsuario = $resumenIntentos->firstWhere('user_id', Auth::id());
        }

        $rankingGeneral = Score::select('user_id')
            ->selectRaw('SUM(puntaje) as puntaje_total')
            ->selectRaw('COUNT(*) as retos_resueltos')
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('puntaje_total')
            ->take(10)
            ->get();

        $view = Auth::user()->hasRole('admin') 
            ? 'admin.evaluaciones.show' 
            : 'docente.evaluaciones.show';

        return view($view, compact(
            'evaluacion',
            'intentosRecientes',
            'resumenIntentos',
            'statsUsuario',
            'rankingGeneral'
        ));
    }

    public function edit(Evaluacion $evaluacion)
    {
        $categorias = Categoria::orderBy('nombre_cat')->get();
        $dificultades = Dificultad::orderBy('orden_dif')->get();
        $periodos = Periodo::orderByDesc('id_per')->get();
        $docentes = User::role(['admin', 'docente'])->orderBy('name')->get();

        $view = Auth::user()->hasRole('admin') 
            ? 'admin.evaluaciones.edit' 
            : 'docente.evaluaciones.edit';

        return view($view, compact('evaluacion', 'categorias', 'dificultades', 'periodos', 'docentes'));
    }

    public function update(UpdateEvaluacionRequest $request, Evaluacion $evaluacion)
    {
        $payload = $request->validated();
        $this->assertVentanaDisponible($payload);

        if ($request->hasFile('archivo_adjunto')) {
            $path = $request->file('archivo_adjunto')->store('evaluaciones', 'public');
            $payload['archivo_adjunto'] = $path;
        }

        $evaluacion->update($payload);
        $route = Auth::user()->hasRole('docente') ? 'docente.evaluaciones.index' : 'evaluaciones.index';
        return redirect()->route($route)->with('ok', 'Evaluación actualizada');
    }

    public function destroy(Evaluacion $evaluacion)
    {
        $evaluacion->delete();
        return back()->with('ok', 'Evaluación eliminada');
    }

    public function toggleStatus(Request $request, Evaluacion $evaluacion)
    {
        $request->validate([
            'estado_eval' => 'required|integer|in:0,1,2',
        ]);

        $evaluacion->update(['estado_eval' => $request->estado_eval]);

        return back()->with('ok', 'Estado actualizado correctamente');
    }

    private function assertVentanaDisponible(array $payload): void
    {
        if (($payload['estado_eval'] ?? null) !== 2) {
            return;
        }

        if (empty($payload['fecha_inicio_eval']) || empty($payload['fecha_fin_eval'])) {
            return;
        }

        $inicio = Carbon::parse($payload['fecha_inicio_eval']);
        $fin = Carbon::parse($payload['fecha_fin_eval']);
        $now = now();

        if ($now->lt($inicio) || $now->gt($fin)) {
            throw ValidationException::withMessages([
                'fecha_inicio_eval' => 'Para publicar la evaluación la ventana debe incluir la fecha y hora actual.',
            ]);
        }
    }
}
