<div class="container-fluid">

@include('colaboradores.form.personales')

@include('colaboradores.form.laborales')

@include('colaboradores.form.contacto')

@include('colaboradores.form.acceso')

@include('colaboradores.form.domicilio')

@include('colaboradores.form.adicionales')

@include('colaboradores.form.documentos')

    <div class="mt-4 d-flex justify-content-end gap-2">

        <a href="{{ route('colaboradores.index') }}"
           class="btn btn-secondary">
            Cancelar
        </a>

        <button type="submit"
                class="btn btn-primary">

            Guardar colaborador

        </button>

    </div>

</div>