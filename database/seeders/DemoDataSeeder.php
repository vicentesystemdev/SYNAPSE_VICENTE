<?php

namespace Database\Seeders;

use App\Models\Evaluacion;
use App\Models\Intento;
use App\Models\Score;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker; // Agregamos el import de Faker

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('es_ES'); // Instanciamos Faker para español

        // Crear 10 docentes
        for ($i = 1; $i <= 10; $i++) {
            $docenteName = $faker->firstName;
            $docenteAppUsu = $faker->lastName;
            $docenteApmUsu = $faker->lastName;

            // Generar email personalizado para el docente
            // Limpiar caracteres especiales para el email
            $formattedName = str_replace([' ', 'ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', '.'], ['', 'n', 'a', 'e', 'i', 'o', 'u', 'u', ''], strtolower($docenteName));
            $formattedPaternal = str_replace([' ', 'ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', '.'], ['', 'n', 'a', 'e', 'i', 'o', 'u', 'u', ''], strtolower($docenteAppUsu));
            $shortMaternal = strtolower(substr($docenteApmUsu, 0, 2));

            $docenteEmail = "doc.{$formattedName}.{$formattedPaternal}.{$shortMaternal}@unifranz.edu.bo";
            $docenteEmail = preg_replace('/[^a-zA-Z0-9.@-]/', '', $docenteEmail); // Asegurar que solo sean caracteres válidos de email

            $docente = User::firstOrCreate(
                ['email' => $docenteEmail], // Usar el email generado
                [
                    'name'     => $docenteName,
                    'app_usu'  => $docenteAppUsu,
                    'apm_usu'  => $docenteApmUsu,
                    'password' => bcrypt('docente123'),
                    'activo_usu' => true,
                    'email_verified_at' => now(),
                ]
            );
            $docente->assignRole('docente');
        }

        // Crear el docente de demo explícito mencionado en la guía
        $demoDocente = User::firstOrCreate(
            ['email' => 'docente@synapse.local'],
            [
                'name'         => 'Docente',
                'app_usu'      => 'Demo',
                'apm_usu'      => 'Synapse',
                'password'     => bcrypt('docente123'),
                'activo_usu'   => true,
                'email_verified_at' => now(),
            ]
        );
        $demoDocente->assignRole('docente');

        // Crear el estudiante de demo explícito mencionado en la guía
        $demoStudent = User::firstOrCreate(
            ['email' => 'student_demo@synapse.local'],
            [
                'name'         => 'Estudiante',
                'app_usu'      => 'Demo',
                'apm_usu'      => 'Synapse',
                'password'     => bcrypt('password'),
                'activo_usu'   => true,
                'email_verified_at' => now(),
            ]
        );
        $demoStudent->assignRole('estudiante');

        // NOTA: No se generan estudiantes aleatorios aquí
        // Los estudiantes para la demo IRT se generan en IrtDemoSeed con datos controlados

        // NOTA: Los scores se generan automáticamente cuando se procesan intentos
        // en IrtDemoSeed y IrtQuickSeed, no se generan aquí con datos aleatorios
    }
}
