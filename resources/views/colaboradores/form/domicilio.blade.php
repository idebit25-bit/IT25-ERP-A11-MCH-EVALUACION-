<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Domicilio
        </h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-3 mb-3">

                <label for="postal_code" class="form-label">
                    Código Postal
                </label>

                <input
                    type="text"
                    id="postal_code"
                    name="postal_code"
                    maxlength="5"
                    class="form-control @error('postal_code') is-invalid @enderror"
                    value="{{ old('postal_code', $user->postal_code ?? '') }}">

                @error('postal_code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-3 mb-3">

                <label for="state_id" class="form-label">
                    Estado
                </label>

                <select
                    id="state_id"
                    name="state_id"
                    class="form-select @error('state_id') is-invalid @enderror">

                    <option value="">
                        Seleccione...
                    </option>

                </select>

                @error('state_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-3 mb-3">

                <label for="municipality_id" class="form-label">
                    Municipio
                </label>

                <select
                    id="municipality_id"
                    name="municipality_id"
                    class="form-select @error('municipality_id') is-invalid @enderror">

                    <option value="">
                        Seleccione...
                    </option>

                </select>

                @error('municipality_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-3 mb-3">

                <label for="neighborhood_id" class="form-label">
                    Colonia
                </label>

                <select
                    id="neighborhood_id"
                    name="neighborhood_id"
                    class="form-select @error('neighborhood_id') is-invalid @enderror">

                    <option value="">
                        Seleccione...
                    </option>

                </select>

                @error('neighborhood_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label for="street" class="form-label">
                    Calle
                </label>

                <input
                    type="text"
                    id="street"
                    name="street"
                    class="form-control @error('street') is-invalid @enderror"
                    value="{{ old('street', $user->street ?? '') }}">

                @error('street')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-3 mb-3">

                <label for="exterior_number" class="form-label">
                    Número exterior
                </label>

                <input
                    type="text"
                    id="exterior_number"
                    name="exterior_number"
                    class="form-control @error('exterior_number') is-invalid @enderror"
                    value="{{ old('exterior_number', $user->exterior_number ?? '') }}">

                @error('exterior_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-3 mb-3">

                <label for="interior_number" class="form-label">
                    Número interior
                </label>

                <input
                    type="text"
                    id="interior_number"
                    name="interior_number"
                    class="form-control @error('interior_number') is-invalid @enderror"
                    value="{{ old('interior_number', $user->interior_number ?? '') }}">

                @error('interior_number')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>

</div>