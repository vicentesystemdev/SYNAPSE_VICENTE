<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluacion;

class EvaluacionFlagsSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener TODAS las evaluaciones (sin límite)
        $evaluaciones = Evaluacion::all();
        
        if ($evaluaciones->isEmpty()) {
            $this->command->warn("⚠️  No hay evaluaciones registradas.");
            return;
        }
        
        // Flag general para pruebas - CAMBIA ESTE TEXTO según necesites
        $flagTexto = "synapse-flag-base"; // Un texto de flag más descriptivo
        
        // Calcular MD5 una sola vez
        $md5Hash = md5($flagTexto);
        
        $this->command->info("🔄 Asignando flags a {$evaluaciones->count()} evaluaciones...");
        
        $actualizadas = 0;
        foreach ($evaluaciones as $eval) {
            // Misma flag para todas (ideal para pruebas)
            $eval->solution_md5 = $md5Hash;
            
            // Publicar todas (asegurar estado_eval = 2)
            $eval->estado_eval = 2; // Publicada
            $eval->save();
            
            $actualizadas++;
        }
        
        $this->command->newLine();
        $this->command->info("✅ Flags asignadas exitosamente!");
        $this->command->table(
            ['Métrica', 'Valor'],
            [
                ['Total evaluaciones', $evaluaciones->count()],
                ['Actualizadas', $actualizadas],
                ['Flag texto', $flagTexto],
                ['MD5 hash', $md5Hash],
                ['Flag esperada', "synapse{{$md5Hash}}"],
            ]
        );
    }
}
