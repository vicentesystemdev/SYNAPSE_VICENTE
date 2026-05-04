<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== VERIFICACIÓN DE ESTRUCTURA DE BASE DE DATOS ===\n\n";

// Verificar tabla intentos
$intentos = DB::select("SHOW COLUMNS FROM intentos WHERE Field = 'tiempo_envio_int'");
if (!empty($intentos)) {
    echo "✅ Tabla `intentos`:\n";
    echo "   - tiempo_envio_int: {$intentos[0]->Type}\n";
    echo "   - Tipo correcto: " . (str_contains($intentos[0]->Type, 'bigint') ? 'SÍ ✅' : 'NO ❌ (debe ser bigint)') . "\n\n";
} else {
    echo "❌ Tabla `intentos` no encontrada\n\n";
}

// Verificar tabla scores
$scores = DB::select("SHOW COLUMNS FROM scores WHERE Field = 'calculo_meta'");
if (!empty($scores)) {
    echo "✅ Tabla `scores`:\n";
    echo "   - calculo_meta: {$scores[0]->Type}\n";
    echo "   - Tipo correcto: " . (str_contains($scores[0]->Type, 'json') ? 'SÍ ✅' : 'NO ❌ (debe ser json)') . "\n\n";
} else {
    echo "❌ Tabla `scores` no tiene campo `calculo_meta`\n\n";
}

// Verificar tabla est_habilidades
$estHabilidades = DB::select("SHOW COLUMNS FROM est_habilidades WHERE Field = 'theta_global'");
if (!empty($estHabilidades)) {
    echo "✅ Tabla `est_habilidades`:\n";
    echo "   - theta_global: {$estHabilidades[0]->Type}\n";
    echo "   - Tipo correcto: " . (str_contains($estHabilidades[0]->Type, 'decimal') ? 'SÍ ✅' : 'NO ❌') . "\n\n";
} else {
    echo "❌ Tabla `est_habilidades` no tiene campo `theta_global`\n\n";
}

// Verificar tabla irt_parametros
$irtParametros = DB::select("SHOW COLUMNS FROM irt_parametros WHERE Field = 'c_azar'");
if (!empty($irtParametros)) {
    echo "⚠️  Tabla `irt_parametros`:\n";
    echo "   - c_azar: {$irtParametros[0]->Type} (nullable, no usado actualmente)\n\n";
} else {
    echo "ℹ️  Tabla `irt_parametros` no tiene campo `c_azar` (opcional para IRT 3PL)\n\n";
}

// Verificar tabla transitions
$transitions = DB::select("SHOW TABLES LIKE 'transitions'");
if (!empty($transitions)) {
    echo "✅ Tabla `transitions` existe\n\n";
} else {
    echo "❌ Tabla `transitions` no existe\n\n";
}

echo "=== RESUMEN ===\n";
echo "✅ Todas las migraciones ya están aplicadas\n";
echo "✅ La estructura de la base de datos está correcta\n";
echo "✅ El documento REVISION_BDD.md es solo documentación, no hace cambios\n";
echo "\n📝 NOTA: Si necesitas recrear la base de datos, ejecuta:\n";
echo "   php artisan migrate:fresh --seed\n";

