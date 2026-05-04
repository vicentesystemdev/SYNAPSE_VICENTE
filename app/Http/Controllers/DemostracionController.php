<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Categoria; // Importar el modelo Categoria
use App\Services\IrtService;
use App\Services\ItemSelectorService;
use App\Services\MarkovService; // Añadir MarkovService
use Illuminate\Http\Request; // Importar Request
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Para depuración
use App\Models\Score;  // Importar el modelo Score
use App\Models\Evaluacion; // Importar el modelo Evaluacion para la relación whereHas
use App\Models\EstHabilidad; // Importar EstHabilidad

class DemostracionController extends Controller
{
    public function __construct(
        private IrtService $irtService,
        private ItemSelectorService $itemSelector,
        private MarkovService $markovService // Inyectar MarkovService
    ) {
        // Middleware aplicado en la ruta
    }

    /**
     * Vista de demostración: muestra estudiantes bajo/medio/alto con evaluaciones asignadas
     */
    public function index()
    {
        $estudiantes = User::role('estudiante')
            ->select('id', 'name', 'app_usu', 'apm_usu') // Optimizar la selección de columnas
            ->orderBy('name')
            ->get();
        
        $categorias = Categoria::orderBy('nombre_cat')->get(); // Obtener todas las categorías
        
        // Puedes mantener la lógica de ejemplos si la necesitas para una vista general inicial
        // O simplificar para que la interfaz cargue dinámicamente al seleccionar un estudiante.
        // Por ahora, pasamos estudiantes y categorías a la vista.

        return view('admin.reportes_irt.index', [ // Asumo que la vista para esto es admin.reportes_irt.index
            'estudiantes' => $estudiantes,
            'categorias' => $categorias,
            // Puedes eliminar 'ejemplos', 'estadisticas', 'porNivel' si la nueva UI los gestiona dinámicamente
            // o adaptarlos si la UI sigue mostrando una sección inicial de ejemplos.
        ]);
    }

    /**
     * Obtiene los datos IRT y de habilidad para un estudiante específico.
     * Esto será llamado vía AJAX.
     */
    public function getStudentData(Request $request)
    {
        try { // Iniciar el bloque try
            $userId = $request->input('user_id');
            $student = User::with(['estHabilidad', 'rendimientos'])->find($userId);

            if (!$student) {
                return response()->json(['error' => 'Estudiante no encontrado'], 404);
            }

            $irtService = $this->irtService;
            $habilidad = $student->estHabilidad;

            $thetaGlobal = $habilidad ? (float) $habilidad->theta_global : 0.0;
            $nivelGlobal = $irtService->obtenerNivel($thetaGlobal);

            // MODIFICADO: $habilidad->theta_por_cat ya es un array si el modelo lo castea automáticamente.
            // Si no está casteado, esta línea sigue siendo segura.
            $thetaPorCategoria = $habilidad ? (is_string($habilidad->theta_por_cat) ? json_decode($habilidad->theta_por_cat, true) : $habilidad->theta_por_cat) : [];
            $nivelesPorCategoria = [];
            foreach ($thetaPorCategoria as $catId => $theta) {
                $categoria = Categoria::find($catId);
                
                if ($categoria) {
                    $nivelesPorCategoria[$catId] = [
                        'nombre' => $categoria->nombre_cat ?? 'Desconocida',
                        'theta' => (float) $theta,
                        'nivel' => $irtService->obtenerNivel((float) $theta),
                    ];
                } else {
                    Log::warning("Categoría ID {$catId} no encontrada para el estudiante {$userId}.");
                    $nivelesPorCategoria[$catId] = [
                        'nombre' => 'Categoría Eliminada (' . $catId . ')',
                        'theta' => (float) $theta,
                        'nivel' => $irtService->obtenerNivel((float) $theta),
                    ];
                }
            }

            // Obtener rendimiento EMA por categoría
            // Asegurarse de que $student->rendimientos es una colección válida
            $emasPorCategoria = $student->rendimientos ? $student->rendimientos->keyBy('categoria_id')->map(function($rendimiento) {
                return [
                    'ema' => (float) $rendimiento->r_ema,
                    'muestras' => (int) $rendimiento->muestras_r,
                ];
            }) : collect(); // Si no hay rendimientos, retornar una colección vacía

            // Obtener recomendaciones de evaluación para el estudiante
            $recomendaciones = $this->itemSelector->obtenerEvaluacionesRecomendadas($userId);

            return response()->json([
                'student' => [
                    'id' => $student->id,
                    'name' => $student->name . ' ' . $student->app_usu . ' ' . $student->apm_usu,
                    'email' => $student->email,
                ],
                'habilidad' => [
                    'theta_global' => $thetaGlobal,
                    'nivel_global' => $nivelGlobal,
                    'theta_por_categoria' => $nivelesPorCategoria,
                    'ema_por_categoria' => $emasPorCategoria,
                ],
                'recomendaciones' => $recomendaciones->map(function($rec) {
                    return [
                        'id' => $rec['evaluacion']->id_eval,
                        'titulo' => $rec['evaluacion']->titulo_eval,
                        // Asegurarse de que categoria y dificultad existan antes de acceder a sus propiedades
                        'categoria' => optional($rec['evaluacion']->categoria)->nombre_cat ?? 'N/A',
                        'dificultad' => optional($rec['evaluacion']->dificultad)->nombre_dif ?? 'N/A',
                        'razon' => $rec['razon'],
                    ];
                }),
            ]);

        } catch (\Exception $e) { // Bloque catch para capturar cualquier excepción
            Log::error("Error en getStudentData para user_id: {$userId}. Mensaje: " . $e->getMessage() . " en " . $e->getFile() . " línea " . $e->getLine() . ". Stack Trace: " . $e->getTraceAsString());
            return response()->json(['error' => 'Error interno del servidor al obtener datos del estudiante. Por favor, revise los logs.'], 500);
        }
    }

