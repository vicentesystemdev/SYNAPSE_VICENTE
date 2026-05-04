<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== DEMOSTRACIÓN RÁPIDA DEL MOTOR IRT ===\n\n";

// Seleccionar o crear estudiante
$estudiante = App\Models\User::role('student')->first();

if (!$estudiante) {
    echo "❌ No hay estudiantes disponibles. Creando uno...\n";
    $estudiante = App\Models\User::create([
        'name' => 'Estudiante Demo',
        'email' => 'demo_estudiante@synapse.local',
        'password' => bcrypt('password'),
        'activo_usu' => true,
    ]);
    $estudiante->assignRole('student');
    echo "✅ Estudiante creado: ID {$estudiante->id}\n\n";
}

echo "👤 Estudiante seleccionado:\n";
echo "   ID: {$estudiante->id}\n";
echo "   Nombre: {$estudiante->name}\n";
echo "   Email: {$estudiante->email}\n\n";

// Verificar theta inicial
$habilidad = App\Models\EstHabilidad::where('user_id', $estudiante->id)->first();
$thetaInicial = $habilidad && $habilidad->theta_global !== null ? $habilidad->theta_global : null;

echo "📊 Estado inicial:\n";
echo "   Theta: " . ($thetaInicial !== null ? $thetaInicial : 'No calculado') . "\n";
echo "   Intentos existentes: " . App\Models\Intento::where('user_id', $estudiante->id)->count() . "\n\n";

// Crear 5 intentos nuevos
echo "🔄 Creando 5 intentos nuevos...\n";
$evaluaciones = App\Models\Evaluacion::where('estado_eval', 2)->get();

if ($evaluaciones->isEmpty()) {
    echo "❌ No hay evaluaciones publicadas disponibles.\n";
    exit(1);
}

$scoring = app(\App\Services\ScoringService::class);
$correctos = 0;
$incorrectos = 0;

for ($i = 1; $i <= 5; $i++) {
    $evaluacion = $evaluaciones->random();
    $esCorrecto = rand(1, 100) <= 60; // 60% correctos
    
    $nro = App\Models\Intento::where('user_id', $estudiante->id)
        ->where('evaluacion_id', $evaluacion->id_eval)
        ->count() + 1;
    
    $intento = App\Models\Intento::create([
        'evaluacion_id' => $evaluacion->id_eval,
        'user_id' => $estudiante->id,
        'respuesta_flag_int' => $esCorrecto ? 'flag_correct' : 'flag_wrong',
        'es_correcto_int' => $esCorrecto,
        'nro_intento_int' => $nro,
        'tiempo_envio_int' => now()->subMinutes(rand(1, 60))->timestamp,
        'latencia_seg_int' => rand(20, 300),
    ]);
    
    $scoring->procesarIntento($intento);
    
    if ($esCorrecto) {
        $correctos++;
    } else {
        $incorrectos++;
    }
    
    echo "   ✓ Intento {$i} creado (" . ($esCorrecto ? 'correcto' : 'incorrecto') . ")\n";
}

echo "\n✅ Intentos creados exitosamente!\n";
echo "   Correctos: {$correctos}\n";
echo "   Incorrectos: {$incorrectos}\n\n";

// Verificar theta final
$habilidad = App\Models\EstHabilidad::where('user_id', $estudiante->id)->first();
$irtService = new \App\Services\IrtService();

echo "📊 Estado final:\n";
if ($habilidad && $habilidad->theta_global !== null) {
    $nivel = $irtService->obtenerNivel((float)$habilidad->theta_global);
    echo "   Theta Global: {$habilidad->theta_global}\n";
    echo "   Nivel: " . strtoupper($nivel) . "\n";
    
    if ($habilidad->theta_por_cat && is_array($habilidad->theta_por_cat)) {
        echo "   Theta por Categoría:\n";
        foreach ($habilidad->theta_por_cat as $catId => $theta) {
            $cat = App\Models\Categoria::find($catId);
            $catNombre = $cat ? $cat->nombre_cat : "Cat ID {$catId}";
            $nivelCat = $irtService->obtenerNivel((float)$theta);
            echo "     - {$catNombre}: theta = {$theta}, nivel = " . strtoupper($nivelCat) . "\n";
        }
    }
} else {
    echo "   ⚠️  Theta aún no calculado. Se necesita mínimo 3-5 intentos por categoría.\n";
}

// Mostrar último score con metadata
$ultimoScore = App\Models\Score::where('user_id', $estudiante->id)
    ->orderByDesc('updated_at')
    ->first();

if ($ultimoScore && $ultimoScore->calculo_meta) {
    $meta = $ultimoScore->calculo_meta;
    echo "\n📈 Último score con metadata IRT:\n";
    
    if (isset($meta['seed_logistica'])) {
        $seed = $meta['seed_logistica'];
        echo "   Seed Logística:\n";
        echo "     - p_empirico: " . ($seed['p_empirico'] ?? 'N/A') . "\n";
        echo "     - logit_p: " . ($seed['logit_p'] ?? 'N/A') . "\n";
        echo "     - iter: " . ($seed['iter'] ?? 'N/A') . "\n";
        echo "     - convergio: " . (($seed['convergio'] ?? false) ? 'Sí ✅' : 'No ❌') . "\n";
    }
    
    if (isset($meta['irt'])) {
        $irt = $meta['irt'];
        echo "   IRT:\n";
        echo "     - theta_cat: " . ($irt['theta_cat'] ?? 'N/A') . "\n";
        echo "     - theta_global: " . ($irt['theta_global'] ?? 'N/A') . "\n";
        echo "     - nivel: " . ($irt['nivel'] ?? 'N/A') . "\n";
        echo "     - iter: " . ($irt['iter'] ?? 'N/A') . "\n";
        echo "     - convergio: " . (($irt['convergio'] ?? false) ? 'Sí ✅' : 'No ❌') . "\n";
    }
}

echo "\n✅ Demostración completada!\n";
echo "\n💡 Para ver más detalles del estudiante:\n";
echo "   php verificar-demo-estudiante.php {$estudiante->id}\n";
echo "\n💡 Para el docente:\n";
echo "   1. Muestra que theta se calcula automáticamente\n";
echo "   2. Muestra que el nivel se determina por theta\n";
echo "   3. Muestra que la metadata incluye iteraciones y convergencia de Newton-Raphson\n";
echo "   4. Consulta la base de datos con las queries SQL del documento DEMOSTRACION_DOCENTE.md\n";

