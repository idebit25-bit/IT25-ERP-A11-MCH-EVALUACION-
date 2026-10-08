<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessRole extends Model
{
    protected $table = 'roles';

    public const PERMISSIONS = [
        'evaluaciones.gestionar' => 'Administrar evaluaciones existentes',
        'documentos.gestionar' => 'Administrar documentos',
        'colaboradores.gestionar' => 'Administrar colaboradores',
        'reportes.consultar' => 'Consultar y exportar reportes',
        'configuracion.evaluaciones' => 'Configurar catálogos de evaluación',
    ];

    public function permissions()
    {
        return $this->belongsToMany(AccessPermission::class, 'role_has_permissions', 'role_id', 'permission_id');
    }
}
