<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationCompetency extends Model
{
    // Tabla asociada

    protected $table = 'evaluation_competencies';

    // Campos asignables

    protected $fillable = [

        'category_id',

        'name',

        'description',

        'is_active',

        'created_by',

    ];

    /**
     * Categoría a la que pertenece.
     */
    public function category()
    {
        return $this->belongsTo(EvaluationCategory::class, 'category_id');
    }

    /**
     * Usuario creador.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Preguntas de la competencia.
     */
    public function questions()
    {
        return $this->hasMany(EvaluationQuestion::class, 'competency_id');
    }
}