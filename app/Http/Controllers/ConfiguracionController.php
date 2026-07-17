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
            $usuarios = 12;

            // Role::count();
            $roles = 5;

            // Permission::count();
            $permisos = 28;

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
    try {

        // Datos simulados de usuarios
        //Si ocurre un error se devuelve un arreglo vacio

        $usuarios = [

            [

                'id' => 'USR-001',

                'nombre' => 'César Hernández',

                'usuario' => 'chernandez',

                'correo' => 'cesar@empresa.com',

                'rol' => 'Administrador',

                'estado' => 'Activo',

                'ultimoAcceso' => '25/06/2026 08:30 a.m.'

            ],

            [

                'id' => 'USR-002',

                'nombre' => 'Juan Pérez',

                'usuario' => 'jperez',

                'correo' => 'juan@empresa.com',

                'rol' => 'Recursos Humanos',

                'estado' => 'Activo',

                'ultimoAcceso' => '24/06/2026 10:15 a.m.'

            ],

            [

                'id' => 'USR-003',

                'nombre' => 'Ana López',

                'usuario' => 'alopez',

                'correo' => 'ana@empresa.com',

                'rol' => 'Supervisor',

                'estado' => 'Bloqueado',

                'ultimoAcceso' => '20/06/2026 04:20 p.m.'

            ]

        ];

    } catch (\Exception $e) {

        $usuarios = [];

    }

    return view(
        'configuracion.usuarios',
        compact(
            'usuarios'
        )
    );

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