<?php

namespace Tests\Unit;

use App\Models\Categoria;
use App\Models\Dificultad;
use App\Models\Evaluacion;
use App\Models\Intento;
use App\Models\Periodo;
use App\Models\Rendimiento;
use App\Models\Score;
use App\Models\User;
use App\Services\ScoringService;
use Carbon\Carbon;
use Database\Seeders\CatalogoBasicoSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScoringServiceTest extends TestCase
{
    use RefreshDatabase;

    private ScoringService $service;
    private User $student;
    private Evaluacion $evaluacion;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(CatalogoBasicoSeeder::class);

        $this->student = User::factory()->create();
        $this->student->assignRole('student');

        $categoria = Categoria::first();
        $dificultad = Dificultad::first();
        $periodo = Periodo::first();

        $inicio = Carbon::now()->subMinutes(5);
        $fin = Carbon::now()->addMinutes(55);

        $this->evaluacion = Evaluacion::create([
            'categoria_id' => $categoria->id_cat,
            'dificultad_id' => $dificultad->id_dif,
            'periodo_id' => $periodo->id_per,
            'docente_user_id' => null,
            'titulo_eval' => 'Test Eval',
            'descripcion_eval' => 'Descripción',
            'puntaje_base_eval' => 100,
            'fecha_inicio_eval' => $inicio,
            'fecha_fin_eval' => $fin,
            'flag_hash_eval' => md5('flag'),
            'estado_eval' => 2,
        ]);

        $this->service = app(ScoringService::class);
    }

    private function crearIntento(array $overrides = []): Intento
    {
        return Intento::create(array_merge([
            'evaluacion_id' => $this->evaluacion->id_eval,
            'user_id' => $this->student->id,
            'respuesta_flag_int' => 'respuesta',
            'es_correcto_int' => false,
            'nro_intento_int' => 1,
            'tiempo_envio_int' => $this->evaluacion->fecha_inicio_eval->clone()->addMinutes(10)->timestamp,
            'latencia_seg_int' => 600,
        ], $overrides));
    }

    public function test_intento_incorrecto_no_otorga_puntaje(): void
    {
        $intento = $this->crearIntento(['es_correcto_int' => false]);

        $this->service->procesarIntento($intento);

        $score = Score::where('user_id', $this->student->id)->where('evaluacion_id', $this->evaluacion->id_eval)->first();
        $this->assertNotNull($score);
        $this->assertSame(0.0, $score->puntaje);
        $this->assertSame(0.0, $score->porcentaje);
    }

    public function test_primer_intento_correcto_otorga_puntaje_base(): void
    {
        $envio = $this->evaluacion->fecha_inicio_eval->clone()->addMinutes(50);
        $intento = $this->crearIntento([
            'es_correcto_int' => true,
            'tiempo_envio_int' => $envio->timestamp,
        ]);

        $this->service->procesarIntento($intento);

        $score = Score::where('user_id', $this->student->id)->first();
        $this->assertSame(100.0, $score->puntaje);
        $this->assertSame(100.0, $score->porcentaje);
    }

    public function test_penaliza_tercer_intento_correcto(): void
    {
        $this->service->procesarIntento($this->crearIntento(['es_correcto_int' => false, 'nro_intento_int' => 1]));
        $this->service->procesarIntento($this->crearIntento(['es_correcto_int' => false, 'nro_intento_int' => 2]));

        $tercero = $this->crearIntento([
            'es_correcto_int' => true,
            'nro_intento_int' => 3,
            'tiempo_envio_int' => $this->evaluacion->fecha_inicio_eval->clone()->addMinutes(50)->timestamp,
        ]);
        $this->service->procesarIntento($tercero);

        $score = Score::where('user_id', $this->student->id)->first();
        $this->assertSame(90.0, round($score->puntaje, 1));
    }

    public function test_bono_por_tiempo_incrementa_puntaje(): void
    {
        $temprano = $this->crearIntento([
            'es_correcto_int' => true,
            'tiempo_envio_int' => $this->evaluacion->fecha_inicio_eval->clone()->addMinutes(5)->timestamp,
        ]);

        $this->service->procesarIntento($temprano);

        $score = Score::where('user_id', $this->student->id)->first();
        $this->assertGreaterThan(100.0, $score->puntaje);
        $this->assertSame(round($score->puntaje / 100 * 100, 2), $score->porcentaje);
    }

    public function test_actualiza_ema_y_muestras(): void
    {
        $intento = $this->crearIntento(['es_correcto_int' => true]);
        $this->service->procesarIntento($intento);

        $rendimiento = Rendimiento::where('user_id', $this->student->id)
            ->where('categoria_id', $this->evaluacion->categoria_id)
            ->first();

        $this->assertNotNull($rendimiento);
        $this->assertEquals(1, $rendimiento->muestras);
        $this->assertNotEquals(0.50, $rendimiento->r_ema);
    }
}
