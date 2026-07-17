<div class="card shadow-sm mb-4">

    <div class="card-header">
        <h5 class="mb-0">
            Documentación
        </h5>
    </div>

    <div class="card-body">

        <div class="row">

            <div class="col-md-6 mb-3">

                <label for="image" class="form-label">
                    Fotografía
                </label>

                <input
                    type="file"
                    id="image"
                    name="image"
                    class="form-control @error('image') is-invalid @enderror"
                    accept="image/*">

                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label for="cv" class="form-label">
                    Currículum (PDF)
                </label>

                <input
                    type="file"
                    id="cv"
                    name="cv"
                    class="form-control @error('cv') is-invalid @enderror"
                    accept=".pdf">

                @error('cv')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label for="file_csf" class="form-label">
                    Constancia de Situación Fiscal
                </label>

                <input
                    type="file"
                    id="file_csf"
                    name="file_csf"
                    class="form-control @error('file_csf') is-invalid @enderror"
                    accept=".pdf">

                @error('file_csf')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label for="validity_csf" class="form-label">
                    Vigencia de la CSF
                </label>

                <input
                    type="date"
                    id="validity_csf"
                    name="validity_csf"
                    class="form-control @error('validity_csf') is-invalid @enderror"
                    value="{{ old('validity_csf', $user->validity_csf ?? '') }}">

                @error('validity_csf')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label for="birth_certificate" class="form-label">
                    Acta de nacimiento
                </label>

                <input
                    type="file"
                    id="birth_certificate"
                    name="birth_certificate"
                    class="form-control @error('birth_certificate') is-invalid @enderror"
                    accept=".pdf">

                @error('birth_certificate')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

            <div class="col-md-6 mb-3">

                <label for="ine" class="form-label">
                    INE
                </label>

                <input
                    type="file"
                    id="ine"
                    name="ine"
                    class="form-control @error('ine') is-invalid @enderror"
                    accept=".pdf">

                @error('ine')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>

    </div>

</div>