@extends('layouts.app')
@section('content')
@php
    $roleLabels = ['Super Admin' => 'Superadministrador', 'Admin' => 'Administrador', 'Usuario' => 'Usuario'];
    $roleInfo = [
        'Super Admin' => ['icon' => 'bi-shield-lock', 'text' => 'Acceso completo. Administra cuentas, permisos y reaperturas.'],
        'Admin' => ['icon' => 'bi-person-gear', 'text' => 'Gestiona los módulos habilitados. Sus permisos se configuran abajo.'],
        'Usuario' => ['icon' => 'bi-person', 'text' => 'Consulta documentos y participa en sus evaluaciones como evaluado o evaluador.'],
    ];
    $permissionInfo = [
        'evaluaciones.gestionar' => ['bi-clipboard-check', 'Evaluaciones', 'Gestionar evaluaciones, validar y publicar resultados revisados.'],
        'documentos.gestionar' => ['bi-folder', 'Documentos', 'Registrar, editar, reemplazar PDFs y eliminar documentos.'],
        'colaboradores.gestionar' => ['bi-people', 'Colaboradores', 'Administrar colaboradores sin modificar cuentas privilegiadas.'],
        'reportes.consultar' => ['bi-bar-chart', 'Reportes', 'Consultar y exportar reportes del módulo.'],
        'configuracion.evaluaciones' => ['bi-gear', 'Catálogos de evaluación', 'Configurar tipos, periodos, preguntas, escalas y plantillas.'],
    ];
