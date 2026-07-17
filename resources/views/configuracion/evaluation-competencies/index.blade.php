@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="dashboard-header">

        <h1>
            Competencias de evaluación
        </h1>

        <p>
            Administración de las competencias de evaluación del sistema.
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

                    Competencias registradas.

                </p>

            </div>

            <a
                href="{{ route('evaluation-competencies.create') }}"
                class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>

                Nueva competencia

            </a>

        </div>

    </div>

    <div class="card border-0 table-card">

        <div class="card-header">

            Competencias registradas

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>

                            <th>Categoría</th>

                            <th>Competencia</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($evaluationCompetencies as $evaluationCompetency)

                            <tr>

                                <td>

                                    {{ $evaluationCompetency->category->name }}

                                </td>

                                <td>

                                    {{ $evaluationCompetency->name }}

                                </td>

                                <td>

                                    @if($evaluationCompetency->is_active)

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
                                        href="{{ route('evaluation-competencies.show', $evaluationCompetency->id) }}"
                                        class="btn btn-sm btn-outline-primary">

                                        <i class="bi bi-eye"></i>

                                    </a>

                                    <a
                                        href="{{ route('evaluation-competencies.edit', $evaluationCompetency->id) }}"
                                        class="btn btn-sm btn-outline-warning">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <form
                                        action="{{ route('evaluation-competencies.destroy', $evaluationCompetency->id) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf

                                        @method('DELETE')

                                        @if($evaluationCompetency->is_active)

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                onclick="return confirm('¿Desea desactivar esta competencia?')">

                                                <i class="bi bi-x-circle"></i>

                                            </button>

                                        @else

                                            <button
                                                type="submit"
                                                class="btn btn-sm btn-outline-success"
                                                onclick="return confirm('¿Desea reactivar esta competencia?')">

                                                <i class="bi bi-check-circle"></i>

                                            </button>

                                        @endif

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="4" class="text-center">

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