<?php

namespace App\Http\Controllers\AdminDashboard; // Ajusta el namespace si lo creas en otra subcarpeta

use App\Http\Controllers\Controller;
use App\Models\Categoria; // <-- Añade esta línea
use App\Models\EstHabilidad;
use App\Models\User;
use App\Services\IrtService;
use App\Services\ItemSelectorService;
use App\Services\MarkovService;
use Illuminate\Http\Request;

class AdminIrtReportesController extends Controller
{
    public function __construct(
        private IrtService $irtService,
        private ItemSelectorService $itemSelectorService,
        private MarkovService $markovService
    ) {
    }

    public function index(Request $request)
    {
        // Obtener todas las categorías para el filtro
        $categorias = Categoria::orderBy('nombre_cat')->get();

        // Obtener el ID de categoría de la petición o usar la primera por defecto
        $selectedCategoriaId = $request->input('categoria_id');

        // Si no se selecciona una categoría, usa la primera disponible
        if (empty($selectedCategoriaId) && $categorias->isNotEmpty()) {
            $selectedCategoriaId = $categorias->first()->id_cat;
        }

        // Obtener la distribución de estudiantes por nivel de habilidad (theta global)
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
        $habilidadData = array_values($orderedHabilidad);
        $habilidadLabels = array_keys($orderedHabilidad);

        $markovMatrix = [];
        // Calcular la matriz de Markov solo si hay una categoría seleccionada y válida
        if ($selectedCategoriaId > 0) {
            $markovMatrix = $this->markovService->calcularMatrizTransicion($selectedCategoriaId);
        }
        
        // Obtener estudiantes por niveles para mostrar tablas
        $estudiantesPorNivel = User::role('estudiante')
            ->with('estHabilidad')
            ->get()
            ->groupBy(function ($user) {
                return $user->estHabilidad ? $user->estHabilidad->obtenerNivel() : 'N/D';
            });

        return view('admin.reportes_irt.index', [
            'habilidadData' => $habilidadData,
            'habilidadLabels' => $habilidadLabels,
            'markovMatrix' => $markovMatrix,
            'estudiantesPorNivel' => $estudiantesPorNivel,
            'categorias' => $categorias, // Pasar todas las categorías
            'selectedCategoriaId' => $selectedCategoriaId, // Pasar la categoría seleccionada
        ]);
    }

    // Puedes añadir otros métodos aquí para reportes más específicos
    public function detalleEstudiante(User $user)
    {
        // Lógica para mostrar el detalle IRT de un estudiante específico
        // ...
    }
}