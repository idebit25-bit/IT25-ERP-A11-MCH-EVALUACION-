@extends('layouts.app')

@section('content')

<div class="content-wrapper">

    <div class="dashboard-header">

        <h1>

            Plantillas de evaluación

        </h1>

        <p>

            Administración de plantillas para las evaluaciones.

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

                    Plantillas

                </strong>

                <p class="text-muted mb-0">

                    Plantillas registradas.

                </p>

            </div>

            <a
                href="{{ route('evaluation-templates.create') }}"
                class="btn btn-primary">

                <i class="bi bi-plus-circle"></i>

                Nueva plantilla

            </a>

        </div>

    </div>

    <div class="card border-0 table-card">

        <div class="card-header">

            Plantillas registradas

        </div>

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th>Nombre</th>

                            <th>Tipo</th>

                            <th>Preguntas</th>

                            <th>Estado</th>

                            <th>Acciones</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($evaluationTemplates as $evaluationTemplate)

                            <tr>

                                <td>

                                    {{ $evaluationTemplate->name }}

                                </td>

                                <td>

                                    {{ $evaluationTemplate->evaluationType->name }}

                                </td>

                                <td>

                                    {{ $evaluationTemplate->template_questions_count }}

                                </td>

                                <td>

                                    @if($evaluationTemplate->is_active)

                                        <span class="badge bg-success">

                                            Activa

                                        </span>

                                    @else

                                        <span class="badge bg-danger">

                                            Inactiva

                                        </span>

                                    @endif

                                </td>

<td>

    <a
        href="{{ route('evaluation-templates.show', $evaluationTemplate->id) }}"
        class="btn btn-sm btn-outline-primary"
        title="Ver">

        <i class="bi bi-eye"></i>

    </a>

    <a
        href="{{ route('evaluation-templates.edit', $evaluationTemplate->id) }}"
        class="btn btn-sm btn-outline-warning"
        title="Editar">

        <i class="bi bi-pencil-square"></i>

    </a>

    <a
        href="{{ route('template-questions.index', $evaluationTemplate->id) }}"
        class="btn btn-sm btn-outline-info"
        title="Administrar preguntas">

        <i class="bi bi-ui-checks-grid"></i>

    </a>

    <form
        action="{{ route('evaluation-templates.destroy', $evaluationTemplate->id) }}"
        method="POST"
        class="d-inline">

        @csrf

        @method('DELETE')

        @if($evaluationTemplate->is_active)

            <button
                type="submit"
                class="btn btn-sm btn-outline-danger"
                onclick="return confirm('¿Desea desactivar esta plantilla?')">

                <i class="bi bi-x-circle"></i>

            </button>

        @else

            <button
                type="submit"
                class="btn btn-sm btn-outline-success"
                onclick="return confirm('¿Desea activar esta plantilla?')">

                <i class="bi bi-check-circle"></i>

            </button>

        @endif

    </form>

</td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center">

                                    No existen plantillas registradas.

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