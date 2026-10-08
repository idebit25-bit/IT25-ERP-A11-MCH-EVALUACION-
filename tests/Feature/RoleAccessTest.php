<?php

namespace Tests\Feature;

use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentoController;
use App\Models\AccessRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Mockery;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    private function signInAs(string $role, string $status = 'active'): void
    {
        $user = new User;
        $user->forceFill(['id' => 999, 'status' => $status]);
        $accessRole = new AccessRole;
        $accessRole->forceFill(['name' => $role, 'guard_name' => 'web']);
        $accessRole->setRelation('permissions', new Collection(array_map(function ($name) {
            $permission = new \App\Models\AccessPermission;
            return $permission->forceFill(['name' => $name, 'guard_name' => 'web']);
        }, array_keys(AccessRole::PERMISSIONS))));
        $user->setRelation('accessRoles', new Collection([$accessRole]));
        $this->actingAs($user);
    }

    public function test_super_admin_can_access_configuration(): void
    {
        $this->signInAs('Super Admin');
        $controller = Mockery::mock(ConfiguracionController::class)->makePartial();
        $controller->shouldReceive('index')->once()->andReturn(response('configuration'));
        $this->app->instance(ConfiguracionController::class, $controller);
        $this->get('/configuracion')->assertOk();
    }

    public function test_admin_has_operational_access_but_cannot_manage_roles(): void
    {
        $this->signInAs('Admin');
        $controller = Mockery::mock(DashboardController::class)->makePartial();
        $controller->shouldReceive('index')->once()->andReturn(response('dashboard'));
        $this->app->instance(DashboardController::class, $controller);
        $this->get('/dashboard')->assertOk();
        $configuration = Mockery::mock(ConfiguracionController::class)->makePartial();
        $configuration->shouldReceive('index')->once()->andReturn(response('configuration'));
        $this->app->instance(ConfiguracionController::class, $configuration);
        $this->get('/configuracion')->assertOk();
        $this->get('/configuracion/roles')->assertForbidden();
        $this->get('/configuracion/usuarios')->assertForbidden();
    }

    public function test_common_user_can_only_consult_documents(): void
    {
        $this->signInAs('Usuario');
        $controller = Mockery::mock(DocumentoController::class)->makePartial();
        $controller->shouldReceive('index')->once()->andReturn(response('documents'));
        $this->app->instance(DocumentoController::class, $controller);
        $this->get('/documentos')->assertOk();
        $this->get('/dashboard')->assertRedirect('/documentos');
        foreach (['/colaboradores', '/evaluaciones', '/evaluaciones/create', '/reportes', '/configuracion', '/documentos/create', '/documentos/1/edit'] as $url) {
            $this->get($url)->assertForbidden();
        }
        $this->post('/documentos', [])->assertForbidden();
        $this->put('/documentos/1', [])->assertForbidden();
        $this->delete('/documentos/1')->assertForbidden();
    }

    public function test_inactive_and_unrecognized_roles_are_denied(): void
    {
        $this->signInAs('Super Admin', 'inactive');
        $this->get('/dashboard')->assertForbidden();
        $this->signInAs('Unknown');
        $this->get('/documentos')->assertForbidden();
    }

    public function test_guest_is_sent_to_login(): void
    {
        $this->get('/documentos')->assertRedirect('/login');
    }
}
