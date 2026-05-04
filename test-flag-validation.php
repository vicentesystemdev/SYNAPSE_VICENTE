<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== PRUEBA DE VALIDACIÓN DE FLAGS ===\n\n";

// Obtener una evaluación
$evaluacion = \App\Models\Evaluacion::where('estado_eval', 2)->first();

if (!$evaluacion) {
    echo "❌ No hay evaluaciones publicadas.\n";
    exit(1);
}

echo "📝 Evaluación: {$evaluacion->titulo_eval}\n";
echo "   solution_md5: {$evaluacion->solution_md5}\n";
echo "   flag_hash_eval: " . ($evaluacion->flag_hash_eval ?? 'null') . "\n\n";

// Calcular la flag esperada
$flagEsperada = "synapse{{$evaluacion->solution_md5}}";
echo "✅ Flag esperada: {$flagEsperada}\n\n";

// Probar diferentes flags
$tests = [
    $flagEsperada => 'Correcta',
    'synapse{incorrecta}' => 'Incorrecta (formato válido)',
    'synapse{cc03e747a6afbbcbf8be7668acfebee5}' => 'MD5 de test123',
    'test123' => 'Sin formato synapse',
    'SYNAPSE{' . strtoupper($evaluacion->solution_md5) . '}' => 'Mayúsculas',
];

echo "🧪 Probando validaciones:\n";
echo str_repeat('-', 80) . "\n";

foreach ($tests as $flag => $descripcion) {
    $resultado = \App\Services\FlagService::validate($flag, $evaluacion->solution_md5);
    $emoji = $resultado ? '✅' : '❌';
    echo "{$emoji} {$descripcion}\n";
    echo "   Flag: {$flag}\n";
    echo "   Resultado: " . ($resultado ? 'VÁLIDA' : 'INVÁLIDA') . "\n";
    echo str_repeat('-', 80) . "\n";
}

echo "\n💡 Si todas las pruebas funcionan correctamente, el problema está en otro lado.\n";
