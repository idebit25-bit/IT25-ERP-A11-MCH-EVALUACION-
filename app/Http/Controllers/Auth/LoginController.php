<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\ActivityLogService;

class LoginController extends Controller
{
    /**
     * Mostrar formulario.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Iniciar sesión.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([

            'email' => [

                'required',

                'email',

            ],

            'password' => [

                'required',

            ],

        ]);

if (Auth::attempt($credentials + ['status' => 'active'])) {

    $request->session()->regenerate();

    ActivityLogService::log([

        'module' => 'Autenticación',

        'action' => 'Iniciar sesión',

        'description' => 'Inició sesión en el sistema.',

    ]);

    return redirect()->intended('/');

}

        return back()

            ->withErrors([

                'email' => 'Las credenciales son incorrectas.',

            ])

            ->onlyInput('email');
    }
}
