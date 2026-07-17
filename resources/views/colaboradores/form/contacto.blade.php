<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Información de contacto
        </h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label for="email" class="form-label">
                    Correo institucional <span class="text-danger">*</span>
                </label>

                <input
                    type="email"
                    class="form-control @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email ?? '') }}">

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label for="email_personal" class="form-label">
                    Correo personal
                </label>

                <input
                    type="email"
                    class="form-control @error('email_personal') is-invalid @enderror"
                    id="email_personal"
                    name="email_personal"
                    value="{{ old('email_personal', $user->email_personal ?? '') }}">

                @error('email_personal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label for="phone" class="form-label">
                    Teléfono
                </label>

                <input
                    type="text"
                    class="form-control @error('phone') is-invalid @enderror"
                    id="phone"
                    name="phone"
                    value="{{ old('phone', $user->phone ?? '') }}">

                @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label for="emergency_number" class="form-label">
                    Teléfono de emergencia
                </label>

                <input
                    type="text"
                    class="form-control @error('emergency_number') is-invalid @enderror"
                    id="emergency_number"
                    name="emergency_number"
                    value="{{ old('emergency_number', $user->emergency_number ?? '') }}">

                @error('emergency_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>

</div>