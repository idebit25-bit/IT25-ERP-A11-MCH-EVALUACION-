<?php

namespace App\Http\Controllers;

use App\Models\UserEvaluation;
use App\Models\User;

class ColaboradorController extends Controller
{
   public function index()
{
    $query = User::with([
        'department',
        'position'
    ]);

    // Buscador
    if(request('search'))
    {
        $query->where(function($q)
        {
            $q->where('first_name', 'like', '%' . request('search') . '%')
              ->orWhere('paternal_surname', 'like', '%' . request('search') . '%')
              ->orWhere('employee_code', 'like', '%' . request('search') . '%')
              ->orWhere('email', 'like', '%' . request('search') . '%');
        });
    }

    // Ordenamiento
    if(request('order'))
    {
        switch(request('order'))
{
    case 'id':
        $query->orderBy('employee_code');
        break;

    case 'nombre':
        $query->orderBy('first_name');
        break;

    case 'fecha':
        $query->orderBy('entry_date');
        break;

    case 'estado':
        $query->orderBy('status');
        break;

    case 'departamento':
        $query->orderBy('department_id');
        break;

    case 'puesto':
        $query->orderBy('position_id');
        break;
}
    }

    $users = $query->paginate(5);
    $users->appends(request()->query());

    $totalUsers = User::count();

    $activeUsers = User::where('status', 'active')->count();

    $inactiveUsers = User::where('status', 'inactive')->count();

    $newUsers = User::whereYear('created_at', now()->year)->count();

    return view('colaboradores.index', compact(
        'users',
        'totalUsers',
        'activeUsers',
        'inactiveUsers',
        'newUsers'
    ));
}
public function show($id)
{
    $user = User::with([
    'department',
    'position'
])->findOrFail($id);

    return view('colaboradores.show', compact('user'));

}
}
