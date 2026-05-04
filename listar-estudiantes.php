<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== ESTUDIANTES DISPONIBLES ===\n\n";

$estudiantes = App\Models\User::role('student')->take(10)->get(['id', 'name', 'email']);

foreach ($estudiantes as $estudiante) {
    $intentos = App\Models\Intento::where('user_id', $estudiante->id)->count();
    $habilidad = App\Models\EstHabilidad::where('user_id', $estudiante->id)->first();
    $theta = $habilidad && $habilidad->theta_global !== null ? $habilidad->theta_global : 'sin theta';
    
    echo "ID: {$estudiante->id} - {$estudiante->name} ({$estudiante->email})\n";
    echo "  Intentos: {$intentos}\n";
    echo "  Theta: {$theta}\n\n";
}

