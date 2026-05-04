<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== VERIFICACIÓN DEMO IRT ===\n\n";

// 1. Estudiantes
$totalEstudiantes = App\Models\User::role('student')->count();
$conTheta = App\Models\EstHabilidad::whereNotNull('theta_global')->count();
echo "📊 Estudiantes:\n";
echo "   Total: {$totalEstudiantes}\n";
echo "   Con theta calculado: {$conTheta}\n\n";

// 2. Intentos y Scores
$totalIntentos = App\Models\Intento::count();
$scoresConMeta = App\Models\Score::whereNotNull('calculo_meta')->count();
echo "📝 Intentos y Scores:\n";
echo "   Total intentos: {$totalIntentos}\n";
echo "   Scores con metadata IRT: {$scoresConMeta}\n\n";

// 3. Estudiante demo
$userDemo = App\Models\User::where('email', 'student_demo@synapse.local')->first();
if ($userDemo) {
    $habilidad = $userDemo->estHabilidad;
    echo "👤 Estudiante Demo: {$userDemo->name}\n";
    echo "   Email: {$userDemo->email}\n";
    if ($habilidad) {
        echo "   Theta Global: " . ($habilidad->theta_global ?? 'null') . "\n";
        echo "   Theta por Cat: " . json_encode($habilidad->theta_por_cat ?? []) . "\n";
        if ($habilidad->theta_global !== null) {
            $nivel = (new App\Services\IrtService())->obtenerNivel((float)$habilidad->theta_global);
            echo "   Nivel: " . strtoupper($nivel) . "\n";
        }
    } else {
        echo "   ⚠️  No tiene theta calculado aún\n";
    }
    echo "\n";
    
    // 4. Último score con metadata
    $ultimoScore = App\Models\Score::where('user_id', $userDemo->id)
        ->whereNotNull('calculo_meta')
        ->orderByDesc('updated_at')
        ->first();
    
    if ($ultimoScore && $ultimoScore->calculo_meta) {
        $meta = $ultimoScore->calculo_meta;
        echo "📈 Último Score con Metadata:\n";
        echo "   Evaluación ID: {$ultimoScore->evaluacion_id}\n";
        echo "   Puntaje: {$ultimoScore->puntaje}\n";
        
        if (isset($meta['seed_logistica'])) {
            $seed = $meta['seed_logistica'];
            echo "   Seed Logística:\n";
            echo "     - p_empirico: " . ($seed['p_empirico'] ?? 'N/A') . "\n";
            echo "     - logit_p: " . ($seed['logit_p'] ?? 'N/A') . "\n";
            echo "     - iter: " . ($seed['iter'] ?? 'N/A') . "\n";
            echo "     - convergio: " . ($seed['convergio'] ? 'Sí' : 'No') . "\n";
        }
        
        if (isset($meta['irt'])) {
            $irt = $meta['irt'];
            echo "   IRT:\n";
            echo "     - theta_cat: " . ($irt['theta_cat'] ?? 'N/A') . "\n";
            echo "     - theta_global: " . ($irt['theta_global'] ?? 'N/A') . "\n";
            echo "     - nivel: " . ($irt['nivel'] ?? 'N/A') . "\n";
            echo "     - iter: " . ($irt['iter'] ?? 'N/A') . "\n";
            echo "     - convergio: " . (($irt['convergio'] ?? false) ? 'Sí' : 'No') . "\n";
            if (isset($irt['fallback_reason']) && $irt['fallback_reason']) {
                echo "     - fallback: {$irt['fallback_reason']}\n";
            }
        }
    }
} else {
    echo "⚠️  Estudiante demo no encontrado\n";
}

// 5. Rutas API
echo "\n🌐 Rutas API disponibles:\n";
$routes = \Illuminate\Support\Facades\Route::getRoutes();
$apiRoutes = collect($routes->getRoutes())
    ->filter(fn($route) => str_starts_with($route->uri(), 'api/'))
    ->map(fn($route) => [
        'method' => implode('|', $route->methods()),
        'uri' => $route->uri(),
        'name' => $route->getName(),
    ]);
foreach ($apiRoutes as $route) {
    echo "   {$route['method']} /{$route['uri']}\n";
}

echo "\n✅ Verificación completada!\n";
echo "\n📋 Próximos pasos:\n";
echo "   1. Ejecuta: php artisan serve --host=127.0.0.1 --port=8000\n";
echo "   2. Abre: http://127.0.0.1:8000/dashboard/demostracion\n";
echo "   3. O prueba la API con curl\n";

