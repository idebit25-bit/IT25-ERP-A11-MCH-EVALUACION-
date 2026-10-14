<?php

namespace Tests\Feature;

use App\Models\{Evaluation, EvaluationPeriod, User};
use App\Services\EvaluationHistoryService;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class EvaluationHistoryTest extends TestCase
{
    private User $employee;
    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        DB::unprepared(<<<'SQL'
CREATE TABLE users (id INTEGER PRIMARY KEY, first_name TEXT, email TEXT, password TEXT, status TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE roles (id INTEGER PRIMARY KEY, name TEXT, guard_name TEXT);
CREATE TABLE model_has_roles (role_id INTEGER, model_id INTEGER, model_type TEXT);
CREATE TABLE permissions (id INTEGER PRIMARY KEY, name TEXT, guard_name TEXT);
CREATE TABLE role_has_permissions (role_id INTEGER, permission_id INTEGER);
CREATE TABLE evaluations (id INTEGER PRIMARY KEY, user_id INTEGER, evaluator_id INTEGER, template_id INTEGER, evaluation_type_id INTEGER, period_id INTEGER, evaluation_date TEXT, status TEXT, observations TEXT, total_score REAL, created_at TEXT, updated_at TEXT);
CREATE TABLE evaluation_templates (id INTEGER PRIMARY KEY, name TEXT);
CREATE TABLE evaluation_types (id INTEGER PRIMARY KEY, name TEXT);
CREATE TABLE evaluation_periods (id INTEGER PRIMARY KEY, name TEXT, start_date TEXT, end_date TEXT);
CREATE TABLE evaluation_answers (id INTEGER PRIMARY KEY, evaluation_id INTEGER, question_id INTEGER, answer TEXT, numeric_value REAL);
CREATE TABLE evaluation_questions (id INTEGER PRIMARY KEY, question TEXT);
SQL);
        (require database_path('migrations/2026_10_08_000002_create_notifications_table.php'))->up();
        (require database_path('migrations/2026_10_12_000001_add_evaluation_publication.php'))->up();
        (require database_path('migrations/2026_10_13_000001_add_evaluation_comparison_snapshot.php'))->up();
        DB::table('roles')->insert([['id' => 1, 'name' => 'Usuario', 'guard_name' => 'web'], ['id' => 2, 'name' => 'Admin', 'guard_name' => 'web']]);
        foreach (['employee' => 1, 'admin' => 2] as $property => $role) {
            $this->$property = User::create(['first_name' => $property, 'email' => $property.'@test.com', 'password' => '12345678', 'status' => 'active']);
            $this->$property->accessRoles()->attach($role, ['model_type' => User::class]);
        }
        DB::table('evaluation_templates')->insert(['id' => 1, 'name' => 'Performance template']);
        DB::table('evaluation_types')->insert(['id' => 1, 'name' => 'Performance']);
        DB::table('evaluation_periods')->insert([
            ['id' => 1, 'name' => 'First quarter', 'start_date' => '2026-01-01', 'end_date' => '2026-03-31'],
            ['id' => 2, 'name' => 'Second quarter', 'start_date' => '2026-04-01', 'end_date' => '2026-06-30'],
        ]);
        $this->evaluation(1, 1, 3.5);
        $this->evaluation(2, 2, 4.0);
    }

    private function evaluation(int $id, int $period, float $score, array $override = []): void
    {
        DB::table('evaluations')->insert(array_replace([
            'id' => $id, 'user_id' => $this->employee->id, 'evaluator_id' => $this->admin->id,
            'template_id' => 1, 'evaluation_type_id' => 1, 'period_id' => $period,
            'evaluation_date' => $period === 1 ? '2026-03-31' : '2026-06-30',
            'status' => 'completed', 'published_at' => '2026-07-01', 'total_score' => $score,
            'comparison_snapshot' => json_encode(['version' => 1, 'questions' => [['id' => 1, 'text' => 'Original question', 'values' => [['value' => 1], ['value' => 5]]]]]),
        ], $override));
    }

    public function test_personal_history_is_scoped_and_hides_unpublished_scores(): void
    {
        $this->evaluation(3, 2, 99.75, ['published_at' => null, 'observations' => 'Private review']);
        $this->evaluation(4, 2, 88.25, ['user_id' => $this->admin->id, 'evaluator_id' => $this->employee->id]);
        $response = $this->actingAs($this->employee)->get('/mis-evaluaciones/historial?template_id=1');
        $response->assertOk()->assertDontSee('99.75')->assertDontSee('88.25')->assertDontSee('Private review')
            ->assertSee('+0.50')->assertViewHas('evaluations', fn ($rows) => $rows->total() === 3)
            ->assertViewHas('indicators', fn ($data) => $data['count'] === 2 && $data['delta'] === 0.5);
        $this->getJson('/mis-evaluaciones/historial?user_id='.$this->admin->id)->assertUnprocessable();
        $this->get('/reportes/historial?user_id='.$this->admin->id)->assertForbidden();
        $this->get('/reportes/historial/4')->assertForbidden();
    }

    public function test_report_permission_allows_read_only_detail_without_management_permission(): void
    {
        $this->actingAs($this->admin)->get('/reportes/historial')->assertForbidden();
        DB::table('permissions')->insert(['id' => 1, 'name' => 'reportes.consultar', 'guard_name' => 'web']);
        DB::table('role_has_permissions')->insert(['role_id' => 2, 'permission_id' => 1]);
        $this->actingAs($this->admin->fresh())->get('/reportes/historial')->assertOk();
        $this->get('/reportes/historial?user_id='.$this->employee->id.'&template_id=1')->assertOk()->assertSee('+0.50');
        $this->get('/reportes/historial/1')->assertOk()->assertDontSee('Reabrir para')->assertDontSee('Publicar resultado');
        $this->post('/mis-evaluaciones/1/publicar')->assertForbidden();
    }

    public function test_legacy_and_changed_snapshots_are_not_compared(): void
    {
        $service = new EvaluationHistoryService;
        $rows = Evaluation::with('period')->get();
        $rows[0]->comparison_snapshot = null;
        $this->assertNull($service->indicators($rows, true)['delta']);
        $rows[0]->comparison_snapshot = ['version' => 1, 'questions' => [['text' => 'Changed question']]];
        $this->assertNull($service->indicators($rows, true)['delta']);
        $rows[1]->comparison_snapshot = null;
        $this->assertCount(0, $service->indicators($rows, true)['series']);
    }

    public function test_latest_per_period_and_period_filters_have_deterministic_results(): void
    {
        $this->evaluation(3, 2, 4.5);
        $this->actingAs($this->employee)->get('/mis-evaluaciones/historial?template_id=1')->assertOk()
            ->assertViewHas('indicators', fn ($data) => $data['delta'] === 1.0 && $data['latest']->id === 3 && $data['series']->count() === 2);
        $this->get('/mis-evaluaciones/historial?template_id=1&period_id=2')->assertOk()
            ->assertViewHas('indicators', fn ($data) => $data['delta'] === null && $data['previous'] === null && $data['count'] === 2);
        $this->get('/mis-evaluaciones/historial')->assertOk()
            ->assertViewHas('indicators', fn ($data) => $data['latest'] === null && $data['count'] === 3);
    }

    public function test_reopened_cancelled_and_unpublished_results_are_excluded(): void
    {
        DB::table('evaluations')->where('id', 2)->update(['status' => 'draft', 'published_at' => null]);
        $this->evaluation(3, 2, 4.7, ['status' => 'cancelled']);
        $this->evaluation(4, 2, 4.8, ['published_at' => null]);
        $this->actingAs($this->employee)->get('/mis-evaluaciones/historial?template_id=1')->assertOk()
            ->assertViewHas('indicators', fn ($data) => $data['count'] === 1 && $data['delta'] === null && $data['latest']->id === 1);
        DB::table('evaluations')->delete();
        $this->get('/mis-evaluaciones/historial')->assertOk()->assertViewHas('evaluations', fn ($rows) => $rows->isEmpty());
    }
}
