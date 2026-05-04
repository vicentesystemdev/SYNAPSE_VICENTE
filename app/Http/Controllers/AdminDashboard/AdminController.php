<?php

namespace App\Http\Controllers\AdminDashboard;

use App\Http\Controllers\Controller;
use App\Models\User; // Asumo que se usará el modelo User
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role; // Para asignar roles
use Illuminate\Support\Facades\Log; // Añadir para logging
use Barryvdh\DomPDF\Facade\Pdf; // Importar la clase PDF de DomPDF
use Maatwebsite\Excel\Facades\Excel; // Importar la fachada de Laravel Excel
use App\Exports\AdminsExport; // CAMBIADO: Importar la clase AdminsExport para Excel

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::role('admin');

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

        $admins = $query->paginate(10);
        return view('admin.usuarios.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.usuarios.admins.create');
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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'regex:/^(lpze|doc)\\.[a-zA-Z0-9._%+-]+@unifranz\\.edu\\.bo$/'],
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

        $user->assignRole('admin'); // Asignar el rol 'admin'

        return redirect()->route('admin.admins.index')->with('success', 'Administrador creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = User::role('admin')->findOrFail($id);
        return view('admin.usuarios.admins.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = User::role('admin')->findOrFail($id);
        $allowedRoles = Role::whereIn('name', ['estudiante', 'docente'])->pluck('name', 'name'); // Roles a los que un admin puede cambiar
        $currentRole = $admin->getRoleNames()->first(); // Obtener el rol principal actual
        return view('admin.usuarios.admins.edit', compact('admin', 'allowedRoles', 'currentRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = User::role('admin')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'app_usu' => 'required|string|max:255',
            'apm_usu' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $admin->id, 'regex:/^(lpze|doc)\\.[a-zA-Z0-9._%+-]+@unifranz\\.edu\\.bo$/'],
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

        $admin->name = $request->name;
        $admin->app_usu = $request->app_usu;
        $admin->apm_usu = $request->apm_usu;
        $admin->email = $request->email;

        // Lógica para cambiar el rol
        if ($request->filled('role') && $request->role !== $admin->getRoleNames()->first()) {
            $admin->syncRoles([]); // Remover todos los roles actuales
            $admin->assignRole($request->role); // Asignar el nuevo rol
        }

        // La lógica para actualizar la contraseña se elimina de aquí ya que no se edita directamente.
        /*
        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }
        */
        $admin->save();

        return redirect()->route('admin.admins.index')->with('success', 'Administrador actualizado exitosamente.');
    }

    /**
     * Toggle the activo_usu status of the specified admin.
     */
    public function toggleStatus(string $id)
    {
        Log::info('Inicio de toggleStatus para admin ID: ' . $id);
        $admin = User::role('admin')->findOrFail($id);
        Log::info('Admin encontrado: ', ['id' => $admin->id, 'activo_usu_antes' => $admin->activo_usu]);
        $admin->activo_usu = !$admin->activo_usu;
        Log::info('Nuevo valor de activo_usu: ' . $admin->activo_usu);
        try {
            $admin->save();
            Log::info('Admin guardado exitosamente. ID: ' . $admin->id . ', activo_usu_despues: ' . $admin->activo_usu);
            return redirect()->route('admin.admins.index')->with('success', 'Estado del administrador actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar admin en toggleStatus: ' . $e->getMessage(), ['id' => $admin->id]);
            return redirect()->route('admin.admins.index')->with('error', 'Hubo un error al actualizar el estado del administrador.');
        }
    }

    /**
     * Generate a PDF report of filtered admins.
     */
    public function exportPdf(Request $request)
    {
        $query = User::role('admin');

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

        $admins = $query->get(); // Obtener todos los admins filtrados (sin paginación para el PDF)

        $pdf = Pdf::loadView('admin.usuarios.admins.pdf_report', compact('admins')); // CAMBIADO a 'admin.usuarios.admins.pdf_report'
        return $pdf->download('reporte_admins_' . now()->format('Ymd_His') . '.pdf');
    }

    /**
     * Generate an Excel report of filtered docentes.
     */
    public function exportExcel(Request $request)
    {
        // Pasamos los parámetros de la solicitud a la clase de exportación
        return Excel::download(new AdminsExport($request), 'reporte_admins_' . now()->format('Ymd_His') . '.xlsx');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::role('admin')->findOrFail($id);
        $admin->delete(); // Esto podría ser un soft delete si el modelo User lo tiene configurado

        return redirect()->route('admin.admins.index')->with('success', 'Administrador eliminado exitosamente.');
    }
}