    /**
     * Obtiene la matriz de transición de Markov para una categoría específica.
     * Esto será llamado vía AJAX.
     */
    public function getMarkovMatrix(Request $request)
    {
        $categoriaId = $request->input('categoria_id');
        $tipo = $request->input('tipo', 'global'); // 'global' o 'user'
        $userId = $request->input('user_id'); // Solo si tipo es 'user'

        $matriz = $this->markovService->calcularMatrizTransicion((int) $categoriaId, $tipo, $userId);

        return response()->json([
            'matriz' => $matriz,
            'estados' => ['bajo', 'medio', 'alto'], // Definir los estados para la UI
        ]);
    }

    /**
     * Obtiene la distribución global de niveles de habilidad (Bajo, Medio, Alto)
     * para todos los estudiantes con theta calculado.
     * Esto será llamado vía AJAX.
     */
    public function getGlobalHabilidadDistribution()
    {
        $irtService = $this->irtService;

        $estudiantesConHabilidad = User::role('estudiante')
            ->has('estHabilidad')
            ->with('estHabilidad')
            ->get();

        $distribution = [
            'bajo' => 0,
            'medio' => 0,
            'alto' => 0,
        ];

        foreach ($estudiantesConHabilidad as $student) {
            $thetaGlobal = (float) $student->estHabilidad->theta_global;
            $nivel = $irtService->obtenerNivel($thetaGlobal);
            if (isset($distribution[$nivel])) {
                $distribution[$nivel]++;
            }
        }

        return response()->json(['dataCounts' => $distribution]);
    }

    /**
     * Obtiene el historial de EMA y Theta para un estudiante en una categoría específica.
     * Esto será llamado vía AJAX para el gráfico de crecimiento/decaimiento.
     */
    public function getGrowthDecayHistory(Request $request)
    {
        $userId = $request->input('user_id');
        $categoriaId = $request->input('categoria_id');

        if (!$userId || !$categoriaId) {
            return response()->json(['error' => 'ID de usuario o categoría no proporcionado.'], 400);
        }

        $history = Score::where('user_id', $userId)
            ->whereHas('evaluacion', function ($query) use ($categoriaId) {
                $query->where('categoria_id', $categoriaId);
            })
            ->orderBy('created_at', 'asc') // Ordenar por fecha para ver el progreso
            ->get()
            ->map(function ($score) {
                $meta = is_string($score->calculo_meta) ? json_decode($score->calculo_meta, true) : $score->calculo_meta;

                return [
                    'fecha' => $score->created_at->format('d/m/Y H:i'),
                    'ema' => (float) ($meta['ema_post'] ?? 0), // MODIFICADO: Ahora busca 'ema_post'
                    'theta' => (float) ($meta['irt']['theta_cat'] ?? 0), // MODIFICADO: Ahora busca 'irt.theta_cat'
                ];
            });

        if ($history->isEmpty()) {
            return response()->json(['message' => 'No hay historial de intentos para esta categoría y estudiante.'], 200);
        }

        return response()->json(['history' => $history]);
    }

    /**
     * Busca estudiantes por nombre, apellidos o email para el selector de autocompletado.
     * Esto será llamado vía AJAX por Select2.
     */
    public function searchStudents(Request $request)
    {
        $search = $request->input('search');

        $students = User::role('estudiante')
            ->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('app_usu', 'LIKE', '%' . $search . '%')
                    ->orWhere('apm_usu', 'LIKE', '%' . $search . '%')
                    ->orWhere('email', 'LIKE', '%' . $search . '%');
            })
            // Opcional: solo incluir estudiantes que tienen datos de habilidad
            ->has('estHabilidad') 
            ->select('id', 'name', 'app_usu', 'apm_usu', 'email')
            ->limit(20) // Limitar los resultados para mejor rendimiento
            ->get();

        return response()->json($students);
    }
}

