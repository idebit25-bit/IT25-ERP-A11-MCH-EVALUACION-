<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Acceso al sistema
        </h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label for="username" class="form-label">
                    Usuario
                </label>

                <input
                    type="text"
                    id="username"
                    name="username"
                    class="form-control @error('username') is-invalid @enderror"
                    value="{{ old('username', $user->username ?? '') }}">

                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            @if(!isset($user) || !$user->exists)
            <div class="col-md-3 mb-3">

                <label for="password" class="form-label">
                    Contraseña
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror">

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-3 mb-3">

                <label for="password_confirmation" class="form-label">
                    Confirmar contraseña
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    class="form-control">

            </div>

            @else
                <div class="col-md-6 mb-3">
                    <p class="text-muted">Los cambios de contraseña y rol se realizan en Usuarios y permisos por el superadministrador.</p>
                    @if(auth()->user()->hasAccessRole('Super Admin'))
                        <a class="btn btn-outline-primary" href="{{ route('configuracion.roles', ['user_id' => $user->id]) }}">Administrar acceso</a>
                    @endif
                </div>
            @endif
        </div>

    </div>

</div>
