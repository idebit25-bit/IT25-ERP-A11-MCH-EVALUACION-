<?php

use App\Models\AccessRole;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        foreach (['Super Admin', 'Admin', 'Usuario'] as $name) {
            DB::table('roles')->insertOrIgnore([
                'name' => $name, 'guard_name' => 'web',
                'created_at' => now(), 'updated_at' => now(),
            ]);
        }

        foreach (array_keys(AccessRole::PERMISSIONS) as $name) {
            // Conservar la configuración existente al separar roles del flujo descartado.
            if (DB::table('permissions')->where('name', $name)->where('guard_name', 'web')->exists()) {
                continue;
            }
            $permissionId = DB::table('permissions')->insertGetId([
                'name' => $name, 'guard_name' => 'web',
                'created_at' => now(), 'updated_at' => now(),
            ]);
            foreach (DB::table('roles')->whereIn('name', ['Super Admin', 'Admin'])->where('guard_name', 'web')->pluck('id') as $roleId) {
                DB::table('role_has_permissions')->insertOrIgnore([
                    'permission_id' => $permissionId, 'role_id' => $roleId,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Los accesos pueden estar asignados a cuentas: no borrar roles ni permisos.
    }
};
