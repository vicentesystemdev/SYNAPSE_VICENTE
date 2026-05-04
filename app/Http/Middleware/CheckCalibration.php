<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Intento;
use Symfony\Component\HttpFoundation\Response;

class CheckCalibration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Solo aplica a estudiantes
        if ($user && $user->hasRole('estudiante')) {
            
            // Contar intentos válidos
            $totalIntentos = Intento::where('user_id', $user->id)->count();

            // Si tiene menos de 5 intentos, está en fase de calibración
            if ($totalIntentos < 5) {
                
                // Rutas permitidas durante calibración
                $allowedRoutes = [
                    'estudiante.calibracion.index',
                    'estudiante.calibracion.start',
                    'estudiante.evaluaciones.realizar', // Permitir realizar la evaluación
                    'estudiante.evaluaciones.entregar', // Permitir entregar
                    'estudiante.intentos.store',        // Permitir guardar intento
                    'logout',
                    'profile.edit',
                    'profile.update',
                ];

                $currentRoute = $request->route()->getName();

                // Si la ruta actual NO está permitida, redirigir a calibración
                if (!in_array($currentRoute, $allowedRoutes)) {
                    // Evitar bucle de redirección si ya está en calibración (aunque la lógica de arriba debería cubrirlo)
                    if ($currentRoute !== 'estudiante.calibracion.index') {
                        return redirect()->route('estudiante.calibracion.index');
                    }
                }
            } else {
                // Si YA completó la calibración, NO permitir volver a la pantalla de calibración
                if ($request->routeIs('estudiante.calibracion.*')) {
                    return redirect()->route('dashboard');
                }
            }
        }

        return $next($request);
    }
}
