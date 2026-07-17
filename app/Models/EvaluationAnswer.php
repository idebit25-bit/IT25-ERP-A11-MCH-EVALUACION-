<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationAnswer extends Model
{
    // Tabla asociada

    protected $table = 'evaluation_answers';

    // Campos asignables

    protected $fillable = [

        'evaluation_id',

        'question_id',

        'answer',

        'numeric_value',

        'comments',

    ];

    /**
     * Evaluación.
     */
    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'evaluation_id');
    }

    /**
     * Pregunta.
     */
    public function question()
    {
        return $this->belongsTo(EvaluationQuestion::class, 'question_id');
    }
}