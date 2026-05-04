<?php

namespace App\Console\Commands;

use App\Models\{User, Evaluacion, Intento};
use App\Services\ScoringService;
use Illuminate\Console\Command;

class CrearIntentosDemo extends Command
{
    protected $signature = 'demo:crear-intentos 
                            {user_id : ID del estudiante}
                            {--categoria= : ID de categoría (opcional)}
                            {--cantidad=5 : Número de intentos a crear}
                            {--correctos=60 : Porcentaje de intentos correctos (0-100)}';

    protected $description = 'Crea intentos de prueba para un estudiante (mínimo 5 para tener predicción IRT)';

    public function __construct(private ScoringService $scoring)
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $userId = (int) $this->argument('user_id');
        $cantidad = (int) $this->option('cantidad');
        $porcentajeCorrectos = (int) $this->option('correctos');
        $categoriaId = $this->option('categoria') ? (int) $this->option('categoria') : null;

        // Validar estudiante
        $user = User::find($userId);
        if (!$user) {
            $this->error("❌ Usuario con ID {$userId} no encontrado.");
            return 1;
        }

        $this->info("👤 Estudiante: {$user->name} ({$user->email})");

        // Obtener evaluaciones
        $query = Evaluacion::where('estado_eval', 2); // Publicadas
        if ($categoriaId) {
            $query->where('categoria_id', $categoriaId);
        }
        $evaluaciones = $query->get();

        if ($evaluaciones->isEmpty()) {
            $this->error("❌ No hay evaluaciones publicadas disponibles.");
            if ($categoriaId) {
                $this->warn("   Intenta sin --categoria para usar todas las categorías.");
            }
            return 1;
        }

        $this->info("📊 Evaluaciones disponibles: {$evaluaciones->count()}");

        // Crear intentos
        $this->info("\n🔄 Creando {$cantidad} intentos...");
        $bar = $this->output->createProgressBar($cantidad);
        $bar->start();

        $correctos = 0;
        $incorrectos = 0;

        for ($i = 1; $i <= $cantidad; $i++) {
            // Seleccionar evaluación aleatoria
            $evaluacion = $evaluaciones->random();

            // Calcular si es correcto según porcentaje
            $esCorrecto = (rand(1, 100) <= $porcentajeCorrectos);

            // Calcular número de intento
            $nro = Intento::where('user_id', $userId)
                ->where('evaluacion_id', $evaluacion->id_eval)
                ->count() + 1;

            // Crear intento
            $intento = Intento::create([
                'evaluacion_id' => $evaluacion->id_eval,
                'user_id' => $userId,
                'respuesta_flag_int' => $esCorrecto ? 'flag_correct' : 'flag_wrong',
                'es_correcto_int' => $esCorrecto,
                'nro_intento_int' => $nro,
                'tiempo_envio_int' => now()->subMinutes(rand(1, 60))->timestamp,
                'latencia_seg_int' => rand(20, 300),
            ]);

            // Procesar con scoring
            $this->scoring->procesarIntento($intento);

            if ($esCorrecto) {
                $correctos++;
            } else {
                $incorrectos++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();

        // Mostrar resumen
        $this->info("\n✅ Intentos creados exitosamente!");
        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Total intentos', $cantidad],
                ['Correctos', $correctos],
                ['Incorrectos', $incorrectos],
                ['Porcentaje correctos', round(($correctos / $cantidad) * 100, 1) . '%'],
            ]
        );

        // Verificar theta calculado
        $habilidad = \App\Models\EstHabilidad::where('user_id', $userId)->first();
        if ($habilidad && $habilidad->theta_global !== null) {
            $nivel = (new \App\Services\IrtService())->obtenerNivel((float)$habilidad->theta_global);
            $this->info("\n📊 Theta calculado:");
            $this->table(
                ['Métrica', 'Valor'],
                [
                    ['Theta Global', $habilidad->theta_global],
                    ['Nivel', strtoupper($nivel)],
                    ['Theta por Categoría', json_encode($habilidad->theta_por_cat ?? [])],
                ]
            );
        } else {
            $this->warn("\n⚠️  Theta aún no calculado. Se necesita mínimo 3-5 intentos por categoría.");
        }

        $this->info("\n💡 Para ver los datos en la BD, ejecuta: php verificar-demo-estudiante.php {$userId}");

        return 0;
    }
}

