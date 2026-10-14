<?php

namespace App\Http\Controllers;

use App\Models\{AccessRole, User};
use App\Services\ActivityLogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AccessController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate(['search' => ['nullable', 'string', 'max:100'], 'user_id' => ['nullable', 'integer', 'exists:users,id']]);
        $users = User::with('accessRoles')->orderBy('first_name')->orderBy('id');
        if (! empty($filters['user_id'])) $users->whereKey($filters['user_id']);
        if ($search = trim($filters['search'] ?? '')) {
            $users->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%'.$search.'%')
                    ->orWhere('paternal_surname', 'like', '%'.$search.'%')
                    ->orWhere('maternal_surname', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }
        return view('configuracion.accesos', [
            'users' => $users->paginate(5)->withQueryString(),
            'roles' => AccessRole::with('permissions')->where('guard_name', 'web')->whereIn('name', ['Super Admin', 'Admin', 'Usuario'])->get(),
            'permissions' => AccessRole::PERMISSIONS,
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $data = $request->validate([
            'role_id' => ['required', Rule::exists('roles', 'id')->where('guard_name', 'web')->whereIn('name', ['Super Admin', 'Admin', 'Usuario'])],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'password' => ['nullable', 'string', 'min:8', 'max:72', 'confirmed'],
        ]);
        DB::transaction(function () use ($id, $data, $request) {
            AccessRole::where('name', 'Super Admin')->where('guard_name', 'web')->lockForUpdate()->firstOrFail();
            $role = AccessRole::findOrFail($data['role_id']);
            $user = User::lockForUpdate()->findOrFail($id);
            if ((int) $user->id === (int) $request->user()->id && ($role->name !== 'Super Admin' || $data['status'] !== 'active')) {
                throw ValidationException::withMessages(['role_id' => 'No puede quitarse su propio acceso de superadministrador.']);
            }
            if ($user->hasAccessRole('Super Admin') && ($role->name !== 'Super Admin' || $data['status'] !== 'active')
                && ! User::where('id', '!=', $user->id)->where('status', 'active')->whereHas('accessRoles', fn ($q) => $q->where('name', 'Super Admin'))->exists()) {
                throw ValidationException::withMessages(['role_id' => 'Debe conservar un superadministrador activo.']);
            }
            $user->accessRoles()->sync([$role->id => ['model_type' => User::class]]);
            $user->status = $data['status'];
            if (! empty($data['password'])) $user->password = Hash::make($data['password']);
            $user->remember_token = null;
            $user->save();
            ActivityLogService::log(['module' => 'Accesos', 'action' => 'Actualizar', 'description' => 'Acceso actualizado para usuario #'.$user->id, 'record_id' => $user->id]);
        });
        return back()->with('success', 'Acceso actualizado.');
    }

    public function updatePermissions(Request $request, $id)
    {
        $role = AccessRole::where('guard_name', 'web')->findOrFail($id);
        abort_unless($role->name === 'Admin', 403, 'El superadministrador tiene acceso total y el colaborador conserva acceso personal.');
        $data = $request->validate(['permissions' => ['sometimes', 'array'], 'permissions.*' => ['string', Rule::in(array_keys(AccessRole::PERMISSIONS))]]);
        DB::transaction(function () use ($role, $data) {
            $moduleIds = DB::table('permissions')->where('guard_name', 'web')->whereIn('name', array_keys(AccessRole::PERMISSIONS))->pluck('id');
            $role->permissions()->detach($moduleIds);
            $ids = DB::table('permissions')->where('guard_name', 'web')->whereIn('name', $data['permissions'] ?? [])->pluck('id');
            $role->permissions()->syncWithoutDetaching($ids);
            ActivityLogService::log(['module' => 'Accesos', 'action' => 'Permisos', 'description' => 'Permisos del administrador actualizados.', 'record_id' => $role->id]);
        });
        return back()->with('success', 'Permisos actualizados.');
    }
}
