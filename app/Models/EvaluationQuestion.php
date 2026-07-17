<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationQuestion extends Model
{
    // Tabla asociada

    protected $table = 'evaluation_questions';

    // Campos asignables

    protected $fillable = [

        'evaluation_type_id',

        'category_id',

        'competency_id',

        'scale_id',

        'question_type',

        'question',

        'help_text',

        'weight',

        'order_number',

        'is_required',

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
     * Categoría.
     */
    public function category()
    {
        return $this->belongsTo(EvaluationCategory::class, 'category_id');
    }

    /**
     * Competencia.
     */
    public function competency()
    {
        return $this->belongsTo(EvaluationCompetency::class, 'competency_id');
    }

    /**
     * Escala.
     */
    public function scale()
    {
        return $this->belongsTo(EvaluationScale::class, 'scale_id');
    }

    /**
     * Usuario creador.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Plantillas donde se utiliza.
     */
    public function templateQuestions()
    {
        return $this->hasMany(EvaluationTemplateQuestion::class, 'question_id');
    }

    /**
     * Respuestas registradas.
     */
    public function answers()
    {
        return $this->hasMany(EvaluationAnswer::class, 'question_id');
    }
}