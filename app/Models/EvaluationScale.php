<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationScale extends Model
{
    // Tabla asociada

    protected $table = 'evaluation_scales';

    // Campos asignables

    protected $fillable = [

        'name',

        'description',

        'is_active',

        'created_by',

    ];

    /**
     * Usuario creador.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Valores de la escala.
     */
    public function values()
    {
        return $this->hasMany(
            EvaluationScaleValue::class,
            'scale_id'
        )->orderBy('display_order');
    }

    /**
     * Preguntas que utilizan la escala.
     */
    public function questions()
    {
        return $this->hasMany(EvaluationQuestion::class, 'scale_id');
    }
}