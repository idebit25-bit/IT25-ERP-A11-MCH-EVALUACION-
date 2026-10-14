<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImprovementPlan extends Model
{
    protected $guarded = ['id'];
    protected function casts(): array { return ['source_result' => 'array', 'closed_at' => 'datetime']; }
    public function evaluation() { return $this->belongsTo(Evaluation::class); }
    public function user() { return $this->belongsTo(User::class); }
    public function actions() { return $this->hasMany(ImprovementAction::class); }
    public function updates() { return $this->hasMany(ImprovementUpdate::class); }

    public function scopeVisibleTo($query, User $user)
    {
        if ($user->hasModulePermission('evaluaciones.gestionar')) return $query;
        return $query->where(fn ($q) => $q->where('user_id', $user->id)
            ->orWhereHas('actions', fn ($actions) => $actions->where('responsible_id', $user->id)));
    }

    public function getStatusLabelAttribute(): string
    {
        return ['active' => 'En seguimiento', 'completed' => 'Cerrado', 'cancelled' => 'Cancelado'][$this->status] ?? $this->status;
    }
}
