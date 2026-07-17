<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    /**
     * Mostrar bitácora del sistema.
     */
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->latest()
            ->paginate(15);

        return view(
            'configuracion.bitacora.index',
            compact('logs')
        );
    }
}