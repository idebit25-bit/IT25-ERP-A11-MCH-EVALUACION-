<?php

namespace Tests\Feature;

use App\Models\{AccessRole, User};
use Illuminate\Support\Facades\{DB, Hash};
use Tests\TestCase;

class AccessManagementTest extends TestCase
{
    private User $super;
    private User $admin;
    private User $employee;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        DB::unprepared(<<<'SQL'
CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT, first_name TEXT, last_name TEXT, paternal_surname TEXT, maternal_surname TEXT, email TEXT UNIQUE, password TEXT, status TEXT, remember_token TEXT, created_at TEXT, updated_at TEXT);
CREATE TABLE roles (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, guard_name TEXT, created_at TEXT, updated_at TEXT, UNIQUE(name,guard_name));
CREATE TABLE permissions (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, guard_name TEXT, created_at TEXT, updated_at TEXT, UNIQUE(name,guard_name));
CREATE TABLE role_has_permissions (role_id INTEGER, permission_id INTEGER, PRIMARY KEY(role_id,permission_id));
CREATE TABLE model_has_roles (role_id INTEGER, model_id INTEGER, model_type TEXT, PRIMARY KEY(role_id,model_id,model_type));
CREATE TABLE activity_logs (id INTEGER PRIMARY KEY AUTOINCREMENT, user_id INTEGER, module TEXT, action TEXT, description TEXT, record_id INTEGER, ip_address TEXT, user_agent TEXT, created_at TEXT, updated_at TEXT);
SQL);
        (require database_path('migrations/2026_10_08_000001_configure_access_control.php'))->up();
        (require database_path('migrations/2026_10_08_000002_create_notifications_table.php'))->up();
        $this->super = $this->makeUser('Super Admin', 'super@test.com');
        $this->admin = $this->makeUser('Admin', 'admin@test.com');
        $this->employee = $this->makeUser('Usuario', 'employee@test.com');
    }

    private function makeUser(string $role, string $email): User
    {
        $user = User::create(['first_name' => $email, 'email' => $email, 'password' => '12345678', 'status' => 'active']);
        $user->accessRoles()->attach(AccessRole::where('name', $role)->value('id'), ['model_type' => User::class]);
        return $user;
    }

    public function test_access_search_filters_accounts_and_handles_empty_results(): void
    {
        $this->actingAs($this->super)->get('/configuracion/roles?search=employee%40test.com')
            ->assertOk()->assertViewHas('users', fn ($users) => $users->total() === 1 && $users->first()->id === $this->employee->id);
        $this->get('/configuracion/roles?search=does-not-exist')->assertOk()->assertSee('No se encontraron cuentas');
        $this->actingAs($this->admin)->get('/configuracion/roles?search=employee')->assertForbidden();
    }

    public function test_only_super_admin_manages_accounts(): void
    {
        $role = AccessRole::where('name', 'Admin')->value('id');
        $this->actingAs($this->admin)->put('/configuracion/usuarios/'.$this->employee->id.'/acceso', ['role_id' => $role, 'status' => 'active'])->assertForbidden();
        $this->get('/colaboradores/'.$this->super->id.'/edit')->assertForbidden();
        $this->put('/colaboradores/'.$this->super->id, [])->assertForbidden();
        $this->actingAs($this->super)->get('/configuracion/roles')->assertOk();
        $this->putJson('/configuracion/usuarios/'.$this->super->id.'/acceso', ['role_id' => $role, 'status' => 'active'])->assertUnprocessable();
        $this->put('/configuracion/usuarios/'.$this->employee->id.'/acceso', [
            'role_id' => $role, 'status' => 'active', 'password' => 'NuevaClave123', 'password_confirmation' => 'NuevaClave123',
        ])->assertRedirect();
        $this->assertTrue($this->employee->fresh()->hasAccessRole('Admin'));
        $this->assertTrue(Hash::check('NuevaClave123', $this->employee->fresh()->password));
    }

    public function test_permission_changes_are_enforced_and_migration_preserves_them(): void
    {
        $id = AccessRole::where('name', 'Admin')->value('id');
        $this->actingAs($this->super)->put('/configuracion/roles/'.$id.'/permisos', ['permissions' => []])->assertRedirect();
        (require database_path('migrations/2026_10_08_000001_configure_access_control.php'))->up();
        $this->actingAs($this->admin->fresh())->get('/evaluaciones')->assertForbidden();
        $this->get('/configuracion')->assertForbidden();
    }

    public function test_inactive_accounts_cannot_sign_in(): void
    {
        $this->employee->update(['status' => 'inactive']);
        $this->post('/login', ['email' => $this->employee->email, 'password' => '12345678'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_notifications_are_private_and_read_actions_are_scoped(): void
    {
        $this->employee->notify(new \App\Notifications\EvaluationNotification(12, 'Aviso privado del colaborador'));
        $this->admin->notify(new \App\Notifications\EvaluationNotification(13, 'Aviso privado del administrador'));
        $own = $this->employee->notifications()->first();
        $other = $this->admin->notifications()->first();
        $this->actingAs($this->employee)->get('/notificaciones')->assertOk()
            ->assertSee('Aviso privado del colaborador')->assertDontSee('Aviso privado del administrador');
        $this->patch('/notificaciones/'.$other->id.'/leer')->assertNotFound();
        $this->patch('/notificaciones/'.$own->id.'/leer')->assertRedirect();
        $this->assertNotNull($own->fresh()->read_at);
        $this->patch('/notificaciones/leer-todas')->assertRedirect();
        $this->assertNull($other->fresh()->read_at);
        $this->employee->update(['status' => 'inactive']);
        $this->actingAs($this->employee->fresh())->get('/notificaciones')->assertForbidden();
    }

    public function test_evaluation_events_notify_active_participants_once(): void
    {
        \Illuminate\Support\Facades\Notification::fake();
        $evaluation = new \App\Models\Evaluation;
        $evaluation->forceFill(['id' => 12, 'user_id' => $this->employee->id, 'evaluator_id' => $this->employee->id, 'status' => 'draft']);
        $observer = new \App\Observers\EvaluationObserver;
        $observer->created($evaluation);
        \Illuminate\Support\Facades\Notification::assertSentToTimes($this->employee, \App\Notifications\EvaluationNotification::class, 1);
        $evaluation->syncOriginal();
        $evaluation->status = 'completed';
        $evaluation->syncChanges();
        $observer->updated($evaluation);
        \Illuminate\Support\Facades\Notification::assertSentToTimes($this->employee, \App\Notifications\EvaluationNotification::class, 2);
        $evaluation->syncOriginal();
        $evaluation->observations = 'Cambio sin aviso';
        $evaluation->syncChanges();
        $observer->updated($evaluation);
        \Illuminate\Support\Facades\Notification::assertSentToTimes($this->employee, \App\Notifications\EvaluationNotification::class, 2);
        $this->employee->update(['status' => 'inactive']);
        $observer->created($evaluation);
        \Illuminate\Support\Facades\Notification::assertSentToTimes($this->employee, \App\Notifications\EvaluationNotification::class, 2);
    }

    public function test_personal_evaluation_list_scopes_rows_counts_and_filters(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE evaluations (id INTEGER PRIMARY KEY, user_id INTEGER, evaluator_id INTEGER, evaluation_type_id INTEGER, period_id INTEGER, evaluation_date TEXT, status TEXT);
CREATE TABLE evaluation_types (id INTEGER PRIMARY KEY, name TEXT);
CREATE TABLE evaluation_periods (id INTEGER PRIMARY KEY, name TEXT);
SQL);
        DB::table('evaluations')->insert([
            ['id' => 101, 'user_id' => $this->employee->id, 'evaluator_id' => $this->admin->id, 'status' => 'draft'],
            ['id' => 102, 'user_id' => $this->admin->id, 'evaluator_id' => $this->employee->id, 'status' => 'completed'],
            ['id' => 103, 'user_id' => $this->admin->id, 'evaluator_id' => $this->super->id, 'status' => 'draft'],
        ]);
        $this->actingAs($this->employee)->get('/mis-evaluaciones')->assertOk()
            ->assertSee('#101')->assertSee('#102')->assertDontSee('#103')
            ->assertViewHas('pending', 1)->assertViewHas('completed', 1);
        $this->get('/mis-evaluaciones?status=completed&user_id='.$this->admin->id)->assertOk()
            ->assertSee('#102')->assertDontSee('#101')->assertDontSee('#103');
        $this->get('/mis-evaluaciones?status=cancelled')->assertOk()->assertSee('No hay evaluaciones con este estado');
        $this->getJson('/mis-evaluaciones?status=invalid')->assertUnprocessable();
        $this->get('/evaluaciones/103')->assertForbidden();
        $this->employee->update(['status' => 'inactive']);
        $this->actingAs($this->employee->fresh())->get('/mis-evaluaciones')->assertForbidden();
    }

    public function test_evaluations_list_orders_new_records_first_and_counts_real_statuses(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE evaluations (id INTEGER PRIMARY KEY, user_id INTEGER, evaluator_id INTEGER, evaluation_type_id INTEGER, period_id INTEGER, template_id INTEGER, evaluation_date TEXT, status TEXT);
SQL);
        DB::table('evaluations')->insert([
            ['id' => 7, 'evaluation_date' => '2026-10-10', 'status' => 'completed'],
            ['id' => 8, 'evaluation_date' => '2026-10-10', 'status' => 'draft'],
            ['id' => 9, 'evaluation_date' => '2026-09-01', 'status' => 'in_progress'],
        ]);
        $data = app(\App\Http\Controllers\EvaluationController::class)->index()->getData();
        $this->assertSame([9, 8, 7], $data['evaluations']->pluck('id')->all());
        $this->assertSame(2, $data['activeCount']);
        $this->assertSame(1, $data['pendingCount']);
        $this->assertSame(1, $data['completedCount']);
        request()->merge(['order' => 'evaluation_date']);
        $data = app(\App\Http\Controllers\EvaluationController::class)->index()->getData();
        $this->assertSame([9, 8, 7], $data['evaluations']->pluck('id')->all());
    }

    public function test_discarded_workflow_routes_and_permissions_are_absent(): void
    {
        foreach (['evaluaciones.asignar', 'evaluaciones.historial', 'evaluaciones.validar', 'evaluaciones.publicar', 'planes.index'] as $name) {
            $this->assertNull(app('router')->getRoutes()->getByName($name));
        }
        $this->assertArrayNotHasKey('evaluaciones.validar', AccessRole::PERMISSIONS);
        $this->assertArrayNotHasKey('evaluaciones.publicar', AccessRole::PERMISSIONS);
    }
}
