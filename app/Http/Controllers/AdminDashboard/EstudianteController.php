<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\User; // Asumo que se usará el modelo User
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // Para asignar roles
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Añadir para logging
use Barryvdh\DomPDF\Facade\Pdf; // Importar la clase PDF de DomPDF
use Maatwebsite\Excel\Facades\Excel; // Importar la fachada de Laravel Excel
use App\Exports\EstudiantesExport; // Crearemos esta clase más adelante para Excel

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::role('estudiante');

        // Lógica de búsqueda
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('app_usu', 'like', '%' . $search . '%')
                  ->orWhere('apm_usu', 'like', '%' . $search . '%');
            });
        }

        // Lógica de filtro por estado
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('activo_usu', (bool)$status);
        }

        // Lógica de ordenamiento
        $sortBy = $request->input('sort_by', 'id'); // Columna por defecto para ordenar es 'id'
        $sortDirection = $request->input('sort_direction', 'asc'); // Dirección por defecto

        // Validar que la columna sea permitida para ordenar
        $allowedSortColumns = ['id', 'name', 'app_usu', 'apm_usu', 'email', 'activo_usu']; // Añade otras columnas si quieres ordenar por ellas
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id'; // Usar por defecto si la columna no es válida
        }
        
        $query->orderBy($sortBy, $sortDirection);

        $estudiantes = $query->paginate(10); // Obtener usuarios con rol 'estudiante' y aplicar paginación
        return view('admin.usuarios.estudiantes.index', compact('estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.usuarios.estudiantes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'app_usu' => 'required|string|max:255',
            'apm_usu' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^lpze\\.[a-zA-Z0-9._%+-]+@unifranz\\.edu\\.bo$/'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // al menos una letra minúscula
                'regex:/[A-Z]/',      // al menos una letra mayúscula
                'regex:/[0-9]/',      // al menos un número
            ],
        ]);

        $user = User::create([
            'name' => $request->name,
            'app_usu' => $request->app_usu,
            'apm_usu' => $request->apm_usu,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'activo_usu' => true, // Por defecto activo
        ]);

        $user->assignRole('estudiante'); // Asignar el rol 'estudiante'

        return redirect()->route('admin.estudiantes.index')->with('success', 'Estudiante creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estudiante = User::role('estudiante')->findOrFail($id);
        return view('admin.usuarios.estudiantes.show', compact('estudiante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $estudiante = User::role('estudiante')->findOrFail($id);
        $allowedRoles = Role::whereIn('name', ['admin', 'docente'])->pluck('name', 'name'); // Roles a los que un estudiante puede cambiar
        $currentRole = $estudiante->getRoleNames()->first(); // Obtener el rol principal actual
        return view('admin.usuarios.estudiantes.edit', compact('estudiante', 'allowedRoles', 'currentRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $estudiante = User::role('estudiante')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'app_usu' => 'required|string|max:255',
            'apm_usu' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $estudiante->id, 'regex:/^lpze\\.[a-zA-Z0-9._%+-]+@unifranz\\.edu\\.bo$/'],
            // La validación de la contraseña se elimina de aquí ya que no se edita directamente.
            /*
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // al menos una letra minúscula
                'regex:/[A-Z]/',      // al menos una letra mayúscula
                'regex:/[0-9]/',      // al menos un número
            ],
            */
        ]);

        $estudiante->name = $request->name;
        $estudiante->app_usu = $request->app_usu;
        $estudiante->apm_usu = $request->apm_usu;
        $estudiante->email = $request->email;

        // Lógica para cambiar el rol
        if ($request->filled('role') && $request->role !== $estudiante->getRoleNames()->first()) {
            $estudiante->syncRoles([]); // Remover todos los roles actuales
            $estudiante->assignRole($request->role); // Asignar el nuevo rol
        }

        // La lógica para actualizar la contraseña se elimina de aquí ya que no se edita directamente.
        /*
        if ($request->filled('password')) {
            $estudiante->password = bcrypt($request->password);
        }
        */
        $estudiante->save();

        return redirect()->route('admin.estudiantes.index')->with('success', 'Estudiante actualizado exitosamente.');
    }

    /**
     * Toggle the activo_usu status of the specified estudiante.
     */
    public function toggleStatus(string $id)
    {
        Log::info('Inicio de toggleStatus para estudiante ID: ' . $id);
        $estudiante = User::role('estudiante')->findOrFail($id);
        Log::info('Estudiante encontrado: ', ['id' => $estudiante->id, 'activo_usu_antes' => $estudiante->activo_usu]);
        $estudiante->activo_usu = !$estudiante->activo_usu;
        Log::info('Nuevo valor de activo_usu: ' . $estudiante->activo_usu);
        try {
            $estudiante->save();
            Log::info('Estudiante guardado exitosamente. ID: ' . $estudiante->id . ', activo_usu_despues: ' . $estudiante->activo_usu);
            return redirect()->route('admin.estudiantes.index')->with('success', 'Estado del estudiante actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar estudiante en toggleStatus: ' . $e->getMessage(), ['id' => $estudiante->id]);
            return redirect()->route('admin.estudiantes.index')->with('error', 'Hubo un error al actualizar el estado del estudiante.');
        }
    }

    /**
     * Generate a PDF report of filtered students.
     */
    public function exportPdf(Request $request)
    {
        $query = User::role('estudiante');

        // Aplicar los mismos filtros que en el método index
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('app_usu', 'like', '%' . $search . '%')
                  ->orWhere('apm_usu', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('activo_usu', (bool)$status);
        }

        // Aplicar ordenamiento
        $sortBy = $request->input('sort_by', 'id');
        $sortDirection = $request->input('sort_direction', 'asc');
        $allowedSortColumns = ['id', 'name', 'app_usu', 'apm_usu', 'email', 'activo_usu'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'id';
        }
        $query->orderBy($sortBy, $sortDirection);

        $estudiantes = $query->get(); // Obtener todos los estudiantes filtrados (sin paginación para el PDF)

        $pdf = Pdf::loadView('admin.usuarios.estudiantes.pdf_report', compact('estudiantes'));
        return $pdf->download('reporte_estudiantes_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Generate an Excel report of filtered students.
     */
    public function exportExcel(Request $request)
    {
        // Pasamos los parámetros de la solicitud a la clase de exportación
        return Excel::download(new EstudiantesExport($request), 'reporte_estudiantes_' . now()->format('Ymd_His') . '.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estudiante = User::role('estudiante')->findOrFail($id);
        $estudiante->delete(); // Esto podría ser un soft delete si el modelo User lo tiene configurado

        return redirect()->route('admin.estudiantes.index')->with('success', 'Estudiante eliminado exitosamente.');
    }
}
