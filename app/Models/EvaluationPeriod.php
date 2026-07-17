<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationPeriod extends Model
{
    // Tabla asociada

    protected $table = 'evaluation_periods';

    // Campos asignables

    protected $fillable = [

        'name',

        'description',

        'year',

        'start_date',

        'end_date',

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
     * Evaluaciones del periodo.
     */
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'period_id');
    }
}