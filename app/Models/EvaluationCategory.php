<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationCategory extends Model
{
    // Tabla asociada

    protected $table = 'evaluation_categories';

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
     * Competencias de la categoría.
     */
    public function competencies()
    {
        return $this->hasMany(EvaluationCompetency::class, 'category_id');
    }

    /**
     * Preguntas de la categoría.
     */
    public function questions()
    {
        return $this->hasMany(EvaluationQuestion::class, 'category_id');
    }
}