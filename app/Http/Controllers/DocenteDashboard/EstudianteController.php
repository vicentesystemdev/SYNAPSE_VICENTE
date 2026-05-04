<?php

namespace App\Http\Controllers\DocenteDashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class EstudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudiantes = User::role('estudiante')->paginate(10);
        return view('docente.estudiantes.index', compact('estudiantes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('docente.estudiantes.create');
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
            'activo_usu' => true,
        ]);

        $user->assignRole('estudiante');

        return redirect()->route('docente.estudiantes.index')->with('success', 'Estudiante creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $estudiante = User::role('estudiante')->findOrFail($id);
        return view('docente.estudiantes.show', compact('estudiante'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $estudiante = User::role('estudiante')->findOrFail($id);
        $allowedRoles = Role::whereIn('name', ['admin', 'docente'])->pluck('name', 'name'); // Roles a los que un estudiante puede cambiar
        $currentRole = $estudiante->getRoleNames()->first();
        return view('docente.estudiantes.edit', compact('estudiante', 'allowedRoles', 'currentRole'));
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
        ]);

        $estudiante->name = $request->name;
        $estudiante->app_usu = $request->app_usu;
        $estudiante->apm_usu = $request->apm_usu;
        $estudiante->email = $request->email;

        if ($request->filled('role') && $request->role !== $estudiante->getRoleNames()->first()) {
            $estudiante->syncRoles([]);
            $estudiante->assignRole($request->role);
        }

        $estudiante->save();

        return redirect()->route('docente.estudiantes.index')->with('success', 'Estudiante actualizado exitosamente.');
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
            return redirect()->route('docente.estudiantes.index')->with('success', 'Estado del estudiante actualizado exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar estudiante en toggleStatus: ' . $e->getMessage(), ['id' => $estudiante->id]);
            return redirect()->route('docente.estudiantes.index')->with('error', 'Hubo un error al actualizar el estado del estudiante.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estudiante = User::role('estudiante')->findOrFail($id);
        $estudiante->delete();

        return redirect()->route('docente.estudiantes.index')->with('success', 'Estudiante eliminado exitosamente.');
    }
}
