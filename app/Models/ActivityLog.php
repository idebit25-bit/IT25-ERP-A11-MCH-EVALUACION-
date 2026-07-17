<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    // Tabla asociada

    protected $table = 'activity_logs';

    // Campos asignables

    protected $fillable = [

        'user_id',

        'module',

        'action',

        'description',

        'record_id',

        'ip_address',

        'user_agent',

    ];

    /**
     * Usuario que realizó la acción.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }
}