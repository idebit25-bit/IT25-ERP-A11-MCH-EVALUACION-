<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    public function getPublicationLabelAttribute(): string
    {
        if ($this->status !== 'completed') return $this->status_label;
        if ($this->published_at) return 'Resultado publicado';
        if ($this->validated_at) return 'Validada, pendiente de publicación';
        if ($this->reviewed_at) return 'Revisada, pendiente de validación';
        return 'Respondida, pendiente de revisión';
    }

    public function reviewer() { return $this->belongsTo(User::class, 'reviewed_by'); }
    public function validator() { return $this->belongsTo(User::class, 'validated_by'); }
    public function publisher() { return $this->belongsTo(User::class, 'published_by'); }

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

    /**
 * Obtener el nombre amigable del estado.
 */
public function getStatusLabelAttribute(): string
{
    return match ($this->status) {
        'draft' => 'Pendiente',
        'in_progress' => 'En proceso',
        'completed' => 'Completada',
        'cancelled' => 'Cancelada',
        default => ucfirst($this->status),
    };
}

}
