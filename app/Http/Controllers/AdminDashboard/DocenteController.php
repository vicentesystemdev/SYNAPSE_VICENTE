<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Añadir para logging
use Barryvdh\DomPDF\Facade\Pdf; // Importar la clase PDF de DomPDF
use Maatwebsite\Excel\Facades\Excel; // Importar la fachada de Laravel Excel
use App\Exports\DocentesExport; // Crearemos esta clase más adelante para Excel

class DocenteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Asegúrate de que Request esté inyectado
    {
        $query = User::role('docente');

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

        $docentes = $query->paginate(10);
        return view('admin.usuarios.docentes.index', compact('docentes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.usuarios.docentes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'app_usu' => 'nullable|string|max:255',
            'apm_usu' => 'nullable|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^doc\\.[a-zA-Z0-9._%+-]+@unifranz\\.edu\\.bo$/'],
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
            'activo_usu' => true,
        ]);

        $user->assignRole('docente');

        return redirect()->route('admin.docentes.index')->with('success', 'Docente creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $docente = User::role('docente')->findOrFail($id);
        return view('admin.usuarios.docentes.show', compact('docente'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $docente = User::role('docente')->findOrFail($id);
        $allowedRoles = Role::whereIn('name', ['admin', 'estudiante'])->pluck('name', 'name'); // Roles a los que un docente puede cambiar
        $currentRole = $docente->getRoleNames()->first(); // Obtener el rol principal actual
        return view('admin.usuarios.docentes.edit', compact('docente', 'allowedRoles', 'currentRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $docente = User::role('docente')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'app_usu' => 'nullable|string|max:255',
            'apm_usu' => 'nullable|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $docente->id, 'regex:/^doc\\.[a-zA-Z0-9._%+-]+@unifranz\\.edu\\.bo$/'],
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

        $docente->name = $request->name;
        $docente->app_usu = $request->app_usu;
        $docente->apm_usu = $request->apm_usu;
        $docente->email = $request->email;

        // Lógica para cambiar el rol
        if ($request->filled('role') && $request->role !== $docente->getRoleNames()->first()) {
            $docente->syncRoles([]); // Remover todos los roles actuales
            $docente->assignRole($request->role); // Asignar el nuevo rol
        }

        // La lógica para actualizar la contraseña se elimina de aquí ya que no se edita directamente.
        /*
        if ($request->filled('password')) {
            $docente->password = bcrypt($request->password);
        }
        */
        $docente->save();

        return redirect()->route('admin.docentes.index')->with('success', 'Docente actualizado exitosamente.');
    }

    /**
     * Toggle the activo_usu status of the specified docente.
     */
    public function toggleStatus(string $id)
    {
        Log::info('Inicio de toggleStatus para docente ID: ' . $id);
        $docente = User::role('docente')->findOrFail($id);
        Log::info('Docente encontrado: ', ['id' => $docente->id, 'activo_usu_antes' => $docente->activo_usu]);
        $docente->activo_usu = !$docente->activo_usu;
        Log::info('Nuevo valor de activo_usu: ' . $docente->activo_usu);
        try {
            $docente->save();
            Log::info('Docente guardado exitosamente. ID: ' . $docente->id . ', activo_usu_despues: ' . $docente->activo_usu);
            return redirect()->route('admin.docentes.index')->with('success', 'Estado del docente actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar docente en toggleStatus: ' . $e->getMessage(), ['id' => $docente->id]);
            return redirect()->route('admin.docentes.index')->with('error', 'Hubo un error al actualizar el estado del docente.');
        }
    }

    /**
     * Generate a PDF report of filtered docentes.
     */
    public function exportPdf(Request $request)
    {
        $query = User::role('docente');

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

        $docentes = $query->get(); // Obtener todos los docentes filtrados (sin paginación para el PDF)

        $pdf = Pdf::loadView('admin.usuarios.docentes.pdf_report', compact('docentes'));
        return $pdf->download('reporte_docentes_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Generate an Excel report of filtered docentes.
     */
    public function exportExcel(Request $request)
    {
        // Pasamos los parámetros de la solicitud a la clase de exportación
        return Excel::download(new DocentesExport($request), 'reporte_docentes_' . now()->format('Ymd_His') . '.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $docente = User::role('docente')->findOrFail($id);
        $docente->delete();

        return redirect()->route('admin.docentes.index')->with('success', 'Docente eliminado exitosamente.');
    }
}
