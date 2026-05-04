<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\CatalogoBasicoSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RankingAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(CatalogoBasicoSeeder::class);
    }

    public function test_requires_authentication(): void
    {
        $response = $this->get(route('rankings.index'));
        $response->assertRedirect('/login');
    }

    public function test_student_can_view_ranking(): void
    {
        $student = User::factory()->create();
        $student->assignRole('student');

        $response = $this->actingAs($student)->get(route('rankings.index'));
        $response->assertOk();
    }

    public function test_admin_can_view_ranking(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $response = $this->actingAs($admin)->get(route('rankings.index'));
        $response->assertOk();
    }
}
