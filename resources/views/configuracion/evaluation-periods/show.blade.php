@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <a
        href="{{ route('evaluation-periods.index') }}"
        class="btn btn-secondary mb-3">

        <i class="bi bi-arrow-left"></i>

        Regresar

    </a>

    <div class="card shadow-sm border-0">

        <div class="card-header">

            Información del período de evaluación

        </div>

        <div class="card-body">

            <p>

                <strong>Nombre:</strong><br>

                {{ $evaluationPeriod->name }}

            </p>

            <p>

                <strong>Año:</strong><br>

                {{ $evaluationPeriod->year }}

            </p>

            <p>

                <strong>Fecha de inicio:</strong><br>

                {{ $evaluationPeriod->start_date }}

            </p>

            <p>

                <strong>Fecha de fin:</strong><br>

                {{ $evaluationPeriod->end_date }}

            </p>

            <p>

                <strong>Descripción:</strong><br>

                {{ $evaluationPeriod->description }}

            </p>

            <p>

                <strong>Estado:</strong><br>

                @if($evaluationPeriod->is_active)

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