<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Dificultad;
use App\Models\Evaluacion;
use App\Models\Periodo;
use App\Models\User;
use Database\Seeders\CatalogoBasicoSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IntentoWindowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(CatalogoBasicoSeeder::class);
    }

    private function crearEvaluacion(array $attributes): Evaluacion
    {
        $categoria = Categoria::first();
        $dificultad = Dificultad::first();
        $periodo = Periodo::first();

        return Evaluacion::create(array_merge([
            'categoria_id' => $categoria->id_cat,
            'dificultad_id' => $dificultad->id_dif,
            'periodo_id' => $periodo->id_per,
            'docente_user_id' => null,
            'titulo_eval' => 'Eval window',
            'descripcion_eval' => 'desc',
            'puntaje_base_eval' => 100,
            'flag_hash_eval' => md5('flag'),
            'estado_eval' => 2,
        ], $attributes));
    }

    public function test_no_permite_intento_antes_de_la_apertura(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $evaluacion = $this->crearEvaluacion([
            'fecha_inicio_eval' => now()->addHour(),
            'fecha_fin_eval' => now()->addHours(2),
        ]);

        $response = $this->actingAs($student)->post(route('evaluaciones.entregar', $evaluacion), [
            'respuesta_flag_int' => 'FLAG{test}',
        ]);

        $response->assertSessionHasErrors('respuesta_flag_int');
    }

    public function test_no_permite_intento_despues_del_cierre(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $evaluacion = $this->crearEvaluacion([
            'fecha_inicio_eval' => now()->subHours(3),
            'fecha_fin_eval' => now()->subHour(),
        ]);

        $response = $this->actingAs($student)->post(route('evaluaciones.entregar', $evaluacion), [
            'respuesta_flag_int' => 'FLAG{test}',
        ]);

        $response->assertSessionHasErrors('respuesta_flag_int');
    }
}
