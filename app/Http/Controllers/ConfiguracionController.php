<?php

namespace App\Http\Controllers;

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

        } catch (\Exception $e) {

            $usuarios = 0;
            $roles = 0;
            $permisos = 0;
            $respaldos = 0;

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
                'configuracionGeneral'
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

public function perfil()
{
    try {

        // Datos simulados del perfil

        $perfil = [

            'nombre' => 'César Hernández',

            'usuario' => 'chernandez',

            'correo' => 'cesar@empresa.com',

            'telefono' => '33 1234 5678',

            'rol' => 'Administrador',

            'ultimoAcceso' => '25/06/2026 08:30 a.m.'

        ];

    } catch (\Exception $e) {

        // Si ocurre un error se devuelve un arreglo vacío

        $perfil = [];

    }

    return view(
        'configuracion.perfil',
        compact(
            'perfil'
        )
    );

}

public function empresa()
{
    try {

        // Datos simulados de la empresa

        $empresa = [

            'nombre' => 'Capital Humano ERP',

            'razonSocial' => 'Capital Humano ERP S.A. de C.V.',

            'rfc' => 'CHE260531ABC',

            'telefono' => '33 1234 5678',

            'correo' => 'contacto@capitalhumano.com',

            'direccion' => 'Guadalajara, Jalisco, México',

            'sitioWeb' => 'www.capitalhumano.com',

            'moneda' => 'Peso Mexicano (MXN)',

            'zonaHoraria' => 'UTC -06:00'

        ];

    } catch (\Exception $e) {

        // Si ocurre un error se devuelve un arreglo vacío

        $empresa = [];

    }

    return view(
        'configuracion.empresa',
        compact(
            'empresa'
        )
    );

}

}