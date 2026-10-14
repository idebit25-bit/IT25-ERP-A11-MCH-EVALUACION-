<?php

namespace App\Http\Controllers;

use App\Models\UserEvaluation;
use App\Models\User;
use App\Models\Department;
use App\Models\Position;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

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

public function create()
{
    $user = new User();

    $departments = Department::where('is_active', true)
        ->orderBy('name')
        ->get();

    $positions = Position::where('is_active', true)
        ->orderBy('name')
        ->get();

    return view('colaboradores.create', compact(
        'user',
        'departments',
        'positions'
    ));
}

public function store(StoreUserRequest $request)
{
    \Illuminate\Support\Facades\DB::transaction(function () use ($request) {
        $user = User::create($request->validated());
        $role = \App\Models\AccessRole::where('name', 'Usuario')->where('guard_name', 'web')->firstOrFail();
        $user->accessRoles()->attach($role->id, ['model_type' => User::class]);
    });

    return redirect()
        ->route('colaboradores.index')
        ->with('success', 'Colaborador registrado correctamente.');
}

public function edit($id)
{
    $user = User::findOrFail($id);

    $departments = Department::where('is_active', true)
        ->orderBy('name')
        ->get();

    $positions = Position::where('is_active', true)
        ->orderBy('name')
        ->get();

    return view('colaboradores.edit', compact(
        'user',
        'departments',
        'positions'
    ));
}

public function update(UpdateUserRequest $request, $id)
{
    $user = User::findOrFail($id);

    $data = $request->safe()->except(['password', 'password_confirmation']);

    $user->update($data);

    return redirect()
        ->route('colaboradores.index')
        ->with('success', 'Colaborador actualizado correctamente.');
}
public function destroy($id)
{
    $user = User::findOrFail($id);

    if ($user->status === 'active') {

        $user->update([
            'status' => 'inactive'
        ]);

        $message = 'Colaborador desactivado correctamente.';

    } else {

        $user->update([
            'status' => 'active'
        ]);

        $message = 'Colaborador reactivado correctamente.';

    }

    return redirect()
        ->route('colaboradores.index')
        ->with('success', $message);
}



}
