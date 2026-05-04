<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Intento; // Modelo para los intentos
use App\Models\User; // Para obtener información del usuario
use App\Models\Evaluacion; // Para obtener información de la evaluación
use App\Models\Score; // Asegúrate de importar el modelo Score
use Barryvdh\DomPDF\Facade\Pdf; // Importar la clase PDF de DomPDF

class IntentoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Cargar relaciones user y evaluacion, y dentro de evaluacion, la relacion categoria
        $query = Intento::with(['user', 'evaluacion.categoria']); 

        // Filtro por búsqueda (nombre de estudiante o nombre de evaluación)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function ($qUser) use ($search) {
                    $qUser->where('name', 'like', '%' . $search . '%')
                          ->orWhere('app_usu', 'like', '%' . $search . '%')
                          ->orWhere('apm_usu', 'like', '%' . $search . '%');
                })
                ->orWhereHas('evaluacion', function ($qEvaluacion) use ($search) {
                    $qEvaluacion->where('titulo_eval', 'like', '%' . $search . '%'); // CAMBIADO DE 'nombre_eval' A 'titulo_eval'
                });
            });
        }

        // Filtro por estado del intento (es_correcto_int)
        if ($request->filled('status')) {
            $status = $request->input('status');
            if (in_array($status, ['1', '0'])) { // Asegurarse de que el estado es '1' o '0'
                $query->where('es_correcto_int', (bool)$status);
            }
        }

        // Filtro por ID de evaluación específica
        if ($request->filled('evaluacion_id')) {
            $evaluacionId = $request->input('evaluacion_id');
            $query->where('evaluacion_id', $evaluacionId);
        }

        // Lógica de ordenamiento
        $sortBy = $request->input('sort_by', 'id_int'); // Columna por defecto para ordenar
        $sortDirection = $request->input('sort_direction', 'asc'); // Dirección por defecto

        // Validar que la columna sea permitida para ordenar
        $allowedSortColumns = ['id_int', 'nro_intento_int', 'tiempo_envio_int', 'latencia_seg_int']; // Añade otras columnas si quieres ordenar por ellas
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id_int'; // Usar por defecto si la columna no es válida
        }
        
        $query->orderBy($sortBy, $sortDirection);

        $intentos = $query->paginate(15);
        
        // Obtener todas las evaluaciones para el filtro de select
        $evaluaciones = Evaluacion::orderBy('titulo_eval')->get(['id_eval', 'titulo_eval']); // CAMBIADO DE 'nombre_eval' A 'titulo_eval'

        return view('admin.intentos.index', compact('intentos', 'evaluaciones'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Intento $intento)
    {
        // Cargar relaciones para la vista de detalle
        $intento->load(['user', 'evaluacion.categoria']);

        // Buscar el Score asociado a este intento.
        // Asumimos que un Intento se corresponde con un Score por user_id y evaluacion_id.
        // Si hay varios scores para la misma evaluacion y usuario, tomamos el más reciente.
        $score = Score::where('user_id', $intento->user_id)
                      ->where('evaluacion_id', $intento->evaluacion_id)
                      ->orderByDesc('updated_at') // Tomar el score más reciente
                      ->first();

        return view('admin.intentos.show', compact('intento', 'score')); // Pasar 'score' a la vista
    }

    /**
     * Generate a PDF report for a single attempt.
     */
    public function exportPdfShow(Intento $intento)
    {
        $intento->load(['user', 'evaluacion.categoria']);
        $score = Score::where('user_id', $intento->user_id)
                      ->where('evaluacion_id', $intento->evaluacion_id)
                      ->orderByDesc('updated_at') // Tomar el score más reciente
                      ->first();

        // Asegurarse de que $score tenga el atributo calculo_meta o manejar su ausencia
        if ($score && !isset($score->calculo_meta)) {
            $score->calculo_meta = null; // O un valor por defecto adecuado
        }

        $pdf = Pdf::loadView('admin.intentos.show_pdf_report', compact('intento', 'score'));
        return $pdf->download('reporte_intento_' . $intento->id_int . '_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Generate a PDF report of filtered attempts.
     */
    public function exportPdf(Request $request)
    {
        $query = Intento::with(['user', 'evaluacion']); // Cargar relaciones user y evaluacion

        // Aplicar los mismos filtros que en el método index
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

        $intentos = $query->latest('tiempo_envio_int')->get(); // Obtener todos los intentos filtrados (sin paginación para el PDF)

        $pdf = Pdf::loadView('admin.intentos.pdf_report', compact('intentos')); // Cargar la vista para el PDF
        return $pdf->download('auditoria_intentos_' . now()->format('Ymd_His') . '.pdf'); // Descargar el PDF
    }

    // Otros métodos CRUD (create, store, edit, update, destroy) pueden no ser necesarios
    // para la auditoría de intentos, ya que los intentos se crean y modifican a través de
    // el IntentoController principal cuando un estudiante los realiza.
}