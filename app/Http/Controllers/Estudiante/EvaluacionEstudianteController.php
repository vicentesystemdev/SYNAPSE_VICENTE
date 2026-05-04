<?php

namespace App\Http\Controllers\Estudiante;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\EstHabilidad;
use App\Models\Evaluacion;
use App\Services\ItemSelectorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class EvaluacionEstudianteController extends Controller
{
    public function __construct(
        private ItemSelectorService $itemSelector
    ) {}

    public function index(): View
    {
        $userId = Auth::id();
        $nivelesPorCategoria = $this->obtenerNivelesPorCategoria($userId);
        
        return view('estudiante.evaluaciones.index', compact('nivelesPorCategoria'));
    }

    public function categorias(): View
    {
        return $this->index();
    }

    public function show(Evaluacion $evaluacion): View
    {
        $evaluacion->load(['categoria', 'dificultad']);

        return view('estudiante.evaluaciones.show', compact('evaluacion'));
    }

    public function realizar(Evaluacion $evaluacion): View
    {
        $evaluacion->load(['categoria', 'dificultad']);

        $intentos = $evaluacion->intentos()
            ->where('user_id', Auth::id())
            ->latest('id_int')
            ->take(5)
            ->get();

        return view('estudiante.evaluaciones.realizar', compact('evaluacion', 'intentos'));
    }

    public function siguienteAdaptativa(): RedirectResponse
    {
        $evaluacion = Evaluacion::where('estado_eval', 2)
            ->orderByDesc('updated_at')
            ->first();

        if (!$evaluacion) {
            return redirect()
                ->route('estudiante.evaluaciones.index')
                ->with('status', 'No hay evaluaciones publicadas disponibles actualmente.');
        }

        return redirect()->route('estudiante.evaluaciones.show', $evaluacion);
    }

    public function porCategoria(string $categoria): RedirectResponse
    {
        $categoriaModelo = $this->resolverCategoria($categoria);

        if (!$categoriaModelo) {
            return redirect()
                ->route('estudiante.evaluaciones.index')
                ->with('status', 'Categoría no disponible.');
        }

        $userId = Auth::id();
        $evaluacion = null;
        
        // Intentar usar el motor adaptativo
        try {
            $evaluacion = $this->itemSelector->seleccionarEvaluacion(
                $userId,
                $categoriaModelo->id_cat,
                null
            );
        } catch (\Exception $e) {
            Log::warning('Error en motor adaptativo, usando fallback', [
                'user_id' => $userId,
                'categoria_id' => $categoriaModelo->id_cat,
                'error' => $e->getMessage()
            ]);
        }

        // Fallback: si el motor no encuentra evaluación, usar selección simple
        if (!$evaluacion) {
            $evaluacion = Evaluacion::where('estado_eval', 2)
                ->where('categoria_id', $categoriaModelo->id_cat)
                ->orderBy('dificultad_id')
                ->orderByDesc('updated_at')
                ->first();
        }

        if (!$evaluacion) {
            return redirect()
                ->route('estudiante.evaluaciones.index')
                ->with('status', 'No hay retos publicados en esta categoría aún.');
        }

        return redirect()->route('estudiante.evaluaciones.show', $evaluacion);
    }

    public function descargarRecurso(Evaluacion $evaluacion, int $indice)
    {
        $meta = $evaluacion->metadata_eval ?? [];
        $ruta = $meta['ruta_recurso'] ?? null;
        $archivos = $meta['archivos'] ?? [];

        if (!$ruta || !array_key_exists($indice, $archivos)) {
            abort(404);
        }

        $path = trim($ruta, '/') . '/' . ltrim($archivos[$indice], '/');

        if (!Storage::disk('public')->exists($path)) {
            abort(501, 'La descarga de recursos aún no está disponible en este entorno.');
        }

        return Storage::disk('public')->download($path);
    }

    /**
     * Obtiene los niveles del estudiante por categoría
     */
    private function obtenerNivelesPorCategoria(?int $userId): array
    {
        if (!$userId) {
            return [];
        }

        $habilidad = EstHabilidad::where('user_id', $userId)->first();
        if (!$habilidad || !$habilidad->theta_por_cat) {
            return [];
        }

        $niveles = [];
        $categorias = [
            'WEB' => Categoria::where('codigo_cat', 'WEB')->first(),
            'CRYPTO' => Categoria::where('codigo_cat', 'CRYPTO')->first(),
            'STEGO' => Categoria::where('codigo_cat', 'STEGO')->first(),
            'FORENS' => Categoria::where('codigo_cat', 'FORENS')->first(),
        ];

        foreach ($categorias as $codigo => $categoria) {
            if ($categoria) {
                $nivel = $habilidad->obtenerNivelPorCategoria($categoria->id_cat);
                $niveles[$codigo] = $nivel ?? 'medio'; // Fallback a medio
            } else {
                $niveles[$codigo] = 'medio';
            }
        }

        return $niveles;
    }

    private function resolverCategoria(string $slug): ?Categoria
    {
        $slug = strtolower($slug);
        $codigo = strtoupper($slug);

        return Categoria::query()
            ->where('codigo_cat', $codigo)
            ->orWhereRaw('LOWER(nombre_cat) = ?', [$slug])
            ->first();
    }
}
