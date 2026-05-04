<?php

namespace App\Console\Commands;

use App\Models\Evaluacion;
use Illuminate\Console\Command;

class GestionarEvaluacionFlag extends Command
{
    protected $signature = 'evaluacion:flag 
                            {id=0 : ID de la evaluación (0 para listar, o usar --list)}
                            {--solution= : Texto solución para calcular MD5}
                            {--md5= : MD5 directo (sin calcular)}
                            {--publish : Publicar la evaluación después de asignar flag}
                            {--list : Listar todas las evaluaciones}';

    protected $description = 'Gestiona las flags de evaluaciones CTF (asignar solution_md5 y publicar)';

    public function handle(): int
    {
        // Si se usa --list o id es 0, listar y salir
        if ($this->option('list') || $this->argument('id') == 0) {
            return $this->listEvaluaciones();
        }

        // Obtener el ID
        $id = (int) $this->argument('id');
        $evaluacion = Evaluacion::find($id);

        if (!$evaluacion) {
            $this->error("❌ Evaluación con ID {$id} no encontrada.");
            return 1;
        }

        $this->info("📝 Evaluación: {$evaluacion->titulo_eval}");
        $this->info("   Estado: " . $this->getEstadoLabel($evaluacion->estado_eval));
        $this->info("   Categoría: {$evaluacion->categoria->nombre_cat}");
        $this->info("   Dificultad: {$evaluacion->dificultad->nombre_dif}");

        // Asignar solution_md5
        $solution = $this->option('solution');
        $md5 = $this->option('md5');

        if ($solution) {
            $md5Calculado = md5($solution);
            $evaluacion->solution_md5 = $md5Calculado;
            $this->info("✅ MD5 calculado desde solución: {$md5Calculado}");
            $this->info("   Flag esperada: synapse{{$md5Calculado}}");
        } elseif ($md5) {
            if (strlen($md5) !== 32 || !preg_match('/^[a-f0-9]{32}$/i', $md5)) {
                $this->error("❌ MD5 inválido. Debe ser una cadena hexadecimal de 32 caracteres.");
                return 1;
            }
            $evaluacion->solution_md5 = strtolower($md5);
            $this->info("✅ MD5 asignado: {$evaluacion->solution_md5}");
            $this->info("   Flag esperada: synapse{{$evaluacion->solution_md5}}");
        } elseif ($evaluacion->solution_md5) {
            $this->info("ℹ️  MD5 actual: {$evaluacion->solution_md5}");
            $this->info("   Flag esperada: synapse{{$evaluacion->solution_md5}}");
            if (!$this->confirm('¿Deseas cambiar el MD5?')) {
                $solution = $this->ask('Ingresa el texto solución para calcular MD5 (o presiona Enter para usar MD5 directo)');
                if ($solution) {
                    $md5Calculado = md5($solution);
                    $evaluacion->solution_md5 = $md5Calculado;
                    $this->info("✅ MD5 calculado: {$md5Calculado}");
                } else {
                    $md5 = $this->ask('Ingresa el MD5 directo (32 caracteres hexadecimales)');
                    if ($md5 && strlen($md5) === 32 && preg_match('/^[a-f0-9]{32}$/i', $md5)) {
                        $evaluacion->solution_md5 = strtolower($md5);
                        $this->info("✅ MD5 asignado: {$evaluacion->solution_md5}");
                    } else {
                        $this->warn("⚠️  MD5 no válido, se mantiene el actual.");
                    }
                }
            }
        } else {
            $this->warn("⚠️  Esta evaluación no tiene solution_md5 asignado.");
            $solution = $this->ask('Ingresa el texto solución para calcular MD5 (o presiona Enter para usar MD5 directo)');
            if ($solution) {
                $md5Calculado = md5($solution);
                $evaluacion->solution_md5 = $md5Calculado;
                $this->info("✅ MD5 calculado: {$md5Calculado}");
                $this->info("   Flag esperada: synapse{{$md5Calculado}}");
            } else {
                $md5 = $this->ask('Ingresa el MD5 directo (32 caracteres hexadecimales)');
                if ($md5 && strlen($md5) === 32 && preg_match('/^[a-f0-9]{32}$/i', $md5)) {
                    $evaluacion->solution_md5 = strtolower($md5);
                    $this->info("✅ MD5 asignado: {$evaluacion->solution_md5}");
                    $this->info("   Flag esperada: synapse{{$evaluacion->solution_md5}}");
                } else {
                    $this->error("❌ MD5 no válido. Operación cancelada.");
                    return 1;
                }
            }
        }

        // Publicar si se solicita
        if ($this->option('publish')) {
            $evaluacion->estado_eval = 2; // Publicada
            $this->info("✅ Evaluación publicada.");
        }

        $evaluacion->save();

        $this->info("\n✅ Evaluación actualizada exitosamente!");
        $this->info("   ID: {$evaluacion->id_eval}");
        $this->info("   Título: {$evaluacion->titulo_eval}");
        $this->info("   MD5: {$evaluacion->solution_md5}");
        $this->info("   Estado: " . $this->getEstadoLabel($evaluacion->estado_eval));
        $this->info("   Flag esperada: synapse{{$evaluacion->solution_md5}}");

        return 0;
    }

    private function listEvaluaciones(): int
    {
        $evaluaciones = Evaluacion::with(['categoria', 'dificultad'])
            ->orderBy('id_eval')
            ->get();

        if ($evaluaciones->isEmpty()) {
            $this->info("ℹ️  No hay evaluaciones registradas.");
            return 0;
        }

        $headers = ['ID', 'Título', 'Categoría', 'Dificultad', 'Estado', 'MD5'];
        $rows = [];

        foreach ($evaluaciones as $eval) {
            $rows[] = [
                $eval->id_eval,
                $eval->titulo_eval,
                $eval->categoria->nombre_cat ?? 'N/A',
                $eval->dificultad->nombre_dif ?? 'N/A',
                $this->getEstadoLabel($eval->estado_eval),
                $eval->solution_md5 ? '✅' : '❌',
            ];
        }

        $this->table($headers, $rows);
        $this->info("\n💡 Usa: php artisan evaluacion:flag {id} --solution='texto' para asignar MD5");

        return 0;
    }

    private function getEstadoLabel(int $estado): string
    {
        return match($estado) {
            1 => 'Borrador',
            2 => 'Publicada',
            3 => 'Cerrada',
            default => "Desconocido ({$estado})",
        };
    }
}

