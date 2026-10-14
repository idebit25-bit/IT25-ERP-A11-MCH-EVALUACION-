<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Información laboral
        </h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label for="department_id" class="form-label">
                    Departamento <span class="text-danger">*</span>
                </label>

                <select
                    name="department_id"
                    id="department_id"
                    class="form-select @error('department_id') is-invalid @enderror">

                    <option value="">
                        Seleccione un departamento
                    </option>

                    @foreach($departments as $department)

                        <option
                            value="{{ $department->id }}"
                            {{ old('department_id', $user->department_id ?? '') == $department->id ? 'selected' : '' }}>

                            {{ $department->name }}

                        </option>

                    @endforeach

                </select>

                @error('department_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label for="position_id" class="form-label">
                    Puesto <span class="text-danger">*</span>
                </label>

                <select
                    name="position_id"
                    id="position_id"
                    class="form-select @error('position_id') is-invalid @enderror">

                    <option value="">
                        Seleccione un puesto
                    </option>

                    @foreach($positions as $position)

                        <option
                            value="{{ $position->id }}"
                            {{ old('position_id', $user->position_id ?? '') == $position->id ? 'selected' : '' }}>

                            {{ $position->name }}

                        </option>

                    @endforeach

                </select>

                @error('position_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label for="entry_date" class="form-label">
                    Fecha de ingreso
                </label>

                <input
                    type="date"
                    id="entry_date"
                    name="entry_date"
                    class="form-control @error('entry_date') is-invalid @enderror"
                    value="{{ old('entry_date', $user->entry_date ?? '') }}">

                @error('entry_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label for="status" class="form-label">
                    Estatus
                </label>

                <select
                    name="status"
                    id="status"
                    class="form-select @error('status') is-invalid @enderror">

                    <option value="active"
                        {{ old('status', $user->status ?? 'active') == 'active' ? 'selected' : '' }}>
                        Activo
                    </option>

                    <option value="inactive"
                        {{ old('status', $user->status ?? '') == 'inactive' ? 'selected' : '' }}>
                        Inactivo
                    </option>

                </select>

                <div class="form-text">Este estado también controla el acceso al sistema: desactivar al colaborador impide que inicie sesión.</div>
                @error('status')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>

</div>
