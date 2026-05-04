<?php

namespace App\Console\Commands;

use App\Models\{User, Intento, Score, Ranking, Rendimiento, EstHabilidad, Evaluacion};
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetearDatos extends Command
{
    protected $signature = 'reset:datos 
                            {--estudiantes : Resetear solo estudiantes (eliminar estudiantes con rol estudiante)}
                            {--intentos : Resetear solo intentos}
                            {--pruebas : Resetear solo evaluaciones/pruebas}
                            {--todo : Resetear todo (estudiantes, intentos, pruebas y datos relacionados)}
                            {--force : Ejecutar sin confirmación}';

    protected $description = 'Resetea estudiantes, intentos y/o pruebas del sistema con flags específicos';

    public function handle(): int
    {
        // Verificar que al menos una opción esté activa
        $resetEstudiantes = $this->option('estudiantes');
        $resetIntentos = $this->option('intentos');
        $resetPruebas = $this->option('pruebas');
        $resetTodo = $this->option('todo');

        if (!$resetEstudiantes && !$resetIntentos && !$resetPruebas && !$resetTodo) {
            $this->error('❌ Debes especificar al menos una opción:');
            $this->info('   --estudiantes : Resetear estudiantes');
            $this->info('   --intentos    : Resetear intentos');
            $this->info('   --pruebas     : Resetear evaluaciones/pruebas');
            $this->info('   --todo        : Resetear todo');
            $this->newLine();
            $this->info('💡 Ejemplo: php artisan reset:datos --intentos --force');
            return 1;
        }

        // Si se usa --todo, activar todas las opciones
        if ($resetTodo) {
            $resetEstudiantes = true;
            $resetIntentos = true;
            $resetPruebas = true;
        }

        // Mostrar resumen de lo que se va a resetear
        $this->warn('⚠️  ADVERTENCIA: Esta operación eliminará datos de forma permanente!');
        $this->newLine();
        $this->info('📋 Operaciones a realizar:');
        
        if ($resetIntentos) {
            $this->line('   ✓ Eliminar todos los intentos');
            $this->line('   ✓ Eliminar todos los scores');
            $this->line('   ✓ Eliminar todos los rankings');
            $this->line('   ✓ Eliminar todos los rendimientos');
            $this->line('   ✓ Eliminar todas las estimaciones de habilidad');
        }
        
        if ($resetPruebas) {
            $this->line('   ✓ Eliminar todas las evaluaciones/pruebas');
        }
        
        if ($resetEstudiantes) {
            $this->line('   ✓ Eliminar todos los usuarios con rol "estudiante"');
        }

        $this->newLine();

        // Confirmación
        if (!$this->option('force')) {
            if (!$this->confirm('¿Estás seguro de que deseas continuar?', false)) {
                $this->info('❌ Operación cancelada.');
                return 0;
            }
        }

        // Ejecutar operaciones en transacción
        try {
            DB::beginTransaction();

            $stats = [
                'intentos' => 0,
                'scores' => 0,
                'rankings' => 0,
                'rendimientos' => 0,
                'habilidades' => 0,
                'evaluaciones' => 0,
                'estudiantes' => 0,
            ];

            // 1. Resetear intentos y datos relacionados
            if ($resetIntentos) {
                $this->info("\n🔄 Reseteando intentos y datos relacionados...");
                
                $stats['intentos'] = Intento::count();
                Intento::query()->delete();
                $this->line("   ✓ Intentos eliminados: {$stats['intentos']}");

                $stats['scores'] = Score::count();
                Score::query()->delete();
                $this->line("   ✓ Scores eliminados: {$stats['scores']}");

                $stats['rankings'] = Ranking::count();
                Ranking::query()->delete();
                $this->line("   ✓ Rankings eliminados: {$stats['rankings']}");

                $stats['rendimientos'] = Rendimiento::count();
                Rendimiento::query()->delete();
                $this->line("   ✓ Rendimientos eliminados: {$stats['rendimientos']}");

                $stats['habilidades'] = EstHabilidad::count();
                EstHabilidad::query()->delete();
                $this->line("   ✓ Estimaciones de habilidad eliminadas: {$stats['habilidades']}");
            }

            // 2. Resetear evaluaciones/pruebas
            if ($resetPruebas) {
                $this->info("\n🔄 Reseteando evaluaciones/pruebas...");
                
                // Si no se resetearon intentos antes, hay que eliminarlos primero por FK
                if (!$resetIntentos) {
                    $intentosCount = Intento::count();
                    Intento::query()->delete();
                    $this->line("   ✓ Intentos eliminados (por FK): {$intentosCount}");
                    
                    $scoresCount = Score::count();
                    Score::query()->delete();
                    $this->line("   ✓ Scores eliminados (por FK): {$scoresCount}");
                }

                $stats['evaluaciones'] = Evaluacion::count();
                Evaluacion::query()->delete();
                $this->line("   ✓ Evaluaciones eliminadas: {$stats['evaluaciones']}");
            }

            // 3. Resetear estudiantes
            if ($resetEstudiantes) {
                $this->info("\n🔄 Reseteando estudiantes...");
                
                // Obtener estudiantes (usuarios con rol 'estudiante')
                $estudiantes = User::role('estudiante')->get();
                $stats['estudiantes'] = $estudiantes->count();

                if ($stats['estudiantes'] > 0) {
                    // Eliminar datos relacionados si no se hizo antes
                    if (!$resetIntentos) {
                        $intentosCount = Intento::whereIn('user_id', $estudiantes->pluck('id'))->count();
                        Intento::whereIn('user_id', $estudiantes->pluck('id'))->delete();
                        $this->line("   ✓ Intentos de estudiantes eliminados: {$intentosCount}");

                        $scoresCount = Score::whereIn('user_id', $estudiantes->pluck('id'))->count();
                        Score::whereIn('user_id', $estudiantes->pluck('id'))->delete();
                        $this->line("   ✓ Scores de estudiantes eliminados: {$scoresCount}");

                        $rankingsCount = Ranking::whereIn('user_id', $estudiantes->pluck('id'))->count();
                        Ranking::whereIn('user_id', $estudiantes->pluck('id'))->delete();
                        $this->line("   ✓ Rankings de estudiantes eliminados: {$rankingsCount}");

                        $rendimientosCount = Rendimiento::whereIn('user_id', $estudiantes->pluck('id'))->count();
                        Rendimiento::whereIn('user_id', $estudiantes->pluck('id'))->delete();
                        $this->line("   ✓ Rendimientos de estudiantes eliminados: {$rendimientosCount}");

                        $habilidadesCount = EstHabilidad::whereIn('user_id', $estudiantes->pluck('id'))->count();
                        EstHabilidad::whereIn('user_id', $estudiantes->pluck('id'))->delete();
                        $this->line("   ✓ Habilidades de estudiantes eliminadas: {$habilidadesCount}");
                    }

                    // Eliminar estudiantes
                    User::role('estudiante')->delete();
                    $this->line("   ✓ Estudiantes eliminados: {$stats['estudiantes']}");
                } else {
                    $this->warn("   ⚠️  No se encontraron estudiantes para eliminar.");
                }
            }

            DB::commit();

            // Mostrar resumen final
            $this->newLine();
            $this->info('✅ Operación completada exitosamente!');
            $this->newLine();
            $this->table(
                ['Tipo de Dato', 'Cantidad Eliminada'],
                [
                    ['Intentos', $stats['intentos']],
                    ['Scores', $stats['scores']],
                    ['Rankings', $stats['rankings']],
                    ['Rendimientos', $stats['rendimientos']],
                    ['Estimaciones de Habilidad', $stats['habilidades']],
                    ['Evaluaciones', $stats['evaluaciones']],
                    ['Estudiantes', $stats['estudiantes']],
                ]
            );

            return 0;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("\n❌ Error durante la operación: " . $e->getMessage());
            $this->error("   Todos los cambios han sido revertidos.");
            return 1;
        }
    }
}