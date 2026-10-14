<?php

namespace Tests\Feature;

use App\Models\{User, ImprovementPlan};
use App\Notifications\ImprovementPlanNotification;
use Illuminate\Support\Facades\{DB, Notification};
use Tests\TestCase;

class ImprovementPlanTest extends TestCase
{
    private User $super;
    private User $employee;
    private User $responsible;
    private User $stranger;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        Notification::fake();
        DB::unprepared(<<<'SQL'
CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, first_name TEXT, email TEXT, password TEXT, status TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE roles (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, guard_name TEXT);
CREATE TABLE model_has_roles (role_id INTEGER, model_id INTEGER, model_type TEXT);
CREATE TABLE permissions (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, guard_name TEXT);
CREATE TABLE role_has_permissions (role_id INTEGER, permission_id INTEGER);
CREATE TABLE activity_logs (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, module TEXT, action TEXT, description TEXT, record_id INTEGER, ip_address TEXT, user_agent TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE evaluations (id INTEGER PRIMARY KEY, user_id INTEGER, evaluator_id INTEGER, template_id INTEGER, period_id INTEGER, evaluation_type_id INTEGER, total_score REAL, status TEXT, published_at TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE evaluation_templates (id INTEGER PRIMARY KEY, name TEXT);
CREATE TABLE evaluation_periods (id INTEGER PRIMARY KEY, name TEXT);
SQL);
        (require database_path('migrations/2026_10_08_000002_create_notifications_table.php'))->up();
        (require database_path('migrations/2026_10_13_000002_create_improvement_plans.php'))->up();
        foreach (['super' => 'Super Admin', 'employee' => 'Usuario', 'responsible' => 'Usuario', 'stranger' => 'Usuario'] as $property => $role) {
            $roleId = DB::table('roles')->where('name', $role)->value('id') ?? DB::table('roles')->insertGetId(['name' => $role, 'guard_name' => 'web']);
            $this->$property = User::create(['first_name' => $property, 'email' => $property.'@test.com', 'password' => '12345678', 'status' => 'active']);
            $this->$property->accessRoles()->attach($roleId, ['model_type' => User::class]);
        }
        DB::table('evaluations')->insert(['id' => 1, 'user_id' => $this->employee->id, 'evaluator_id' => $this->stranger->id, 'status' => 'completed', 'published_at' => now(), 'total_score' => 3.5, 'template_id' => 1, 'period_id' => 1]);
        DB::table('evaluation_templates')->insert(['id' => 1, 'name' => 'Template']);
        DB::table('evaluation_periods')->insert(['id' => 1, 'name' => 'Period']);
        $this->actingAs($this->super);
    }

    private function data(): array
    {
        return ['evaluation_id' => 1, 'title' => 'Plan de prueba', 'objective' => 'Mejorar el cumplimiento de procedimientos',
            'description' => 'Practicar y entregar un ejercicio revisado', 'responsible_id' => $this->responsible->id, 'due_date' => today()->addDays(7)->toDateString()];
    }

    private function createPlan(): ImprovementPlan
    {
        $this->post(route('planes.store'), $this->data())->assertRedirect();
        return ImprovementPlan::firstOrFail();
    }

    public function test_complete_followup_closure_and_reopening_are_audited(): void
    {
        $this->get(route('planes.create'))->assertOk();
        $plan = $this->createPlan();
        $action = $plan->actions()->first();
        Notification::assertSentTo($this->employee, ImprovementPlanNotification::class);
        Notification::assertSentTo($this->responsible, ImprovementPlanNotification::class);
        Notification::assertNotSentTo($this->stranger, ImprovementPlanNotification::class);
        $this->get(route('planes.show', $plan->id))->assertOk()->assertSee('Cierre administrativo');
        $this->patch(route('planes.transition', $plan->id), ['version' => 1, 'status' => 'completed', 'note' => 'Todavia no esta terminado'])->assertStatus(409);
        $this->actingAs($this->responsible)->post(route('planes.progress', [$plan->id, $action->id]), ['version' => 1, 'progress' => 100, 'note' => 'Ejercicio entregado y revisado'])->assertRedirect();
        Notification::assertSentTo($this->super, ImprovementPlanNotification::class);
        $this->assertDatabaseHas('improvement_plans', ['id' => $plan->id, 'status' => 'active']);
        $this->actingAs($this->super)->patch(route('planes.transition', $plan->id), ['version' => $plan->fresh()->version, 'status' => 'completed', 'note' => 'Se verifico el cumplimiento'])->assertRedirect();
        $this->assertDatabaseHas('improvement_plans', ['id' => $plan->id, 'status' => 'completed']);
        $this->actingAs($this->responsible)->post(route('planes.progress', [$plan->id, $action->id]), ['version' => 2, 'progress' => 50, 'note' => 'Cambio posterior'])->assertStatus(409);
        $this->actingAs($this->super)->patch(route('planes.transition', $plan->id), ['version' => $plan->fresh()->version, 'status' => 'active', 'note' => 'Se requiere seguimiento adicional'])->assertRedirect();
        $this->assertSame(4, $plan->updates()->count());
        $this->assertDatabaseHas('activity_logs', ['module' => 'Planes de mejora', 'action' => 'Plan reabierto']);
    }

    public function test_personal_access_does_not_grant_management_or_other_peoples_actions(): void
    {
        $plan = $this->createPlan();
        $action = $plan->actions()->first();
        $this->actingAs($this->employee)->get(route('planes.show', $plan->id))->assertOk()->assertDontSee('Cierre administrativo')->assertDontSee('Guardar avance');
        $this->get(route('planes.index'))->assertOk()->assertSee('Plan de prueba');
        $this->post(route('planes.progress', [$plan->id, $action->id]), ['version' => 1, 'progress' => 50, 'note' => 'Sin permiso'])->assertForbidden();
        $this->get(route('planes.create'))->assertForbidden();
        $this->post(route('planes.store'), $this->data())->assertForbidden();
        $this->patch(route('planes.transition', $plan->id), ['version' => 1, 'status' => 'cancelled', 'note' => 'Intento no autorizado'])->assertForbidden();
        $this->actingAs($this->responsible)->get(route('planes.show', $plan->id))->assertOk()->assertSee('Guardar avance')->assertDontSee('Resultado al crear');
        $this->actingAs($this->stranger)->get(route('planes.show', $plan->id))->assertNotFound();
        $this->get(route('planes.index'))->assertOk()->assertDontSee('Plan de prueba');
        $this->post(route('planes.progress', [$plan->id, $action->id]), ['version' => 1, 'progress' => 30, 'note' => 'Intento ajeno'])->assertNotFound();
    }

    public function test_unpublished_duplicate_inactive_and_invalid_dates_are_rejected(): void
    {
        DB::table('evaluations')->where('id', 1)->update(['published_at' => null]);
        $this->post(route('planes.store'), $this->data())->assertStatus(409);
        $this->assertDatabaseCount('improvement_plans', 0);
        DB::table('evaluations')->where('id', 1)->update(['published_at' => now()]);
        $this->postJson(route('planes.store'), array_replace($this->data(), ['due_date' => today()->subDay()->toDateString()]))->assertUnprocessable();
        $this->responsible->update(['status' => 'inactive']);
        $this->postJson(route('planes.store'), $this->data())->assertUnprocessable();
        $this->responsible->update(['status' => 'active']);
        $plan = $this->createPlan();
        $this->post(route('planes.store'), $this->data())->assertStatus(409);
        $this->get(route('planes.create', ['evaluation_id' => 1]))->assertRedirect(route('planes.show', $plan->id));
        $this->assertDatabaseCount('improvement_plans', 1);
        Notification::assertSentToTimes($this->employee, ImprovementPlanNotification::class, 1);
    }

    public function test_stale_edits_reassignment_and_scoped_action_ids(): void
    {
        $plan = $this->createPlan();
        $action = $plan->actions()->first();
        $edit = ['description' => 'Nueva actividad', 'responsible_id' => $this->employee->id, 'due_date' => today()->addDays(14)->toDateString(), 'note' => 'Cambio de responsable', 'version' => 1];
        $this->put(route('planes.actions.update', [$plan->id, $action->id]), $edit)->assertRedirect();
        $this->put(route('planes.actions.update', [$plan->id, $action->id]), $edit)->assertStatus(409);
        $this->post(route('planes.actions.store', $plan->id), $this->data() + ['version' => 1])->assertStatus(409);
        $this->actingAs($this->responsible)->post(route('planes.progress', [$plan->id, $action->id]), ['version' => 2, 'progress' => 50, 'note' => 'Ya no es mi accion'])->assertNotFound();
        $this->actingAs($this->employee)->postJson(route('planes.progress', [$plan->id, $action->id]), ['version' => 2, 'progress' => 101, 'note' => 'Valor invalido'])->assertUnprocessable();
        $this->post(route('planes.progress', [$plan->id, 999]), ['version' => 1, 'progress' => 50, 'note' => 'Accion inexistente'])->assertNotFound();
        $this->assertSame(2, $plan->updates()->count());
        $this->assertSame(0, $action->fresh()->progress);
    }

    public function test_admin_needs_management_permission_and_overdue_filter_preserves_history(): void
    {
        $plan = $this->createPlan();
        DB::table('improvement_actions')->update(['due_date' => today()->subDay()->toDateString()]);
        $roleId = DB::table('roles')->insertGetId(['name' => 'Admin', 'guard_name' => 'web']);
        $this->stranger->accessRoles()->sync([$roleId => ['model_type' => User::class]]);
        $this->actingAs($this->stranger->fresh())->get(route('planes.create'))->assertForbidden();
        $this->get(route('planes.show', $plan->id))->assertNotFound();
        $permissionId = DB::table('permissions')->insertGetId(['name' => 'evaluaciones.gestionar', 'guard_name' => 'web']);
        DB::table('role_has_permissions')->insert(['role_id' => $roleId, 'permission_id' => $permissionId]);
        $this->actingAs($this->stranger->fresh())->get(route('planes.index', ['status' => 'overdue']))->assertOk()->assertSee('Plan de prueba');
        $this->get(route('planes.show', $plan->id))->assertOk()->assertSee('Vencida');
        $this->patch(route('planes.transition', $plan->id), ['version' => 1, 'status' => 'cancelled', 'note' => 'Se cancela por cambio de objetivo'])->assertRedirect();
        $this->get(route('planes.index', ['status' => 'overdue']))->assertOk()->assertDontSee('Plan de prueba');
        $this->get(route('planes.index', ['status' => 'cancelled']))->assertOk()->assertSee('Plan de prueba');
    }
}
