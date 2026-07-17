<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationScaleValue extends Model
{
    // Tabla asociada

    protected $table = 'evaluation_scale_values';

    // Campos asignables

    protected $fillable = [

        'scale_id',

        'label',

        'numeric_value',

        'display_order',

        'is_active',

    ];

    /**
     * Escala a la que pertenece.
     */
    public function scale()
    {
        return $this->belongsTo(EvaluationScale::class, 'scale_id');
    }
}