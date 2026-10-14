<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImprovementAction extends Model
{
    protected $guarded = ['id'];
    protected function casts(): array { return ['due_date' => 'date', 'progress' => 'integer']; }
    public function responsible() { return $this->belongsTo(User::class, 'responsible_id'); }
    public function getOverdueAttribute(): bool { return $this->progress < 100 && $this->due_date->lt(today()); }
}
