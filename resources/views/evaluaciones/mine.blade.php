@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="dashboard-header">
        <h1>Mis evaluaciones</h1>
        <p>Consulta las evaluaciones en las que participas como colaborador evaluado o evaluador.</p>
    </div>

    <a href="{{ route('mis-evaluaciones.history') }}" class="btn btn-outline-primary mb-4"><i class="bi bi-graph-up" aria-hidden="true"></i> Mi historial de desempeño</a>
    <div class="row g-3 mb-4">
        @foreach(['Pendientes' => $pending, 'Completadas' => $completed, 'Canceladas' => $cancelled] as $label => $count)
            <div class="col-sm-4">
                <div class="card stats-card border-0"><div class="card-body">
                    <span class="stats-label">{{ $label }}</span><h2>{{ $count }}</h2>
                </div></div>
            </div>
        @endforeach
    </div>

    <div class="card border-0 table-card">
        <div class="card-body">
            <form method="GET" action="{{ route('mis-evaluaciones.index') }}" class="d-flex align-items-end flex-wrap gap-2 mb-4">
                <div>
                    <label class="form-label" for="evaluation-status">Estado</label>
                    <select class="form-select" id="evaluation-status" name="status">
                        @foreach(['' => 'Todas', 'pending' => 'Pendientes', 'completed' => 'Completadas', 'cancelled' => 'Canceladas'] as $value => $label)
                            <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-dark">Filtrar</button>
                @if($status !== '')<a class="btn btn-outline-secondary" href="{{ route('mis-evaluaciones.index') }}">Limpiar filtro</a>@endif
            </form>

            @if($evaluations->isEmpty())
                <div class="text-center py-4">
                    <i class="bi bi-clipboard-check fs-2 text-muted" aria-hidden="true"></i>
                    <h5 class="mt-2">{{ $status !== '' ? 'No hay evaluaciones con este estado' : 'Aún no tienes evaluaciones asignadas' }}</h5>
                    <p class="text-muted mb-0">{{ $status !== '' ? 'Selecciona otro estado o limpia el filtro para consultar las demás.' : 'Cuando te asignen una evaluación, aparecerá aquí. También recibirás un aviso en la campana.' }}</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table align-middle">
                        <caption>Evaluaciones en las que participas. Esta pantalla permite consultar las asignaciones.</caption>
                        <thead><tr><th scope="col">Evaluación</th><th scope="col">Periodo</th><th scope="col">Fecha</th><th scope="col">Tu participación</th><th scope="col">Colaborador</th><th scope="col">Evaluador</th><th scope="col">Estado</th><th scope="col" class="text-end">Acción</th></tr></thead>
                        <tbody>
                            @foreach($evaluations as $evaluation)
                                <tr>
                                    <td>
                                        <span class="d-block fw-semibold">{{ $evaluation->evaluationType?->name ?? 'Sin tipo' }}</span>
                                        <small class="text-muted">#{{ $evaluation->id }}</small>
                                    </td>
                                    <td>{{ $evaluation->period?->name ?? 'Sin periodo' }}</td>
                                    <td>{{ $evaluation->evaluation_date ? \Illuminate\Support\Carbon::parse($evaluation->evaluation_date)->format('d/m/Y') : 'Sin fecha' }}</td>
                                    <td>{{ $evaluation->user_id == auth()->id() ? ($evaluation->evaluator_id == auth()->id() ? 'Evaluado y evaluador' : 'Colaborador evaluado') : 'Evaluador' }}</td>
                                    <td>{{ $evaluation->user?->full_name ?? 'Sin colaborador' }}</td>
                                    <td>{{ $evaluation->evaluator?->full_name ?? 'Sin evaluador' }}</td>
                                    <td><span class="badge {{ $evaluation->status === 'completed' ? 'bg-success' : ($evaluation->status === 'cancelled' ? 'bg-secondary' : 'bg-warning text-dark') }}">{{ $evaluation->publication_label }}</span></td>
                                    <td class="text-end">
                                        @php($canRespond = $evaluation->user_id == auth()->id() && in_array($evaluation->status, ['draft', 'in_progress']))
                                        <a href="{{ route('mis-evaluaciones.show', $evaluation->id) }}"
                                           class="btn btn-sm {{ $canRespond ? 'btn-primary' : 'btn-outline-secondary' }} text-nowrap"
                                           aria-label="{{ $canRespond ? 'Responder' : 'Consultar' }} evaluación #{{ $evaluation->id }}">
                                            <i class="bi {{ $canRespond ? 'bi-pencil-square' : 'bi-eye' }} me-1" aria-hidden="true"></i>
                                            {{ $canRespond ? 'Responder' : 'Consultar' }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $evaluations->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
