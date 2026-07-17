<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ActivityLogService
{
    /**
     * Registrar actividad del sistema.
     */
    public static function log(array $data): void
    {
        ActivityLog::create([

            'user_id' => Auth::id(),

            'module' => $data['module'],

            'action' => $data['action'],

            'description' => $data['description'],

            'record_id' => $data['record_id'] ?? null,

            'ip_address' => request()->ip(),

            'user_agent' => request()->userAgent(),

        ]);
    }
}