<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Evaluacion;
use App\Models\Intento;
use App\Services\ItemSelectorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalibrationController extends Controller
{
    public function __construct(private ItemSelectorService $itemSelectorService)
    {
    }

    public function index()
    {
        $user = Auth::user();
        $totalIntentos = Intento::where('user_id', $user->id)->count();
        $restantes = 5 - $totalIntentos;

        if ($restantes <= 0) {
            return redirect()->route('dashboard');
        }

        return view('estudiante.calibration.index', [
            'totalIntentos' => $totalIntentos,
            'restantes' => $restantes,
            'progreso' => ($totalIntentos / 5) * 100
        ]);
    }

    public function start()
    {
        $user = Auth::user();
        
        // 1. Intentar usar el selector inteligente (ItemSelectorService)
        // El selector ya maneja la lógica de "exploración" para usuarios nuevos
        $categoriaId = $this->itemSelectorService->seleccionarCategoria($user->id);
        
        if ($categoriaId) {
            $evaluacion = $this->itemSelectorService->seleccionarEvaluacion($user->id, $categoriaId);
            
            if ($evaluacion) {
                return redirect()->route('estudiante.evaluaciones.realizar', $evaluacion);
            }
        }

        // 2. Fallback: Si el selector no devuelve nada (raro), buscar cualquier evaluación fácil
        $evaluacionFacil = Evaluacion::where('estado_eval', 2)
            ->where('dificultad_id', 1) // Fácil
            ->inRandomOrder()
            ->first();

        if ($evaluacionFacil) {
             return redirect()->route('estudiante.evaluaciones.realizar', $evaluacionFacil);
        }

        // 3. Fallback final: Cualquier evaluación
        $cualquiera = Evaluacion::where('estado_eval', 2)->inRandomOrder()->first();
        
        if ($cualquiera) {
            return redirect()->route('estudiante.evaluaciones.realizar', $cualquiera);
        }

        return back()->with('error', 'No hay evaluaciones disponibles para calibración.');
    }

    public function skip(Request $request)
    {
        $user = Auth::user();
        $evaluacionId = $request->input('evaluacion_id');

        if (!$evaluacionId) {
            return back()->with('error', 'Evaluación no especificada.');
        }

        // Registrar intento fallido (SKIP)
        // Esto es importante para el IRT: indica que el usuario no pudo resolverlo
        $intento = Intento::create([
            'evaluacion_id' => $evaluacionId,
            'user_id' => $user->id,
            'respuesta_flag_int' => 'SKIP_CALIBRATION',
            'es_correcto_int' => false,
            'nro_intento_int' => 1, // Siempre 1 en calibración para evitar penalizaciones de reintento
            'tiempo_envio_int' => now()->timestamp,
            'latencia_seg_int' => 0,
            'meta_int' => json_encode(['skipped' => true, 'reason' => 'calibration_skip']),
        ]);

        // Procesar el intento (actualizará Theta y contará como intento realizado)
        // Necesitamos inyectar ScoringService
        $scoringService = app(\App\Services\ScoringService::class);
        $scoringService->procesarIntento($intento);

        return redirect()->route('estudiante.calibracion.index');
    }
}
