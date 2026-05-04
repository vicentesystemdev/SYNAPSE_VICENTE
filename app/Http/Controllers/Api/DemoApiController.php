<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\{Evaluacion, Intento, Score, EstHabilidad, Categoria};
use App\Services\{ItemSelectorService, ScoringService, IrtService};
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class DemoApiController extends Controller
{
    public function __construct(
        private ItemSelectorService $selector,
        private ScoringService $scoring,
        private IrtService $irt
    ) {
        // Para demo, se asume autenticación gestionada por sesión; aquí no forzamos middleware
    }

    /**
     * POST /api/evaluaciones/{evaluacion}/start
     * Devuelve metadatos de la evaluación y parámetros IRT (a,b) por defecto si faltan.
     */
    public function start(Request $request, Evaluacion $evaluacion): JsonResponse
    {
        $userId = (int) ($request->input('user_id') ?? Auth::id());
        $irt = $evaluacion->irtParametros;
        $a = $irt?->a_discriminacion ?? 1.0;
        $b = $irt?->b_dificultad ?? $this->mapearDificultadAB($evaluacion->dificultad_id);

        return response()->json([
            'evaluacion' => [
                'id' => $evaluacion->id_eval,
                'titulo' => $evaluacion->titulo_eval,
                'categoria_id' => $evaluacion->categoria_id,
                'dificultad_id' => $evaluacion->dificultad_id,
                'puntaje_base' => (float) $evaluacion->puntaje_base_eval,
            ],
            'irt' => [
                'a' => (float) $a,
                'b' => (float) $b,
            ],
            'user_id' => $userId,
        ]);
    }

    /**
     * POST /api/intentos
     * Crea un intento, procesa scoring+IRT y devuelve el cálculo meta.
     */
    public function submitAttempt(Request $request): JsonResponse
    {
        $request->validate([
            'evaluacion_id' => 'required|integer|exists:evaluaciones,id_eval',
            'user_id' => 'required|integer|exists:users,id',
            'respuesta' => 'nullable|string',
            'tiempo_envio' => 'nullable|integer',
        ]);

        $evaluacion = Evaluacion::findOrFail((int) $request->input('evaluacion_id'));
        $userId = (int) $request->input('user_id');
        $respuesta = (string) ($request->input('respuesta') ?? '');
        $now = now();

        $esCorrecto = $evaluacion->flag_hash_eval
            ? (hash('md5', $respuesta) === strtolower($evaluacion->flag_hash_eval))
            : false;

        $nro = Intento::where('user_id', $userId)
            ->where('evaluacion_id', $evaluacion->id_eval)
            ->count() + 1;

        $latencia = $evaluacion->fecha_inicio_eval ? $evaluacion->fecha_inicio_eval->diffInSeconds($now, false) : null;

        $intento = Intento::create([
            'evaluacion_id' => $evaluacion->id_eval,
            'user_id' => $userId,
            'respuesta_flag_int' => $respuesta,
            'es_correcto_int' => $esCorrecto,
            'nro_intento_int' => $nro,
            'tiempo_envio_int' => $now->timestamp,
            'latencia_seg_int' => $latencia !== null ? max(0, (float) $latencia) : null,
        ]);

        $this->scoring->procesarIntento($intento);

        $score = Score::where('user_id', $userId)
            ->where('evaluacion_id', $evaluacion->id_eval)
            ->first();

        return response()->json([
            'ok' => true,
            'score' => $score?->only(['puntaje','porcentaje','calculo_meta']) ?? null,
        ]);
    }

    /**
     * GET /api/users/{user}/scores
     * Devuelve resumen θ por categoría y θ global, y últimos scores.
     */
    public function userScores(int $user): JsonResponse
    {
        $habilidad = EstHabilidad::where('user_id', $user)->first();
        $scores = Score::with('evaluacion')
            ->where('user_id', $user)
            ->orderByDesc('updated_at')
            ->take(10)
            ->get()
            ->map(fn($s) => [
                'evaluacion' => $s->evaluacion?->titulo_eval,
                'puntaje' => (float) $s->puntaje,
                'porcentaje' => (float) $s->porcentaje,
                'meta' => $s->calculo_meta,
            ]);

        return response()->json([
            'user_id' => $user,
            'theta_global' => $habilidad?->theta_global,
            'theta_por_cat' => $habilidad?->theta_por_cat ?? [],
            'scores' => $scores,
        ]);
    }

    private function mapearDificultadAB(?int $dificultadId): float
    {
        $mapeo = [1 => -2.0, 2 => -1.0, 3 => 0.0, 4 => 1.0, 5 => 2.0];
        return $mapeo[$dificultadId ?? 3] ?? 0.0;
    }
}
