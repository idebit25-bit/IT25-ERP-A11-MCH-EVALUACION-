<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    // Tabla asociada

    protected $table = 'evaluations';

    // Campos asignables

    protected $fillable = [

        'user_id',

        'evaluation_type_id',

        'period_id',

        'template_id',

        'evaluator_id',

        'evaluation_date',

        'total_score',

        'observations',

        'status',

    ];

    /**
     * Colaborador evaluado.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Tipo de evaluación.
     */
    public function evaluationType()
    {
        return $this->belongsTo(EvaluationType::class);
    }

    /**
     * Periodo de evaluación.
     */
    public function period()
    {
        return $this->belongsTo(EvaluationPeriod::class, 'period_id');
    }

    /**
     * Plantilla utilizada.
     */
    public function template()
    {
        return $this->belongsTo(EvaluationTemplate::class, 'template_id');
    }

    /**
     * Evaluador.
     */
    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    /**
     * Respuestas registradas.
     */
    public function answers()
    {
        return $this->hasMany(EvaluationAnswer::class, 'evaluation_id');
    }
}