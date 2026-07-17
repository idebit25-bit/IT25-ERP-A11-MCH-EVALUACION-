<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Información adicional
        </h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-4 mb-3">

                <label for="blood_type" class="form-label">
                    Tipo de sangre
                </label>

                <select
                    id="blood_type"
                    name="blood_type"
                    class="form-select @error('blood_type') is-invalid @enderror">

                    <option value="">Seleccione...</option>

                    @foreach ([
                        'A+','A-',
                        'B+','B-',
                        'AB+','AB-',
                        'O+','O-'
                    ] as $type)

                        <option
                            value="{{ $type }}"
                            {{ old('blood_type', $user->blood_type ?? '') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>

                    @endforeach

                </select>

                @error('blood_type')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label for="clothing_size" class="form-label">
                    Talla de ropa
                </label>

                <input
                    type="text"
                    id="clothing_size"
                    name="clothing_size"
                    class="form-control @error('clothing_size') is-invalid @enderror"
                    value="{{ old('clothing_size', $user->clothing_size ?? '') }}">

                @error('clothing_size')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-4 mb-3">

                <label for="shoe_size" class="form-label">
                    Talla de calzado
                </label>

                <input
                    type="text"
                    id="shoe_size"
                    name="shoe_size"
                    class="form-control @error('shoe_size') is-invalid @enderror"
                    value="{{ old('shoe_size', $user->shoe_size ?? '') }}">

                @error('shoe_size')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-3 mb-3">

                <div class="form-check mt-4">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        id="allergies"
                        name="allergies"
                        value="1"
                        {{ old('allergies', $user->allergies ?? false) ? 'checked' : '' }}>

                    <label class="form-check-label" for="allergies">
                        Presenta alergias
                    </label>

                </div>

            </div>

            <div class="col-md-9 mb-3">

                <label for="allergies_detail" class="form-label">
                    Especifique las alergias
                </label>

                <textarea
                    id="allergies_detail"
                    name="allergies_detail"
                    rows="3"
                    class="form-control @error('allergies_detail') is-invalid @enderror">{{ old('allergies_detail', $user->allergies_detail ?? '') }}</textarea>

                @error('allergies_detail')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>

</div>