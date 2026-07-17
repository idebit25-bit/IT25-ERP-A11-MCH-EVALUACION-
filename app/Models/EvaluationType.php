<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationType extends Model
{
    // Tabla asociada

    protected $table = 'evaluation_types';

    // Campos asignables

    protected $fillable = [

        'code',

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
     * Preguntas del tipo de evaluación.
     */
    public function questions()
    {
        return $this->hasMany(EvaluationQuestion::class);
    }

    /**
     * Plantillas del tipo de evaluación.
     */
    public function templates()
    {
        return $this->hasMany(EvaluationTemplate::class);
    }

    /**
     * Evaluaciones realizadas.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}