@endphp
<div class="content-wrapper access-page">
    <div class="dashboard-header d-flex justify-content-between align-items-start gap-3 flex-wrap">
        <div><h1>Roles y permisos</h1><p>Define qué puede hacer cada rol y administra el acceso de las cuentas.</p></div>
        <span class="badge text-bg-light border p-2"><i class="bi bi-shield-lock me-1" aria-hidden="true"></i> Solo superadministradores</span>
    </div>

    <div class="row g-3 mb-4">
        @foreach($roleInfo as $name => $info)
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm h-100 access-role-card">
                    <div class="card-body d-flex gap-3">
                        <span class="access-icon"><i class="bi {{ $info['icon'] }}" aria-hidden="true"></i></span>
                        <div>
                            <h2 class="h6 fw-bold mb-2">{{ $roleLabels[$name] }}</h2>
                            <p class="text-muted small mb-2">{{ $info['text'] }}</p>
                            <span class="badge {{ $name === 'Admin' ? 'bg-primary-subtle text-primary-emphasis' : 'text-bg-light border' }}">{{ $name === 'Admin' ? 'Permisos configurables' : 'Acceso definido por el sistema' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row g-4 align-items-start">
        <section class="col-xl-4" aria-labelledby="permissions-title">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h2 class="h5" id="permissions-title"><i class="bi bi-sliders me-2" aria-hidden="true"></i>Permisos del administrador</h2>
                    <p class="text-muted small">Estos cambios se aplican a <strong>todas las cuentas con rol Administrador</strong>. No modifican el acceso del superadministrador ni del usuario común.</p>
                    @foreach($roles->where('name', 'Admin') as $role)
                        <form action="{{ route('accesos.permissions', $role->id) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="_access_form" value="permissions">
                            <div class="access-permissions">
                                @foreach($permissions as $name => $label)
                                    @php
                                        $info = $permissionInfo[$name];
                                        $checked = old('_access_form') === 'permissions'
                                            ? in_array($name, (array) old('permissions', []))
                                            : $role->permissions->contains('name', $name);
                                    @endphp
                                    <label class="access-permission" for="permission-{{ $loop->index }}">
                                        <i class="bi {{ $info[0] }} text-primary" aria-hidden="true"></i>
                                        <span><strong class="d-block">{{ $info[1] }}</strong><small class="text-muted">{{ $info[2] }}</small></span>
                                        <input type="checkbox" name="permissions[]" value="{{ $name }}" id="permission-{{ $loop->index }}" class="form-check-input" @checked($checked)>
                                    </label>
                                @endforeach
                            </div>
                            @error('permissions')<p class="text-danger small" role="alert">{{ $message }}</p>@enderror
                            <p class="small text-muted mt-3"><i class="bi bi-info-circle me-1" aria-hidden="true"></i>Desmarcar una opción retira ese permiso. Los cambios se aplican al guardar.</p>
                            <button class="btn btn-primary w-100" type="submit"><i class="bi bi-check2 me-1" aria-hidden="true"></i> Guardar permisos del rol</button>
                        </form>
                    @endforeach
                </div>
            </div>
        </section>

        <section class="col-xl-8" aria-labelledby="accounts-title">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                        <h2 class="h5 mb-0" id="accounts-title"><i class="bi bi-people me-2" aria-hidden="true"></i>Cuentas y accesos</h2>
                        <span class="badge text-bg-light border">{{ $users->total() }} {{ request('search') ? 'coincidencias' : 'cuentas' }}</span>
                    </div>
                    <p class="small text-muted">Abre una cuenta para cambiar su rol, estado o contraseña.</p>
                    <form action="{{ route('configuracion.roles') }}" method="GET" class="mb-4" role="search">
                        <label class="form-label small" for="access-search">Buscar por nombre, apellido o correo</label>
                        <div class="d-flex gap-2 flex-wrap">
                            <input id="access-search" type="search" name="search" class="form-control access-search" value="{{ request('search') }}" maxlength="100" placeholder="Ej. Daniel o correo@empresa.com">
                            <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search me-1" aria-hidden="true"></i>Buscar</button>
                            @if(request('search'))<a href="{{ route('configuracion.roles') }}" class="btn btn-outline-secondary">Limpiar</a>@endif
                        </div>
                    </form>
                    <div>
                    @forelse($users as $user)
                        @php($isOld = (string) old('_access_user') === (string) $user->id)
                        <details class="access-account mb-3" @if($isOld) open @endif>
                            <summary>
                                <span class="access-avatar" aria-hidden="true"><i class="bi bi-person"></i></span>
                                <span class="access-account-name">
                                    <strong class="d-block">{{ $user->full_name }}</strong>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </span>
                                <span class="access-account-badges">
                                    @if($user->id === auth()->id())<span class="badge text-bg-light border">Tu cuenta</span>@endif
                                    <span class="badge bg-primary-subtle text-primary-emphasis">{{ $user->accessRoles->map(fn ($role) => $roleLabels[$role->name] ?? $role->name)->implode(', ') ?: 'Sin rol' }}</span>
                                    <span class="badge {{ $user->status === 'active' ? 'bg-success-subtle text-success-emphasis' : 'text-bg-light border' }}">{{ $user->status === 'active' ? 'Activo' : 'Inactivo' }}</span>
                                </span>
                                <i class="bi bi-chevron-down access-chevron" aria-hidden="true"></i>
                            </summary>
                            <form action="{{ route('accesos.update', $user->id) }}" method="POST" class="access-account-form">
                                @csrf @method('PUT')
                                <input type="hidden" name="_access_user" value="{{ $user->id }}">
                                @if($user->id === auth()->id())
                                    <div class="alert alert-light border small">Esta es tu cuenta. Debes conservar tu rol de superadministrador y el estado activo para mantener el acceso.</div>
                                @endif
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label" for="role-{{ $user->id }}">Rol de acceso</label>
                                        <select class="form-select {{ $isOld && $errors->has('role_id') ? 'is-invalid' : '' }}" id="role-{{ $user->id }}" name="role_id" required>
                                            <option value="">Selecciona un rol</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" @selected($isOld ? old('role_id') == $role->id : $user->accessRoles->contains('id', $role->id))>{{ $roleLabels[$role->name] }}</option>
                                            @endforeach
                                        </select>
                                        @if($isOld) @error('role_id')<div class="invalid-feedback">{{ $message }}</div>@enderror @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="status-{{ $user->id }}">Estado de la cuenta</label>
                                        <select class="form-select" id="status-{{ $user->id }}" name="status">
                                            <option value="active" @selected(($isOld ? old('status') : $user->status) === 'active')>Activo</option>
                                            <option value="inactive" @selected(($isOld ? old('status') : $user->status) === 'inactive')>Inactivo</option>
                                        </select>
                                        <div class="form-text">Una cuenta inactiva no puede acceder al sistema.</div>
                                    </div>
                                    <div class="col-12"><hr class="my-1"><p class="small text-muted mt-3 mb-0">Cambiar contraseña es opcional. Deja ambos campos vacíos para conservar la actual.</p></div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="password-{{ $user->id }}">Nueva contraseña</label>
                                        <input class="form-control {{ $isOld && $errors->has('password') ? 'is-invalid' : '' }}" id="password-{{ $user->id }}" name="password" type="password" autocomplete="new-password" minlength="8" maxlength="72">
                                        <div class="form-text">De 8 a 72 caracteres.</div>
                                        @if($isOld) @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror @endif
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label" for="confirmation-{{ $user->id }}">Confirmar nueva contraseña</label>
                                        <input class="form-control" id="confirmation-{{ $user->id }}" name="password_confirmation" type="password" autocomplete="new-password" maxlength="72">
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap mt-4">
                                    <small class="text-muted">Los cambios afectan solo a esta cuenta.</small>
                                    <button class="btn btn-primary" type="submit"><i class="bi bi-check2 me-1" aria-hidden="true"></i> Guardar acceso</button>
                                </div>
                            </form>
                        </details>
                    @empty
                        <div class="text-center py-4">
                            <i class="bi bi-search fs-2 text-muted" aria-hidden="true"></i>
                            <h3 class="h6 mt-3">No se encontraron cuentas</h3>
                            <p class="text-muted small">Prueba con otro nombre o correo, o limpia la búsqueda.</p>
                        </div>
                    @endforelse
                    </div>
                    <div class="mt-auto pt-3 border-top d-flex justify-content-between align-items-center gap-2 flex-wrap">
                        <small class="text-muted">Mostrando {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} de {{ $users->total() }} cuentas</small>
                        <nav aria-label="Páginas de cuentas" class="d-flex align-items-center gap-2">
                            @if($users->onFirstPage())
                                <button type="button" class="btn btn-outline-secondary btn-sm" disabled aria-label="Página anterior"><i class="bi bi-chevron-left" aria-hidden="true"></i></button>
                            @else
                                <a href="{{ $users->previousPageUrl() }}" class="btn btn-outline-primary btn-sm" aria-label="Página anterior" title="Página anterior"><i class="bi bi-chevron-left" aria-hidden="true"></i></a>
                            @endif
                            <span class="small">Página {{ $users->currentPage() }} de {{ $users->lastPage() }}</span>
                            @if($users->hasMorePages())
                                <a href="{{ $users->nextPageUrl() }}" class="btn btn-outline-primary btn-sm" aria-label="Página siguiente" title="Página siguiente"><i class="bi bi-chevron-right" aria-hidden="true"></i></a>
                            @else
                                <button type="button" class="btn btn-outline-secondary btn-sm" disabled aria-label="Página siguiente"><i class="bi bi-chevron-right" aria-hidden="true"></i></button>
                            @endif
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
