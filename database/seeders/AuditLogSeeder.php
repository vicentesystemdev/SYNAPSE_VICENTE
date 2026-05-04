<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AuditLog;
use App\Models\User;
use Carbon\Carbon;
use Faker\Factory as Faker; // Importar Faker

class AuditLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create(); // Instanciar Faker para datos genéricos
        
        // Primero ejecutar la migración si no se ha hecho
        // Ya no es necesario mostrar esto, se asume que las migraciones ya corrieron
        // echo "Asegúrate de haber ejecutado: php artisan migrate\\n"; 

        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->command->warn("⚠️  No hay usuarios en la base de datos. Crea usuarios primero (AdminUserSeeder, DemoDataSeeder, IrtDemoSeed).");
            return;
        }

        $ips = [
            '192.168.1.100',
            '192.168.1.101',
            '192.168.1.102',
            '10.0.0.50',
            '10.0.0.51',
            '172.16.0.10',
        ];

        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:121.0) Gecko/20100101 Firefox/121.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1',
            'Mozilla/5.0 (iPad; CPU OS 17_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/17.1 Mobile/15E148 Safari/604.1',
        ];

        $logs = [];

        // Generar 100 logs en los últimos 7 días (antes 20 logs en 2 días)
        for ($i = 0; $i < 100; $i++) { // Generar más logs
            $user = $users->random();
            $ip = $ips[array_rand($ips)];
            $userAgent = $userAgents[array_rand($userAgents)];
            
            // Fecha aleatoria en los últimos 7 días
            $fecha = Carbon::now()->subHours(rand(0, 7 * 24))->subMinutes(rand(0, 59));
            
            // Alternar entre login, logout, y otras acciones
            $accionesPosibles = ['login', 'logout', 'evaluacion_iniciada', 'evaluacion_finalizada', 'perfil_actualizado'];
            $accion = $faker->randomElement($accionesPosibles);
            
            // Obtener rol del usuario
            $rol = $user->getRoleNames()->first() ?? 'sin_rol';
            
            $payload = [];
            $entidadAudit = null;
            $entidadIdAudit = null;

            if ($accion == 'login') {
                $payload = [
                    'nombre_completo' => "{$user->name} {$user->app_usu} {$user->apm_usu}", // Nombre completo
                    'email' => $user->email,
                    'rol' => $rol,
                ];
                $entidadAudit = 'User';
                $entidadIdAudit = $user->id;
            } elseif ($accion == 'logout') {
                $payload = [
                    'duracion_sesion_minutos' => rand(5, 180),
                ];
                $entidadAudit = 'User';
                $entidadIdAudit = $user->id;
            } elseif ($accion == 'evaluacion_iniciada') {
                $evaluacion = \App\Models\Evaluacion::inRandomOrder()->first();
                if ($evaluacion) {
                    $payload = [
                        'evaluacion_id' => $evaluacion->id_eval,
                        'titulo_eval' => $evaluacion->titulo_eval,
                    ];
                    $entidadAudit = 'Evaluacion';
                    $entidadIdAudit = $evaluacion->id_eval;
                }
            } elseif ($accion == 'evaluacion_finalizada') {
                $evaluacion = \App\Models\Evaluacion::inRandomOrder()->first();
                if ($evaluacion) {
                    $payload = [
                        'evaluacion_id' => $evaluacion->id_eval,
                        'titulo_eval' => $evaluacion->titulo_eval,
                        'score_obtenido' => rand(0, 100),
                    ];
                    $entidadAudit = 'Evaluacion';
                    $entidadIdAudit = $evaluacion->id_eval;
                }
            } elseif ($accion == 'perfil_actualizado') {
                $payload = [
                    'cambios' => $faker->randomElement([
                        ['name' => $faker->firstName],
                        ['password' => '****'],
                        ['activo_usu' => !$user->activo_usu],
                    ]),
                ];
                $entidadAudit = 'User';
                $entidadIdAudit = $user->id;
            }

            $logs[] = [
                'user_id' => $user->id,
                'accion_audit' => $accion,
                'entidad_audit' => $entidadAudit, // Evitar NULL
                'entidad_id_audit' => $entidadIdAudit, // Evitar NULL
                'ip_address' => $ip,
                'user_agent' => $userAgent,
                'payload_audit' => json_encode($payload),
                'created_at' => $fecha,
                'updated_at' => $fecha,
            ];
        }

        // Ordenar por fecha (más antiguos primero)
        usort($logs, function($a, $b) {
            return $a['created_at'] <=> $b['created_at'];
        });

        // Insertar en la base de datos
        foreach ($logs as $log) {
            AuditLog::create([
                'user_id' => $log['user_id'],
                'accion_audit' => $log['accion_audit'],
                'entidad_audit' => $log['entidad_audit'],
                'entidad_id_audit' => $log['entidad_id_audit'],
                'ip_address' => $log['ip_address'],
                'user_agent' => $log['user_agent'],
                'payload_audit' => json_decode($log['payload_audit'], true),
                'created_at' => $log['created_at'],
                'updated_at' => $log['updated_at'],
            ]);
        }

        $this->command->info("✓ Se crearon {$i} registros de auditoría de los últimos 7 días.");
    }
}
