<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ConfiguracionController extends Controller
{
    public function index()
    {
        try {

            // Cuando vuelva la BD aquí irán las consultas reales

            // User::count();
            $usuarios = \App\Models\User::count();

            // Role::count();
            $roles = \App\Models\AccessRole::where('guard_name', 'web')->count();

            // Permission::count();
            $permisos = count(\App\Models\AccessRole::PERMISSIONS);

            // Backup::count();
            $respaldos = 10;

            $configuracionGeneral = [

                'sistema' => 'Capital Humano ERP',

                'version' => '1.0.0',

                'ultimaActualizacion' => '31/05/2026',

                'administrador' => 'César Hernández'

                

            ];

            $activityLogs = ActivityLog::with('user')
             ->latest()
             ->take(5)
             ->get();

        } catch (\Exception $e) {

            $usuarios = 0;
            $roles = 0;
            $permisos = 0;
            $respaldos = 0;

            $activityLogs = collect();

            $configuracionGeneral = [

                'sistema' => '-',

                'version' => '-',

                'ultimaActualizacion' => '-',

                'administrador' => '-'

            ];

        }

        return view(
            'configuracion.index',
            compact(
                'usuarios',
                'roles',
                'permisos',
                'respaldos',
                'configuracionGeneral',
                'activityLogs'
            )
        );
    }


    public function usuarios()
    {
        $usuarios = \App\Models\User::with('accessRoles')->orderBy('id')->get()->map(fn ($user) => [
            'id' => $user->id,
            'nombre' => $user->full_name,
            'usuario' => $user->username ?? $user->email,
            'correo' => $user->email,
            'rol' => $user->accessRoles->pluck('name')->implode(', ') ?: 'Sin rol',
            'estado' => $user->status === 'active' ? 'Activo' : 'Inactivo',
            'ultimoAcceso' => '-',
        ])->all();

        return view('configuracion.usuarios', compact('usuarios'));
    }

public function roles()
{
    try {

        // Datos simulados de roles

        $roles = [

            [

                'id' => 'ROL-001',

                'nombre' => 'Administrador',

                'descripcion' => 'Acceso completo al sistema.',

                'usuarios' => 2,

                'estado' => 'Activo'

            ],

            [

                'id' => 'ROL-002',

                'nombre' => 'Recursos Humanos',

                'descripcion' => 'Administración de empleados.',

                'usuarios' => 5,

                'estado' => 'Activo'

            ],

            [

                'id' => 'ROL-003',

                'nombre' => 'Supervisor',

                'descripcion' => 'Consulta y seguimiento.',

                'usuarios' => 3,

                'estado' => 'Inactivo'

            ]

        ];

    } catch (\Exception $e) {

        // Si ocurre un error se devuelve un arreglo vacío

        $roles = [];

    }

    return view(
        'configuracion.roles',
        compact(
            'roles'
        )
    );

}

}