@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="dashboard-header">

        <h1>
            Períodos de evaluación
        </h1>

        <p>
            Administración de los períodos de evaluación del sistema.
        </p>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card border-0 table-card mb-4">

        <div class="card-body d-flex justify-content-between align-items-center">

            <div>

                <strong>
                    Catálogo
                </strong>

                <p class="text-muted mb-0">

                    Períodos de evaluación registrados.

                </p>

            </div>

            <a
                href="{{ route('evaluation-periods.create') }}"
                class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>

                Nuevo período

            </a>

        </div>

    </div>

    <div class="card border-0 table-card">

        <div class="card-header">

            Períodos registrados

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Nombre</th>

                            <th>Año</th>

                            <th>Fecha inicio</th>

                            <th>Fecha fin</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($evaluationPeriods as $evaluationPeriod)

                            <tr>

                                <td>

                                    {{ $evaluationPeriod->name }}

                                </td>

                                <td>

                                    {{ $evaluationPeriod->year }}

                                </td>

                                <td>

                                    {{ $evaluationPeriod->start_date }}

                                </td>

                                <td>

                                    {{ $evaluationPeriod->end_date }}

                                </td>

                                <td>

                                    @if($evaluationPeriod->is_active)

                                        <span class="badge bg-success">

                                            Activo

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Inactivo

                                        </span>

                                    @endif

                                </td>

                                <td>

                                    <a
                                        href="{{ route('evaluation-periods.show', $evaluationPeriod->id) }}"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    <a
                                        href="{{ route('evaluation-periods.edit', $evaluationPeriod->id) }}"
                                        class="btn btn-sm btn-outline-warning">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <form
                                        action="{{ route('evaluation-periods.destroy', $evaluationPeriod->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        @if($evaluationPeriod->is_active)

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Desea desactivar este período?')">

                                                <i class="bi bi-x-circle"></i>

                                            </button>

                                        @else

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-success"
                                                onclick="return confirm('¿Desea reactivar este período?')">

                                                <i class="bi bi-check-circle"></i>

                                            </button>

                                        @endif

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center">

                                    No hay registros.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection