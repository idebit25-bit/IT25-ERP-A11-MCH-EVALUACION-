<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    public function accessRoles()
    {
        return $this->belongsToMany(\App\Models\AccessRole::class, 'model_has_roles', 'model_id', 'role_id')
            ->wherePivot('model_type', self::class)
            ->where('guard_name', 'web');
    }

    public function hasAccessRole(string $role): bool
    {
        return $this->accessRoles->contains('name', $role);
    }

    public function canManageOperations(): bool
    {
        return $this->hasAccessRole('Super Admin') || $this->hasAccessRole('Admin');
    }

    public function hasModulePermission(string $permission): bool
    {
        if ($this->hasAccessRole('Super Admin')) {
            return true;
        }

        return $this->hasAccessRole('Admin') && $this->accessRoles->contains(
            fn ($role) => $role->permissions->contains(fn ($item) => $item->guard_name === 'web' && $item->name === $permission)
        );
    }

    /**
     * Campos asignables.
     */
    protected $fillable = [
        'employee_code',
        'first_name',
        'last_name',
        'paternal_surname',
        'maternal_surname',
        'position_id',
        'department_id',
        'marital_status_id',
        'educational_level_id',
        'nationality',
        'gender',
        'birthdate',
        'nss',
        'curp',
        'rfc',
        'email',
        'email_personal',
        'username',
        'password',
        'phone',
        'emergency_number',
        'image',
        'file_csf',
        'validity_csf',
        'cv',
        'birth_certificate',
        'ine',
        'postal_code',
        'state_id',
        'municipality_id',
        'neighborhood_id',
        'street',
        'exterior_number',
        'interior_number',
        'entry_date',
        'exit_date',
        'exit_reason',
        'status',
        'blood_type',
        'allergies',
        'allergies_detail',
        'clothing_size',
        'shoe_size',
        'created_by',
    ];

    /**
     * Campos ocultos.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Conversión automática de tipos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'two_factor_confirmed_at' => 'datetime',
            'birthdate' => 'date',
            'entry_date' => 'date',
            'exit_date' => 'date',
            'validity_csf' => 'date',
            'allergies' => 'boolean',
            'password' => 'hashed',
        ];
    }

    /**
     * Departamento.
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Puesto.
     */
    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    /**
     * Evaluaciones del colaborador.
     */
    public function evaluations()
    {
        return $this->hasMany(UserEvaluation::class);
    }

    /**
     * Usuario que creó el registro.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

        /**
     * Documentos registrados por el usuario.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class, 'created_by');
    }

    /**
 * Nombre completo del colaborador.
 */
public function getFullNameAttribute(): string
{
    return trim(implode(' ', array_filter([
        $this->first_name,
        $this->last_name,
        $this->paternal_surname,
        $this->maternal_surname,
    ])));
}




}
