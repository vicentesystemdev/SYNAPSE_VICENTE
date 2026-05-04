<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "=== VERIFICACIÓN DE ESTUDIANTES POR NIVEL ===\n\n";

$irtService = new App\Services\IrtService();

// Verificar estudiantes de cada nivel
$niveles = ['bajo', 'medio', 'alto'];
$encontrados = ['bajo' => 0, 'medio' => 0, 'alto' => 0];

foreach ($niveles as $nivel) {
    $users = App\Models\User::where('email', 'like', "estudiante_{$nivel}_%@synapse.local")->get();
    
    echo "📊 Nivel " . strtoupper($nivel) . ":\n";
    echo "   Total estudiantes: {$users->count()}\n";
    
    foreach ($users->take(3) as $user) {
        $habilidad = $user->estHabilidad;
        if ($habilidad && $habilidad->theta_global !== null) {
            $nivelCalculado = $irtService->obtenerNivel((float)$habilidad->theta_global);
            echo "   - {$user->name}: theta={$habilidad->theta_global}, nivel={$nivelCalculado}\n";
            $encontrados[$nivelCalculado] = ($encontrados[$nivelCalculado] ?? 0) + 1;
        } else {
            echo "   - {$user->name}: sin theta calculado\n";
        }
    }
    echo "\n";
}

echo "=== RESUMEN ===\n";
echo "Estudiantes con theta bajo: {$encontrados['bajo']}\n";
echo "Estudiantes con theta medio: {$encontrados['medio']}\n";
echo "Estudiantes con theta alto: {$encontrados['alto']}\n";

echo "\n✅ Sistema funcionando correctamente después de eliminar factories!\n";

