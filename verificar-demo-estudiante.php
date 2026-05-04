<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

if (empty($argv[1])) {
    echo "❌ Uso: php verificar-demo-estudiante.php <user_id>\n";
    exit(1);
}

$userId = (int)$argv[1];
$user = App\Models\User::find($userId);

if (!$user) {
    echo "❌ Usuario con ID {$userId} no encontrado.\n";
    exit(1);
}

echo "=== DEMOSTRACIÓN MOTOR IRT - ESTUDIANTE ===\n\n";

echo "👤 ESTUDIANTE:\n";
echo "   ID: {$user->id}\n";
echo "   Nombre: {$user->name}\n";
echo "   Email: {$user->email}\n\n";

// Intentos
$intentos = App\Models\Intento::where('user_id', $userId)
    ->with('evaluacion.categoria', 'evaluacion.dificultad')
    ->orderBy('created_at')
    ->get();

echo "📝 INTENTOS ({$intentos->count()} total):\n";
if ($intentos->isEmpty()) {
    echo "   ⚠️  No hay intentos registrados.\n\n";
} else {
    echo "   " . str_repeat("-", 100) . "\n";
    printf("   %-5s %-15s %-20s %-10s %-8s %-15s\n", "ID", "Evaluación", "Categoría", "Dificultad", "Correcto", "Nro Intento");
    echo "   " . str_repeat("-", 100) . "\n";
    
    foreach ($intentos->take(10) as $intento) {
        $eval = $intento->evaluacion;
        $cat = $eval->categoria ?? null;
        $dif = $eval->dificultad ?? null;
        
        printf("   %-5s %-15s %-20s %-10s %-8s %-15s\n",
            $intento->id_int,
            substr($eval->titulo_eval ?? 'N/A', 0, 15),
            substr($cat->nombre_cat ?? 'N/A', 0, 20),
            substr($dif->nombre_dif ?? 'N/A', 0, 10),
            $intento->es_correcto_int ? '✅ Sí' : '❌ No',
            $intento->nro_intento_int
        );
    }
    
    if ($intentos->count() > 10) {
        echo "   ... y " . ($intentos->count() - 10) . " más\n";
    }
    echo "\n";
}

// Theta calculado
$habilidad = App\Models\EstHabilidad::where('user_id', $userId)->first();
$irtService = new App\Services\IrtService();

echo "📊 THETA (HABILIDAD IRT):\n";
if (!$habilidad || $habilidad->theta_global === null) {
    echo "   ⚠️  Theta aún no calculado.\n";
    echo "   💡 Se necesita mínimo 3-5 intentos por categoría para calcular theta.\n\n";
} else {
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
    echo "\n";
}

// Scores con metadata
$scores = App\Models\Score::where('user_id', $userId)
    ->with('evaluacion')
    ->orderByDesc('updated_at')
    ->take(5)
    ->get();

echo "📈 SCORES (Últimos 5):\n";
if ($scores->isEmpty()) {
    echo "   ⚠️  No hay scores registrados.\n\n";
} else {
    foreach ($scores as $score) {
        $eval = $score->evaluacion;
        echo "   Evaluación: " . ($eval->titulo_eval ?? 'N/A') . "\n";
        echo "     - Puntaje: {$score->puntaje}\n";
        echo "     - Porcentaje: {$score->porcentaje}%\n";
        
        if ($score->calculo_meta) {
            $meta = $score->calculo_meta;
            echo "     - Metadata IRT:\n";
            
            if (isset($meta['seed_logistica'])) {
                $seed = $meta['seed_logistica'];
                echo "       * Seed Logística:\n";
                echo "         - p_empirico: " . ($seed['p_empirico'] ?? 'N/A') . "\n";
                echo "         - logit_p: " . ($seed['logit_p'] ?? 'N/A') . "\n";
                echo "         - iter: " . ($seed['iter'] ?? 'N/A') . "\n";
                echo "         - convergio: " . (($seed['convergio'] ?? false) ? 'Sí ✅' : 'No ❌') . "\n";
            }
            
            if (isset($meta['irt'])) {
                $irt = $meta['irt'];
                echo "       * IRT:\n";
                echo "         - theta_cat: " . ($irt['theta_cat'] ?? 'N/A') . "\n";
                echo "         - theta_global: " . ($irt['theta_global'] ?? 'N/A') . "\n";
                echo "         - nivel: " . ($irt['nivel'] ?? 'N/A') . "\n";
                echo "         - iter: " . ($irt['iter'] ?? 'N/A') . "\n";
                echo "         - convergio: " . (($irt['convergio'] ?? false) ? 'Sí ✅' : 'No ❌') . "\n";
            }
        }
        echo "\n";
    }
}

// Estadísticas
$totalIntentos = App\Models\Intento::where('user_id', $userId)->count();
$correctos = App\Models\Intento::where('user_id', $userId)->where('es_correcto_int', true)->count();
$porcentajeCorrectos = $totalIntentos > 0 ? round(($correctos / $totalIntentos) * 100, 1) : 0;

echo "📊 ESTADÍSTICAS:\n";
echo "   Total intentos: {$totalIntentos}\n";
echo "   Correctos: {$correctos}\n";
echo "   Incorrectos: " . ($totalIntentos - $correctos) . "\n";
echo "   Porcentaje correctos: {$porcentajeCorrectos}%\n\n";

echo "✅ Verificación completada!\n";
echo "\n💡 Para el docente:\n";
echo "   1. Muestra que theta se calcula automáticamente después de cada intento\n";
echo "   2. Muestra que el nivel se determina por theta (bajo/medio/alto)\n";
echo "   3. Muestra que la metadata incluye iteraciones y convergencia de Newton-Raphson\n";
echo "   4. Muestra que el sistema funciona con datos reales de la base de datos\n";

