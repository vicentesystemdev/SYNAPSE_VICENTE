<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CatalogoBasicoSeeder::class,    // Crea categorías y dificultades base
            AdminUserSeeder::class,         // Crea a los admins
            DemoDataSeeder::class,          // Crea a los docentes
            EvaluacionesCtfCompletoSeeder::class, // Crea las 100+ pruebas verídicas con puntajes 100-500
            EvaluacionFlagsSeeder::class,   // Asigna la flag 'synapse{...}' a todo
            IrtDemoSeed::class,             // Genera los intentos de los estudiantes en esas pruebas
            AuditLogSeeder::class,          // Genera logs de actividad
            // ... otros seeders que puedas tener
        ]);
    }
}
