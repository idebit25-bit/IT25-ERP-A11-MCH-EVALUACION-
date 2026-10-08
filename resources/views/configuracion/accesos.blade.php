@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="dashboard-header"><h1>Roles y permisos</h1><p>Administración de accesos del módulo Capital Humano.</p></div>
    <div class="card border-0 shadow-sm mb-4"><div class="card-body"><h5>Permisos del administrador</h5>
        <p>El superadministrador tiene acceso total. El usuario común consulta documentos; los flujos personales de evaluación quedan pendientes.</p>
        @foreach($roles->where('name','Admin') as $role)
        <form action="{{ route('accesos.permissions',$role->id) }}" method="POST">@csrf @method('PUT')
            @foreach($permissions as $name=>$label)<div class="form-check mb-2"><input type="checkbox" name="permissions[]" value="{{ $name }}" id="permission-{{ $loop->index }}" class="form-check-input" @checked($role->permissions->contains('name',$name))><label for="permission-{{ $loop->index }}" class="form-check-label">{{ $label }}</label></div>@endforeach
            <button class="btn btn-primary mt-2">Guardar permisos</button>
        </form>
        @endforeach
    </div></div>
    <div class="card border-0 shadow-sm"><div class="card-body"><h5>Cuentas y roles</h5>
    @foreach($users as $user)
        <details class="border rounded p-3 mb-3"><summary>{{ $user->full_name }} — {{ $user->email }} <span class="badge bg-secondary">{{ $user->accessRoles->pluck('name')->implode(', ') ?: 'Sin rol' }}</span></summary>
            <form action="{{ route('accesos.update',$user->id) }}" method="POST" class="mt-3">@csrf @method('PUT')
                <div class="row">
                    <div class="col-md-6 mb-3"><label class="form-label" for="role-{{ $user->id }}">Rol</label><select class="form-select" id="role-{{ $user->id }}" name="role_id" required><option value="">Seleccione</option>@foreach($roles as $role)<option value="{{ $role->id }}" @selected($user->accessRoles->contains('id',$role->id))>{{ $role->name }}</option>@endforeach</select></div>
                    <div class="col-md-6 mb-3"><label class="form-label" for="status-{{ $user->id }}">Estado</label><select class="form-select" id="status-{{ $user->id }}" name="status"><option value="active" @selected($user->status==='active')>Activo</option><option value="inactive" @selected($user->status==='inactive')>Inactivo</option></select></div>
                    <div class="col-md-6 mb-3"><label class="form-label" for="password-{{ $user->id }}">Nueva contraseña (opcional)</label><input class="form-control" id="password-{{ $user->id }}" name="password" type="password" autocomplete="new-password" minlength="8"></div>
                    <div class="col-md-6 mb-3"><label class="form-label" for="confirmation-{{ $user->id }}">Confirmar contraseña</label><input class="form-control" id="confirmation-{{ $user->id }}" name="password_confirmation" type="password" autocomplete="new-password"></div>
                </div>
                <button class="btn btn-primary">Actualizar acceso</button>
            </form>
        </details>
    @endforeach
    {{ $users->links() }}
    </div></div>
</div>
@endsection
