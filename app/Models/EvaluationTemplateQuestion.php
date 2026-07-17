<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationTemplateQuestion extends Model
{
    // Tabla asociada

    protected $table = 'evaluation_template_questions';

    // Campos asignables

    protected $fillable = [

        'template_id',

        'question_id',

        'order_number',

        'weight',

        'is_required',

    ];

    /**
     * Plantilla.
     */
    public function template()
    {
        return $this->belongsTo(EvaluationTemplate::class, 'template_id');
    }

    /**
     * Pregunta.
     */
    public function question()
    {
        return $this->belongsTo(EvaluationQuestion::class, 'question_id');
    }
}