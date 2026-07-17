<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogService;

class LogoutController extends Controller
{
    /**
     * Cerrar sesión.
     */
    public function destroy(Request $request)
    {
        ActivityLogService::log([

            'module' => 'Autenticación',

            'action' => 'Cerrar sesión',

            'description' => 'Cerró sesión en el sistema.',

        ]);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}