<?php

namespace Tests\Feature;

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

class RankingExportTest extends TestCase
{
    use RefreshDatabase;

    private Periodo $periodo;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(CatalogoBasicoSeeder::class);
        $this->periodo = Periodo::first();
    }

    private function prepararDatos(): void
    {
        $categoria = Categoria::first();
        $dificultad = Dificultad::first();
        $eval = Evaluacion::create([
            'categoria_id' => $categoria->id_cat,
            'dificultad_id' => $dificultad->id_dif,
            'periodo_id' => $this->periodo->id_per,
            'docente_user_id' => null,
            'titulo_eval' => 'Eval export',
            'descripcion_eval' => 'desc',
            'puntaje_base_eval' => 100,
            'fecha_inicio_eval' => now()->subDay(),
            'fecha_fin_eval' => now()->addDay(),
            'flag_hash_eval' => null,
            'estado_eval' => 2,
        ]);

        $student = User::factory()->create(['name' => 'Estudiante Export']);
        $student->assignRole('student');

        Score::create([
            'user_id' => $student->id,
            'evaluacion_id' => $eval->id_eval,
            'puntaje' => 80,
            'porcentaje' => 80,
            'calculo_meta' => null,
        ]);

        app(RankingService::class)->recalcForPeriodo($this->periodo->id_per, null);
    }

    public function test_export_csv_entrega_archivo(): void
    {
        $this->prepararDatos();
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('rankings.csv', ['periodo_id' => $this->periodo->id_per]));
        $response->assertOk();
        $response->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Estudiante Export', $response->streamedContent());
    }

    public function test_export_pdf_entrega_archivo(): void
    {
        $this->prepararDatos();
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('rankings.pdf', ['periodo_id' => $this->periodo->id_per]));
        $response->assertOk();
        $this->assertTrue(str_contains($response->headers->get('content-type'), 'application/pdf'));
    }
}
