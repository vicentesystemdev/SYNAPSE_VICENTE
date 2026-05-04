<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Faker\Factory as Faker; // Agregamos el import de Faker

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Garantiza que exista el rol admin (por si alguien olvidó correr RoleSeeder)
        Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $faker = Faker::create('es_ES'); // Instanciamos Faker para español

        $adminName = $faker->firstName;
        $adminAppUsu = $faker->lastName;
        $adminApmUsu = $faker->lastName;

        // Generar email personalizado para el administrador
        // Limpiar caracteres especiales para el email
        $formattedName = str_replace([' ', 'ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', '.'], ['', 'n', 'a', 'e', 'i', 'o', 'u', 'u', ''], strtolower($adminName));
        $formattedPaternal = str_replace([' ', 'ñ', 'á', 'é', 'í', 'ó', 'ú', 'ü', '.'], ['', 'n', 'a', 'e', 'i', 'o', 'u', 'u', ''], strtolower($adminAppUsu));
        $shortMaternal = strtolower(substr($adminApmUsu, 0, 2));

        $adminEmail = "adm.{$formattedName}.{$formattedPaternal}.{$shortMaternal}@unifranz.edu.bo";
        $adminEmail = preg_replace('/[^a-zA-Z0-9.@-]/', '', $adminEmail); // Asegurar que solo sean caracteres válidos de email

        $admin = User::firstOrCreate(
            ['email' => $adminEmail], // Usar el email generado
            [
                'name'         => $adminName,
                'app_usu'      => $adminAppUsu,
                'apm_usu'      => $adminApmUsu,
                'activo_usu'   => true,
                'password'     => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]
        );

        $admin->assignRole('admin');

        // Crear el administrador de demo explícito mencionado en la guía
        $demoAdmin = User::firstOrCreate(
            ['email' => 'admin@synapse.com'],
            [
                'name'         => 'Admin',
                'app_usu'      => 'Demo',
                'apm_usu'      => 'Synapse',
                'activo_usu'   => true,
                'password'     => bcrypt('admin123'),
                'email_verified_at' => now(),
            ]
        );
        $demoAdmin->assignRole('admin');
    }
}
