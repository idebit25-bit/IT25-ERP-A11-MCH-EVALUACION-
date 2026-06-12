<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEvaluation extends Model
{
    protected $table = 'user_evaluations';

    protected $fillable = [
        'user_id',
        'eval_1',
        'eval_2',
        'eval_3',
        'eval_4',
        'eval_5',
        'eval_6',
        'created_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}