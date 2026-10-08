<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class LocalAccessUsersSeeder extends Seeder
{
    public function run(): void
    {
        $connection = DB::connection();
        if (! app()->environment('local')
            || ! in_array($connection->getConfig('host'), ['127.0.0.1', 'localhost', '::1'], true)
            || $connection->getDatabaseName() !== 'capital_humano_dev') {
            throw new RuntimeException('Estas cuentas de prueba solo se crean en capital_humano_dev local.');
        }

        DB::transaction(function (): void {
            foreach ([
                ['Super Admin', 'Superadministrador Local', 'superadmin@local.test'],
                ['Admin', 'Administrador Local', 'admin@local.test'],
                ['Usuario', 'Usuario Local', 'usuario@local.test'],
            ] as [$role, $name, $email]) {
                $roleId = DB::table('roles')->where('name', $role)->where('guard_name', 'web')->value('id');
                if (! $roleId) {
                    $roleId = DB::table('roles')->insertGetId([
                        'name' => $role, 'guard_name' => 'web',
                        'created_at' => now(), 'updated_at' => now(),
                    ]);
                }

                $userId = DB::table('users')->where('email', $email)->value('id');
                if (! $userId) {
                    $userId = DB::table('users')->insertGetId([
                        'first_name' => $name, 'email' => $email,
                        'password' => Hash::make('12345678'), 'status' => 'active',
                        'created_at' => now(), 'updated_at' => now(),
                    ]);
                    DB::table('model_has_roles')->insert([
                        'role_id' => $roleId, 'model_type' => \App\Models\User::class,
                        'model_id' => $userId,
                    ]);
                }
            }
        });
    }
}
