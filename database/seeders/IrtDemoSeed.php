<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Categoria, Dificultad, Periodo, Evaluacion, IrtParametro, Intento};
use App\Services\ScoringService;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker; // Agregamos el import de Faker

/**
 * Seeder mejorado para demo IRT con múltiples estudiantes y categorías
 * Genera datos suficientes para visualizar gráficas y asignación adaptativa
 */
class IrtDemoSeed extends Seeder
{
    public function __construct(private ScoringService $scoring)
    {
    }

    public function run(): void
    {
        $faker = Faker::create('es_ES'); // Instanciamos Faker para español

        // Obtener categorías existentes (WEB, CRYPTO, FORENS, STEGO)
        $categorias = Categoria::where('activo_cat', true)->get();
        if ($categorias->isEmpty()) {
            $this->command->warn('⚠️  No hay categorías activas. Ejecuta CatalogoBasicoSeeder primero.');
            return;
        }

        // Obtener dificultades
        $dificultades = Dificultad::orderBy('orden_dif')->get();
        if ($dificultades->isEmpty()) {
            $this->command->warn('⚠️  No hay dificultades. Ejecuta CatalogoBasicoSeeder primero.');
            return;
        }

        // Periodo fijo '2025-1' como lo solicitaste
        $periodo = Periodo::firstOrCreate(
            ['nombre_per' => '2025-1'], // Cambiado a '2025-1'
            ['gestion_per' => '2025', 'activo_per' => true] // Cambiado a '2025'
        );

        // Obtener TODAS las evaluaciones creadas por EvaluacionesCtfCompletoSeeder
        // Agrupamos por categoria_id para fácil acceso
        $evaluacionesPorCategoria = Evaluacion::with('irtParametros')
            ->where('periodo_id', $periodo->id_per)
            ->where('estado_eval', 2) // Solo evaluaciones publicadas
            ->get()
            ->groupBy('categoria_id');
        
        if ($evaluacionesPorCategoria->isEmpty()) {
            $this->command->warn('⚠️  No hay evaluaciones publicadas para el período 2025-1. Asegúrate de ejecutar EvaluacionesCtfCompletoSeeder y EvaluacionFlagsSeeder primero.');
            return;
        }

        // Crear 40 estudiantes con diferentes perfiles de rendimiento
        // Distribución ajustada: 13 bajo, 14 medio, 13 alto
        $perfiles = [];
        $numEstudiantesBajo = 13;
        $numEstudiantesMedio = 14;
        $numEstudiantesAlto = 13; // Total 40

        // Estudiantes de nivel bajo (theta < -0.5)
        for ($i = 1; $i <= $numEstudiantesBajo; $i++) {
            $studentName = $faker->firstName;
            $studentAppUsu = $faker->lastName;
            $studentApmUsu = $faker->lastName;

            // Generar email personalizado para el estudiante
            // Limpiar caracteres especiales para el email
            $formattedName = str_replace([' ', 'ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', '.'], ['', 'n', 'a', 'e', 'i', 'o', 'u', 'u', ''], strtolower($studentName));
            $formattedPaternal = str_replace([' ', 'ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', '.'], ['', 'n', 'a', 'e', 'i', 'o', 'u', 'u', ''], strtolower($studentAppUsu));
            $shortMaternal = strtolower(substr($studentApmUsu, 0, 2));

            $studentEmail = "lpze.{$formattedName}.{$formattedPaternal}.{$shortMaternal}@unifranz.edu.bo";
            $studentEmail = preg_replace('/[^a-zA-Z0-9.@-]/', '', $studentEmail); // Asegurar que solo sean caracteres válidos de email

            $porcentajeCorrectos = rand(15, 35); // 15-35% correctos
            $patron = [];
            for ($j = 0; $j < 10; $j++) { $patron[] = rand(1, 100) <= $porcentajeCorrectos; }
            $perfiles[] = [
                'name' => $studentName, 'app_usu' => $studentAppUsu, 'apm_usu' => $studentApmUsu,
                'email' => $studentEmail, 'patron' => $patron, 'nivel_esperado' => 'bajo',
            ];
        }
        
        // Estudiantes de nivel medio (-0.5 ≤ theta < 0.5)
        for ($i = 1; $i <= $numEstudiantesMedio; $i++) {
            $studentName = $faker->firstName;
            $studentAppUsu = $faker->lastName;
            $studentApmUsu = $faker->lastName;

            // Generar email personalizado para el estudiante
            // Limpiar caracteres especiales para el email
            $formattedName = str_replace([' ', 'ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', '.'], ['', 'n', 'a', 'e', 'i', 'o', 'u', 'u', ''], strtolower($studentName));
            $formattedPaternal = str_replace([' ', 'ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', '.'], ['', 'n', 'a', 'e', 'i', 'o', 'u', 'u', ''], strtolower($studentAppUsu));
            $shortMaternal = strtolower(substr($studentApmUsu, 0, 2));

            $studentEmail = "lpze.{$formattedName}.{$formattedPaternal}.{$shortMaternal}@unifranz.edu.bo";
            $studentEmail = preg_replace('/[^a-zA-Z0-9.@-]/', '', $studentEmail); // Asegurar que solo sean caracteres válidos de email

            $porcentajeCorrectos = rand(40, 60); // 40-60% correctos
            $patron = [];
            for ($j = 0; $j < 10; $j++) { $patron[] = rand(1, 100) <= $porcentajeCorrectos; }
            $perfiles[] = [
                'name' => $studentName, 'app_usu' => $studentAppUsu, 'apm_usu' => $studentApmUsu,
                'email' => $studentEmail, 'patron' => $patron, 'nivel_esperado' => 'medio',
            ];
        }
        
        // Estudiantes de nivel alto (theta ≥ 0.5)
        for ($i = 1; $i <= $numEstudiantesAlto; $i++) {
            $studentName = $faker->firstName;
            $studentAppUsu = $faker->lastName;
            $studentApmUsu = $faker->lastName;

            // Generar email personalizado para el estudiante
            // Limpiar caracteres especiales para el email
            $formattedName = str_replace([' ', 'ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', '.'], ['', 'n', 'a', 'e', 'i', 'o', 'u', 'u', ''], strtolower($studentName));
            $formattedPaternal = str_replace([' ', 'ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', '.'], ['', 'n', 'a', 'e', 'i', 'o', 'u', 'u', ''], strtolower($studentAppUsu));
            $shortMaternal = strtolower(substr($studentApmUsu, 0, 2));

            $studentEmail = "lpze.{$formattedName}.{$formattedPaternal}.{$shortMaternal}@unifranz.edu.bo";
            $studentEmail = preg_replace('/[^a-zA-Z0-9.@-]/', '', $studentEmail); // Asegurar que solo sean caracteres válidos de email

            $porcentajeCorrectos = rand(65, 90); // 65-90% correctos
            $patron = [];
            for ($j = 0; $j < 10; $j++) { $patron[] = rand(1, 100) <= $porcentajeCorrectos; }
            $perfiles[] = [
                'name' => $studentName, 'app_usu' => $studentAppUsu, 'apm_usu' => $studentApmUsu,
                'email' => $studentEmail, 'patron' => $patron, 'nivel_esperado' => 'alto',
            ];
        }

        foreach ($perfiles as $perfil) {
            $student = User::firstOrCreate(
                ['email' => $perfil['email']], // Usar el email generado en el perfil
                [
                    'name'       => $perfil['name'],
                    'app_usu'    => $perfil['app_usu'],
                    'apm_usu'    => $perfil['apm_usu'],
                    'activo_usu' => true,
                    'password'   => Hash::make('password'),
                    'email_verified_at' => now(), // Añadir fecha de verificación
                ]
            );
            $student->assignRole('estudiante');

            $patron = $perfil['patron'];
            $patronIdx = 0;

            // Para cada categoría, generar intentos con evaluaciones REALES
            foreach ($categorias as $cat) {
                $evalsCat = $evaluacionesPorCategoria->get($cat->id_cat) ?? collect();

                if ($evalsCat->isEmpty()) {
                    $this->command->warn("⚠️  No hay evaluaciones para la categoría {$cat->nombre_cat} para los estudiantes.");
                    continue;
                }

                $dificultadIndices = match ($perfil['nivel_esperado']) {
                    'bajo' => [1, 2], // 1_facil y 2_baja
                    'medio' => [3],   // 3_media
                    'alto' => [4, 5], // 4_alta y 5_dificil
                    default => [3],   // 3_media por defecto
                };
                // Mapear los índices de dificultad a los objetos de dificultad para filtrar
                $dificultadesFiltradas = $dificultades->filter(fn($d) => in_array($d->orden_dif, $dificultadIndices));

                $evalsDisponibles = $evalsCat->filter(fn($eval) => 
                    $dificultadesFiltradas->contains('id_dif', $eval->dificultad_id)
                );

                if ($evalsDisponibles->isEmpty()) {
                     $this->command->warn("⚠️  No hay evaluaciones disponibles con dificultad adecuada para {$perfil['nivel_esperado']} en {$cat->nombre_cat}. Usando cualquier evaluación disponible.");
                     $evalsDisponibles = $evalsCat; // Fallback a cualquier evaluación de la categoría
                }

                $numIntentos = rand(5, 6); // 5-6 intentos por categoría
                
                // Seleccionar evaluaciones ÚNICAS para evitar el problema de nro_intento
                $evalsSeleccionadas = $evalsDisponibles->random(min($numIntentos, $evalsDisponibles->count()));

                foreach ($evalsSeleccionadas as $eval) {
                    $correcto = $patron[$patronIdx % count($patron)];
                    $patronIdx++;

                    $intento = Intento::create([
                        'evaluacion_id' => $eval->id_eval,
                        'user_id' => $student->id,
                        'respuesta_flag_int' => $correcto ? 'flag_correct' : 'flag_wrong',
                        'es_correcto_int' => $correcto,
                        'nro_intento_int' => 1, // Asumimos que es el primer intento para esta evaluación
                        'tiempo_envio_int' => now()->subHours(rand(1, 48))->timestamp,
                        'latencia_seg_int' => rand(20, 300),
                        'meta_int' => '{}',
                    ]);

                    $this->scoring->procesarIntento($intento);
                }
            }
        }

        $this->command->info('✅ IrtDemoSeed completado: 40 estudiantes con diferentes niveles creados, usando evaluaciones existentes.');
    }
}

