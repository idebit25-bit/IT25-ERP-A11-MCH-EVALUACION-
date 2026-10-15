<?php

namespace Tests\Feature;

use App\Models\{User, AccessRole};
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PersonalEvaluationFlowTest extends TestCase
{
    private User $employee;
    private User $evaluator;
    private User $super;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        DB::unprepared(<<<'SQL'
CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, first_name TEXT, email TEXT, password TEXT, status TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE roles (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, guard_name TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE model_has_roles (role_id INTEGER, model_id INTEGER, model_type TEXT);
CREATE TABLE permissions (id INTEGER PRIMARY KEY, name TEXT, guard_name TEXT);
CREATE TABLE role_has_permissions (role_id INTEGER, permission_id INTEGER);
CREATE TABLE activity_logs (id INTEGER PRIMARY KEY, user_id INTEGER, module TEXT, action TEXT, description TEXT, record_id INTEGER, ip_address TEXT, user_agent TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE evaluations (id INTEGER PRIMARY KEY, user_id INTEGER, evaluator_id INTEGER, template_id INTEGER, evaluation_type_id INTEGER, period_id INTEGER, status TEXT, observations TEXT, total_score REAL, created_at TEXT, updated_at TEXT);
CREATE TABLE evaluation_templates (id INTEGER PRIMARY KEY, name TEXT);
CREATE TABLE evaluation_types (id INTEGER PRIMARY KEY, name TEXT);
CREATE TABLE evaluation_periods (id INTEGER PRIMARY KEY, name TEXT);
CREATE TABLE evaluation_questions (id INTEGER PRIMARY KEY, question TEXT, question_type TEXT, scale_id INTEGER);
CREATE TABLE evaluation_template_questions (template_id INTEGER, question_id INTEGER, order_number INTEGER, weight REAL, is_required INTEGER);
CREATE TABLE evaluation_scales (id INTEGER PRIMARY KEY, name TEXT);
CREATE TABLE evaluation_scale_values (id INTEGER PRIMARY KEY, scale_id INTEGER, label TEXT, numeric_value REAL, display_order INTEGER, is_active INTEGER);
CREATE TABLE evaluation_answers (id INTEGER PRIMARY KEY, evaluation_id INTEGER, question_id INTEGER, answer TEXT, numeric_value REAL, comments TEXT, created_at TEXT, updated_at TEXT);
SQL);
        (require database_path('migrations/2026_10_08_000002_create_notifications_table.php'))->up();
        (require database_path('migrations/2026_10_12_000001_add_evaluation_publication.php'))->up();
        (require database_path('migrations/2026_10_13_000001_add_evaluation_comparison_snapshot.php'))->up();
        foreach (['employee' => 'Usuario', 'evaluator' => 'Usuario', 'super' => 'Super Admin'] as $property => $roleName) {
            $roleId = DB::table('roles')->where('name', $roleName)->value('id')
                ?? DB::table('roles')->insertGetId(['name' => $roleName, 'guard_name' => 'web']);
            $user = User::create(['first_name' => $property, 'email' => $property.'@test.com', 'password' => '12345678', 'status' => 'active']);
            $user->accessRoles()->attach($roleId, ['model_type' => User::class]);
            $this->$property = $user;
        }
        DB::table('evaluation_templates')->insert(['id' => 1, 'name' => 'Prueba']);
        DB::table('evaluation_questions')->insert(['id' => 1, 'question' => 'Pregunta de prueba', 'question_type' => 'radio', 'scale_id' => 1]);
        DB::table('evaluation_template_questions')->insert(['template_id' => 1, 'question_id' => 1, 'order_number' => 1, 'weight' => 1, 'is_required' => 1]);
        DB::table('evaluation_scales')->insert(['id' => 1, 'name' => 'Escala']);
        DB::table('evaluation_scale_values')->insert([
            ['id' => 1, 'scale_id' => 1, 'label' => 'Respuesta correcta', 'numeric_value' => 4, 'display_order' => 1, 'is_active' => 1],
            ['id' => 2, 'scale_id' => 2, 'label' => 'Otra escala', 'numeric_value' => 5, 'display_order' => 1, 'is_active' => 1],
        ]);
        DB::table('evaluations')->insert(['id' => 1, 'user_id' => $this->employee->id, 'evaluator_id' => $this->evaluator->id, 'template_id' => 1, 'status' => 'draft', 'total_score' => 0]);
    }

    public function test_employee_submits_and_only_super_can_reopen_with_audit(): void
    {
        $this->actingAs($this->employee)->get('/mis-evaluaciones/1')->assertOk()->assertSee('Enviar respuestas');
        $this->post('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 1]])->assertRedirect('/mis-evaluaciones/1');
        $this->assertDatabaseHas('evaluations', ['id' => 1, 'status' => 'completed', 'total_score' => 4]);
        $snapshot = \App\Models\Evaluation::find(1)->comparison_snapshot;
        $this->assertSame('Pregunta de prueba', $snapshot['questions'][0]['text']);
        $this->assertSame([1], $snapshot['answered_ids']);
        DB::table('evaluation_questions')->where('id', 1)->update(['question' => 'Enunciado actualizado']);
        $this->assertSame('Pregunta de prueba', \App\Models\Evaluation::find(1)->comparison_snapshot['questions'][0]['text']);
        $this->assertSame(1, $this->evaluator->notifications()->count());
        $this->post('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 1]])->assertStatus(409);
        $this->post('/mis-evaluaciones/1/reabrir', ['reason' => 'Corregir las respuestas'])->assertForbidden();
        $this->actingAs($this->evaluator)->get('/mis-evaluaciones/1')->assertOk()->assertSee('Respuestas del colaborador')->assertDontSee('Enviar respuestas');
        $this->actingAs($this->super)->postJson('/mis-evaluaciones/1/reabrir', [])->assertUnprocessable();
        $this->post('/mis-evaluaciones/1/reabrir', ['reason' => 'Corregir las respuestas'])->assertRedirect();
        $this->assertDatabaseHas('evaluations', ['id' => 1, 'status' => 'draft']);
        $this->assertStringContainsString('Respuesta correcta', DB::table('activity_logs')->where('action', 'Reabrir evaluación')->value('description'));
        $this->actingAs($this->employee)->post('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 1]])->assertRedirect();
        $this->assertSame(1, DB::table('evaluation_answers')->count());
    }

    public function test_review_validation_publication_and_reopening_control_visibility(): void
    {
        $this->actingAs($this->employee)->post('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 1]])->assertRedirect();
        $this->get('/mis-evaluaciones/1')->assertOk()->assertDontSee('Promedio registrado:');
        $this->post('/mis-evaluaciones/1/revision', ['review_notes' => 'Revisión indebida'])->assertForbidden();
        $this->post('/mis-evaluaciones/1/publicar')->assertForbidden();
        $this->actingAs($this->super)->post('/mis-evaluaciones/1/validar')->assertStatus(409);
        $this->post('/mis-evaluaciones/1/publicar')->assertStatus(409);
        $this->post('/mis-evaluaciones/1/revision', ['review_notes' => 'No es el evaluador'])->assertForbidden();
        $this->actingAs($this->evaluator)->postJson('/mis-evaluaciones/1/revision', [])->assertUnprocessable();
        $this->post('/mis-evaluaciones/1/revision', ['review_notes' => 'Revisión reservada de prueba'])->assertRedirect();
        $this->post('/mis-evaluaciones/1/revision', ['review_notes' => 'Revisión duplicada'])->assertRedirect('/mis-evaluaciones/1')->assertSessionHasErrors('review_notes');
        $this->post('/mis-evaluaciones/1/validar')->assertForbidden();
        $this->actingAs($this->employee)->get('/mis-evaluaciones/1')->assertDontSee('Revisión reservada de prueba')->assertDontSee('Promedio registrado:');
        $this->actingAs($this->super)->post('/mis-evaluaciones/1/validar')->assertRedirect();
        $this->post('/mis-evaluaciones/1/validar')->assertStatus(409);
        $this->post('/mis-evaluaciones/1/publicar')->assertRedirect();
        $count = $this->employee->notifications()->count();
        $this->post('/mis-evaluaciones/1/publicar')->assertStatus(409);
        $this->assertSame($count, $this->employee->notifications()->count());
        $this->actingAs($this->employee)->get('/mis-evaluaciones/1')->assertOk()->assertSee('Promedio registrado:')->assertSee('Revisión reservada de prueba');
        $this->actingAs($this->super)->post('/mis-evaluaciones/1/reabrir', ['reason' => 'Corrección después de publicación'])->assertRedirect();
        $this->assertDatabaseHas('evaluations', ['id' => 1, 'published_at' => null, 'reviewed_at' => null, 'validated_at' => null]);
        $this->actingAs($this->employee)->post('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 1]])->assertRedirect();
        $this->get('/mis-evaluaciones/1')->assertDontSee('Promedio registrado:')->assertDontSee('Revisión reservada de prueba');
    }

    public function test_admin_requires_operational_permission_to_publish(): void
    {
        $roleId = DB::table('roles')->insertGetId(['name' => 'Admin', 'guard_name' => 'web']);
        $this->super->accessRoles()->sync([$roleId => ['model_type' => User::class]]);
        $this->actingAs($this->super->fresh())->post('/mis-evaluaciones/1/validar')->assertForbidden();
        $permission = DB::table('permissions')->insertGetId(['name' => 'evaluaciones.gestionar', 'guard_name' => 'web']);
        DB::table('role_has_permissions')->insert(['role_id' => $roleId, 'permission_id' => $permission]);
        $this->actingAs($this->employee)->post('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 1]])->assertRedirect();
        $this->actingAs($this->evaluator)->post('/mis-evaluaciones/1/revision', ['review_notes' => 'Revisada correctamente'])->assertRedirect();
        $this->actingAs($this->super->fresh())->get('/mis-evaluaciones/1')->assertOk()->assertSee('Validar resultado');
        $this->post('/mis-evaluaciones/1/validar')->assertRedirect();
        $this->post('/mis-evaluaciones/1/publicar')->assertRedirect();
    }

    public function test_completed_evaluation_without_answers_has_no_review_form_and_returns_an_explanation(): void
    {
        DB::table('evaluations')->where('id', 1)->update(['status' => 'completed']);
        $this->actingAs($this->evaluator)->get('/mis-evaluaciones/1')->assertOk()
            ->assertSee('no tiene respuestas guardadas')->assertDontSee('id="review-notes"', false);
        $this->post('/mis-evaluaciones/1/revision', ['review_notes' => 'Intento de revision'])
            ->assertRedirect('/mis-evaluaciones/1')->assertSessionHasErrors('review_notes');
        $this->assertDatabaseHas('evaluations', ['id' => 1, 'reviewed_at' => null]);
        $this->assertDatabaseCount('activity_logs', 0);
        $this->postJson('/mis-evaluaciones/1/revision', ['review_notes' => 'Intento de revision'])->assertStatus(409);
        DB::table('evaluations')->where('id', 1)->update(['status' => 'draft']);
        $this->post('/mis-evaluaciones/1/revision', ['review_notes' => 'Formulario anterior'])
            ->assertRedirect('/mis-evaluaciones/1')->assertSessionHasErrors('review_notes');
    }

    public function test_next_step_matches_stage_and_viewer_permissions(): void
    {
        $this->actingAs($this->employee)->get('/mis-evaluaciones/1')->assertOk()->assertSee('href="#evaluation-response"', false);
        $this->actingAs($this->evaluator)->get('/mis-evaluaciones/1')->assertOk()->assertDontSee('href="#evaluation-response"', false);
        $this->actingAs($this->employee)->post('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 1]])->assertRedirect();
        $this->get('/mis-evaluaciones/1')->assertSee('Pendiente de revisión')->assertDontSee('href="#evaluation-review"', false);
        $this->actingAs($this->evaluator)->get('/mis-evaluaciones/1')->assertSee('href="#evaluation-review"', false);
        $this->post('/mis-evaluaciones/1/revision', ['review_notes' => 'Revisada correctamente'])->assertRedirect();
        $this->actingAs($this->super)->get('/mis-evaluaciones/1')->assertSee('href="#evaluation-validate"', false);
        $this->post('/mis-evaluaciones/1/validar')->assertRedirect();
        $this->get('/mis-evaluaciones/1')->assertSee('href="#evaluation-publish"', false);
        $this->actingAs($this->employee)->get('/mis-evaluaciones/1')->assertDontSee('href="#evaluation-publish"', false)->assertDontSee('href="#evaluation-results"', false);
        $this->actingAs($this->super)->post('/mis-evaluaciones/1/publicar')->assertRedirect();
        $this->actingAs($this->employee)->get('/mis-evaluaciones/1')->assertSee('href="#evaluation-results"', false);
        DB::table('evaluations')->where('id', 1)->update(['status' => 'cancelled']);
        $this->get('/mis-evaluaciones/1')->assertSee('Evaluación cancelada')->assertDontSee('href="#evaluation-results"', false);
    }

    public function test_access_and_invalid_answers_do_not_change_the_evaluation(): void
    {
        $this->actingAs($this->evaluator)->post('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 1]])->assertForbidden();
        $this->actingAs($this->super)->post('/evaluaciones/1/submit', ['answers' => [1 => 1]])->assertForbidden();
        $this->actingAs($this->employee)->postJson('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 2]])->assertUnprocessable();
        $this->postJson('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 1, 99 => 1]])->assertUnprocessable();
        $this->postJson('/mis-evaluaciones/1/respuestas', ['answers' => []])->assertUnprocessable();
        $this->assertSame(0, DB::table('evaluation_answers')->count());
        $this->assertDatabaseHas('evaluations', ['id' => 1, 'status' => 'draft']);
        DB::table('evaluations')->where('id', 1)->update(['user_id' => $this->super->id]);
        $this->get('/mis-evaluaciones/1')->assertForbidden();
        $this->post('/mis-evaluaciones/1/respuestas', ['answers' => [1 => 1]])->assertForbidden();
    }
}
