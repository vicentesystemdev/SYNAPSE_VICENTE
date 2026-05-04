<?php

namespace Tests\Unit;

use App\Models\Categoria;
use App\Models\Dificultad;
use App\Models\Evaluacion;
use App\Models\Periodo;
use App\Models\Score;
use App\Models\User;
use App\Services\RankingService;
use Database\Seeders\CatalogoBasicoSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RankingServiceTest extends TestCase
{
    use RefreshDatabase;

    private RankingService $service;
    private Periodo $periodo;
    private Categoria $categoria;
    private Dificultad $dificultad;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(CatalogoBasicoSeeder::class);

        $this->service = app(RankingService::class);
        $this->periodo = Periodo::first();
        $this->categoria = Categoria::first();
        $this->dificultad = Dificultad::first();
    }

    private function crearEvaluacion(array $attributes = []): Evaluacion
    {
        return Evaluacion::create(array_merge([
            'categoria_id' => $this->categoria->id_cat,
            'dificultad_id' => $this->dificultad->id_dif,
            'periodo_id' => $this->periodo->id_per,
            'docente_user_id' => null,
            'titulo_eval' => 'Eval',
            'descripcion_eval' => 'Desc',
            'puntaje_base_eval' => 100,
            'fecha_inicio_eval' => now()->subDay(),
            'fecha_fin_eval' => now()->addDay(),
            'flag_hash_eval' => null,
            'estado_eval' => 2,
        ], $attributes));
    }

    private function crearScore(User $user, Evaluacion $evaluacion, float $puntaje): void
    {
        Score::create([
            'user_id' => $user->id,
            'evaluacion_id' => $evaluacion->id_eval,
            'puntaje' => $puntaje,
            'porcentaje' => $evaluacion->puntaje_base_eval > 0 ? ($puntaje / $evaluacion->puntaje_base_eval) * 100 : 0,
            'calculo_meta' => null,
        ]);
    }

    public function test_recalcula_ranking_por_periodo(): void
    {
        $eval1 = $this->crearEvaluacion(['titulo_eval' => 'Eval 1']);
        $eval2 = $this->crearEvaluacion(['titulo_eval' => 'Eval 2']);

        $alice = User::factory()->create(['name' => 'Alice']);
        $bob = User::factory()->create(['name' => 'Bob']);
        $alice->assignRole('student');
        $bob->assignRole('student');

        $this->crearScore($alice, $eval1, 80);
        $this->crearScore($alice, $eval2, 50);
        $this->crearScore($bob, $eval1, 60);
        $this->crearScore($bob, $eval2, 30);

        $this->service->recalcForPeriodo($this->periodo->id_per, null);
        $ranking = $this->service->obtenerRanking($this->periodo->id_per);

        $this->assertCount(2, $ranking);
        $this->assertEquals('Alice', $ranking->first()->user->name);
        $this->assertEquals(130.0, $ranking->first()->puntaje_total);
        $this->assertEquals(1, $ranking->first()->posicion);
    }

    public function test_empates_se_resuelven_por_nombre(): void
    {
        $eval = $this->crearEvaluacion();

        $carlos = User::factory()->create(['name' => 'Carlos']);
        $beto = User::factory()->create(['name' => 'Beto']);
        $carlos->assignRole('student');
        $beto->assignRole('student');

        $this->crearScore($carlos, $eval, 90);
        $this->crearScore($beto, $eval, 90);

        $this->service->recalcForPeriodo($this->periodo->id_per, null);
        $ranking = $this->service->obtenerRanking($this->periodo->id_per);

        $this->assertEquals(['Beto', 'Carlos'], $ranking->pluck('user.name')->all());
        $this->assertEquals([1, 2], $ranking->pluck('posicion')->all());
    }
}
