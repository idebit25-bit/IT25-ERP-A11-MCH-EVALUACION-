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

    public function test_discarded_workflow_routes_and_permissions_are_absent(): void
    {
        foreach (['evaluaciones.asignar', 'evaluaciones.historial', 'evaluaciones.validar', 'evaluaciones.publicar', 'planes.index', 'notificaciones.index'] as $name) {
            $this->assertNull(app('router')->getRoutes()->getByName($name));
        }
        $this->assertArrayNotHasKey('evaluaciones.validar', AccessRole::PERMISSIONS);
        $this->assertArrayNotHasKey('evaluaciones.publicar', AccessRole::PERMISSIONS);
    }
}
