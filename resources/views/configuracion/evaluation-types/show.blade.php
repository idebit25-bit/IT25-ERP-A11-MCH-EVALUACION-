@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <a
        href="{{ route('evaluation-types.index') }}"
        class="btn btn-secondary mb-3">

        <i class="bi bi-arrow-left"></i>

        Regresar

    </a>

    <div class="card shadow-sm border-0">

        <div class="card-header">

            Información del tipo de evaluación

        </div>

        <div class="card-body">

            <p>

                <strong>Código:</strong><br>

                {{ $evaluationType->code }}

            </p>

            <p>

                <strong>Nombre:</strong><br>

                {{ $evaluationType->name }}

            </p>

            <p>

                <strong>Descripción:</strong><br>

                {{ $evaluationType->description }}

            </p>

            <p>

                <strong>Estado:</strong><br>

                @if($evaluationType->is_active)

                    <span class="badge bg-success">

                        Activo

                    </span>

                @else

                    <span class="badge bg-danger">

                        Inactivo

                    </span>

                @endif

            </p>

        </div>

    </div>

</div>

@endsection