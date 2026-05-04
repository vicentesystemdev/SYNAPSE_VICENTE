<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Spatie\Permission\Models\Role; // ¡IMPORTANTE: Añade esta línea para el modelo Role!

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'app_usu' => ['required', 'string', 'max:255'], // Añadir validación para apellido paterno
            'apm_usu' => ['required', 'string', 'max:255'], // Añadir validación para apellido materno
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'COD_ROL' => ['required', 'exists:roles,id'], // Añadir validación para el rol
        ]);

        $user = User::create([
            'name' => $request->name,
            'app_usu' => $request->app_usu, // Guardar apellido paterno
            'apm_usu' => $request->apm_usu, // Guardar apellido materno
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activo_usu' => true, // Establecer activo_usu a true por defecto
        ]);

        // Asignar el rol al usuario
        $role = Role::findById($request->COD_ROL);
        if ($role) {
            $user->assignRole($role);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
