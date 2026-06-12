@extends('layouts.app')

@section('content')

<div class="content-wrapper">

<a href="/colaboradores" class="btn btn-secondary mb-3">
    <i class="bi bi-arrow-left"></i>
    Regresar
</a>

    <div class="card shadow-sm border-0 mb-4">

    <div class="card-body text-center">

        <i class="bi bi-person-circle display-1 text-secondary"></i>

        <h2 class="mt-3">
            {{ $user->first_name }}
            {{ $user->paternal_surname }}
        </h2>

        <p class="text-muted">
            {{ $user->employee_code }}
        </p>

    </div>

</div>

<div class="row">

    <div class="col-md-4">

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header">
                Datos Personales
            </div>

            <div class="card-body">

                <p><strong>Correo:</strong><br>{{ $user->email }}</p>

                <p><strong>Teléfono:</strong><br>{{ $user->phone }}</p>

                <p><strong>Nacionalidad:</strong><br>{{ $user->nationality }}</p>

                <p><strong>Género:</strong><br>{{ $user->gender }}</p>

                <p><strong>Nacimiento:</strong><br>{{ $user->birthdate }}</p>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header">
                Datos Laborales
            </div>

            <div class="card-body">

                <p>
                    <strong>Departamento:</strong><br>

                    {{ $user->department->name ?? 'Sin departamento' }}
                </p>

                <p>
                    <strong>Puesto:</strong><br>
                    {{ $user->position->name ?? 'Sin puesto'}}
                </p>

                <p>
                    <strong>Fecha ingreso:</strong><br>

                    {{ $user->entry_date }}
                </p>

                <p>
                    <strong>Estado:</strong><br>

                    @if($user->status == 'active')

    <span class="badge bg-success">
        Activo
    </span>

@elseif($user->status == 'inactive')

    <span class="badge bg-danger">
        Inactivo
    </span>

@else

    <span class="badge bg-secondary">
        {{ $user->status }}
    </span>

@endif
                </p>

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card shadow-sm border-0 mb-4">

            <div class="card-header">
                Datos Oficiales
            </div>

            <div class="card-body">

                <p><strong>RFC:</strong><br>{{ $user->rfc }}</p>

                <p><strong>CURP:</strong><br>{{ $user->curp }}</p>

                <p><strong>NSS:</strong><br>{{ $user->nss }}</p>

                <p><strong>Tipo de sangre:</strong><br>{{ $user->blood_type }}</p>

            </div>

        </div>

    </div>

</div>

</div>

@endsection