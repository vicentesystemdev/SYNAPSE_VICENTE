<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIntentoRequest;
use App\Models\Evaluacion;
use App\Models\Intento;
use App\Services\ScoringService;
use App\Services\FlagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class IntentoController extends Controller
{
    public function __construct(private ScoringService $scoring)
    {
    }

    public function historial(): View
    {
        $intentos = Intento::with(['evaluacion.categoria'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('estudiante.intentos.index', compact('intentos'));
    }

    public function storeDesdeEstudiante(Request $request, Evaluacion $evaluacion): RedirectResponse
    {
        $validated = $request->validate([
            'flag' => ['required', 'string', 'regex:/^synapse\{.+\}$/i'],
        ], [
            'flag.regex' => 'La flag debe tener el formato synapse{...}.',
        ]);

        $flagUser = trim($validated['flag']);
        $userId = Auth::id();

        $esCorrecto = false;
        if ($evaluacion->solution_md5) {
            $esCorrecto = FlagService::validate($flagUser, $evaluacion->solution_md5);
        } elseif ($evaluacion->flag_hash_eval) {
            $esCorrecto = hash('md5', $flagUser) === strtolower($evaluacion->flag_hash_eval);
        }

        $nro = Intento::where('user_id', $userId)
            ->where('evaluacion_id', $evaluacion->id_eval)
            ->count() + 1;

        $now = now();
        
        // Usar latencia enviada desde el formulario (tracking JavaScript)
        // Si no está disponible, usar null
        $latencia = $request->input('latencia_segundos', null);

        $intento = Intento::create([
            'evaluacion_id'      => $evaluacion->id_eval,
            'user_id'            => $userId,
            'respuesta_flag_int' => $flagUser,
            'es_correcto_int'    => $esCorrecto,
            'nro_intento_int'    => $nro,
            'tiempo_envio_int'   => $now->timestamp,
            'latencia_seg_int'   => $latencia !== null ? (int) $latencia : null,
        ]);

        $this->scoring->procesarIntento($intento);

        // Si es correcto, redirigir al índice de evaluaciones
        if ($esCorrecto) {
            return redirect()
                ->route('estudiante.evaluaciones.index')
                ->with('status', '¡Flag correcta! Has completado esta evaluación.');
        }

        // Si es incorrecto, volver a la vista de realizar
        session()->flash('status', 'incorrecta');
        session()->flash('mensaje', 'Flag incorrecta, intenta nuevamente.');

        return redirect()->route('estudiante.evaluaciones.realizar', $evaluacion->id_eval);
    }

    public function store(StoreIntentoRequest $request, Evaluacion $evaluacion): RedirectResponse
    {
        $now = now();
        if ($evaluacion->fecha_inicio_eval && $now->lt($evaluacion->fecha_inicio_eval)) {
            return back()->withErrors(['respuesta_flag_int' => 'La evaluación aún no está disponible.']);
        }
        if ($evaluacion->fecha_fin_eval && $now->gt($evaluacion->fecha_fin_eval)) {
            return back()->withErrors(['respuesta_flag_int' => 'La ventana de entrega ya cerró.']);
        }

        $userId = Auth::id();
        $flagUser = trim($request->input('respuesta_flag_int'));
        $intentosPrevios = Intento::where('user_id', $userId)->count();

        // Validar flag usando FlagService (formato synapse{md5})
        // Si solution_md5 existe, usarlo; si no, usar flag_hash_eval para retrocompatibilidad
        if ($evaluacion->solution_md5) {
            $esCorrecto = FlagService::validate($flagUser, $evaluacion->solution_md5);
        } elseif ($evaluacion->flag_hash_eval) {
            // Retrocompatibilidad: validar MD5 directo
            $esCorrecto = hash('md5', $flagUser) === strtolower($evaluacion->flag_hash_eval);
        } else {
            $esCorrecto = false;
        }

        $nro = Intento::where('user_id', $userId)
            ->where('evaluacion_id', $evaluacion->id_eval)
            ->count() + 1;

        // Usar latencia enviada desde el formulario (tracking JavaScript)
        $latencia = $request->input('latencia_segundos', null);

        $intento = Intento::create([
            'evaluacion_id'      => $evaluacion->id_eval,
            'user_id'            => $userId,
            'respuesta_flag_int' => $flagUser,
            'es_correcto_int'    => $esCorrecto,
            'nro_intento_int'    => $nro,
            'tiempo_envio_int'   => $now->timestamp,
            'latencia_seg_int'   => $latencia !== null ? (int) $latencia : null,
        ]);

        $this->scoring->procesarIntento($intento);

        if ($intentosPrevios === 0) {
            return redirect()
                ->route('evaluaciones.index')
                ->with('status', $esCorrecto
                    ? '¡Correcto! Ya puedes continuar con el resto de evaluaciones.'
                    : 'Primer intento registrado. Revisa las demás evaluaciones disponibles.');
        }

        return back()->with('status', $esCorrecto ? '¡Correcto!' : 'Incorrecto, intenta de nuevo.');
    }
}
