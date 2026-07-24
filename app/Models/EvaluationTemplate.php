<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationTemplate extends Model
{
    // Tabla asociada

    protected $table = 'evaluation_templates';

    // Campos asignables

    protected $fillable = [

        'evaluation_type_id',

        'name',

        'description',

        'is_active',

        'created_by',

    ];

    /**
     * Tipo de evaluación.
     */
    public function evaluationType()
    {
        return $this->belongsTo(EvaluationType::class, 'evaluation_type_id');
    }

    /**
     * Usuario creador.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Preguntas de la plantilla.
     */
    public function templateQuestions()
    {
        return $this->hasMany(EvaluationTemplateQuestion::class, 'template_id');
    }

    /**
     * Evaluaciones realizadas.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'template_id');
    }

    /**
 * Preguntas asociadas a la plantilla.
 */
public function questions()
{
    return $this->belongsToMany(
        EvaluationQuestion::class,
        'evaluation_template_questions',
        'template_id',
        'question_id'
    )
    ->withPivot([
        'order_number',
        'weight',
        'is_required',
    ])
    ->orderBy('evaluation_template_questions.order_number');
}

}