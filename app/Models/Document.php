<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    public const TYPES = ['Manual', 'Formato', 'Política', 'Procedimiento'];
    public const STATUSES = ['Vigente', 'Actualizado', 'Vencido'];

    public function getExpirationLabelAttribute(): string
    {
        return $this->expiration_date ? \Illuminate\Support\Carbon::parse($this->expiration_date)->format('d/m/Y') : 'Sin vencimiento';
    }

    /**
     * Atributos asignables.
     */
    protected $fillable = [
        'code',
        'name',
        'type',
        'version',
        'file_path',
        'status',
        'expiration_date',
        'created_by',
    ];

    /**
     * Relación con el usuario que creó el documento.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
