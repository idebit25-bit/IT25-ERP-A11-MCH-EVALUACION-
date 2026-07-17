<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Datos personales
        </h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3 mb-3">
                <label for="employee_code" class="form-label">
                    Código de colaborador <span class="text-danger">*</span>
                </label>

                <input
                    type="text"
                    class="form-control @error('employee_code') is-invalid @enderror"
                    id="employee_code"
                    name="employee_code"
                    value="{{ old('employee_code', $user->employee_code ?? '') }}">

                @error('employee_code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-5 mb-3">

                <label for="first_name" class="form-label">
                    Nombre(s) <span class="text-danger">*</span>
                </label>

                <input
                    type="text"
                    class="form-control @error('first_name') is-invalid @enderror"
                    id="first_name"
                    name="first_name"
                    value="{{ old('first_name', $user->first_name ?? '') }}">

                @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label for="paternal_surname" class="form-label">

                    Apellido paterno

                </label>

                <input
                    type="text"
                    class="form-control @error('paternal_surname') is-invalid @enderror"
                    id="paternal_surname"
                    name="paternal_surname"
                    value="{{ old('paternal_surname', $user->paternal_surname ?? '') }}">

                @error('paternal_surname')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label for="maternal_surname" class="form-label">

                    Apellido materno

                </label>

                <input
                    type="text"
                    class="form-control @error('maternal_surname') is-invalid @enderror"
                    id="maternal_surname"
                    name="maternal_surname"
                    value="{{ old('maternal_surname', $user->maternal_surname ?? '') }}">

                @error('maternal_surname')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label for="last_name" class="form-label">

                    Apellido adicional

                </label>

                <input
                    type="text"
                    class="form-control @error('last_name') is-invalid @enderror"
                    id="last_name"
                    name="last_name"
                    value="{{ old('last_name', $user->last_name ?? '') }}">

                @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-2 mb-3">

                <label for="gender" class="form-label">

                    Género

                </label>

                <select
                    class="form-select @error('gender') is-invalid @enderror"
                    id="gender"
                    name="gender">

                    <option value="">Seleccione</option>

                    <option value="Masculino"
                        {{ old('gender', $user->gender ?? '') == 'Masculino' ? 'selected' : '' }}>
                        Masculino
                    </option>

                    <option value="Femenino"
                        {{ old('gender', $user->gender ?? '') == 'Femenino' ? 'selected' : '' }}>
                        Femenino
                    </option>

                </select>

                @error('gender')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label for="nationality" class="form-label">

                    Nacionalidad

                </label>

                <input
                    type="text"
                    class="form-control @error('nationality') is-invalid @enderror"
                    id="nationality"
                    name="nationality"
                    value="{{ old('nationality', $user->nationality ?? '') }}">

                @error('nationality')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-3 mb-3">

                <label for="birthdate" class="form-label">

                    Fecha de nacimiento

                </label>

                <input
                    type="date"
                    class="form-control @error('birthdate') is-invalid @enderror"
                    id="birthdate"
                    name="birthdate"
                    value="{{ old('birthdate', $user->birthdate ?? '') }}">

                @error('birthdate')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>

</div>