@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="dashboard-header">
        <h1>{{ $personal ? 'Mi historial de desempeño' : 'Historial e indicadores de desempeño' }}</h1>
        <p>Consulta las evaluaciones anteriores y compara resultados publicados entre periodos.</p>
    </div>
    <a class="btn btn-outline-secondary mb-4" href="{{ route($personal ? 'mis-evaluaciones.index' : 'reportes.index') }}"><i class="bi bi-arrow-left" aria-hidden="true"></i> {{ $personal ? 'Volver a mis evaluaciones' : 'Volver a reportes' }}</a>
    <div class="card border-0 shadow-sm mb-4"><div class="card-body">
        <form method="GET" action="{{ route($personal ? 'mis-evaluaciones.history' : 'reportes.history') }}" class="row g-3 align-items-end">
            @unless($personal)
                <div class="col-md-4"><label for="history-user" class="form-label">Colaborador</label>
                    <select class="form-select" id="history-user" name="user_id" required>
                        <option value="">Selecciona un colaborador</option>
                        @foreach($users as $user)<option value="{{ $user->id }}" @selected($employee?->id == $user->id)>{{ $user->full_name }}{{ $user->status !== 'active' ? ' (inactivo)' : '' }}</option>@endforeach
                    </select>
                </div>
            @endunless
            <div class="col-md-4"><label for="history-template" class="form-label">Plantilla</label>
                <select class="form-select" id="history-template" name="template_id"><option value="">Todas las plantillas</option>@foreach($templates as $template)<option value="{{ $template->id }}" @selected(($filters['template_id'] ?? '') == $template->id)>{{ $template->name }}</option>@endforeach</select>
            </div>
            <div class="col-md-4"><label for="history-period" class="form-label">Periodo</label>
                <select class="form-select" id="history-period" name="period_id"><option value="">Todos los periodos</option>@foreach($periods as $period)<option value="{{ $period->id }}" @selected(($filters['period_id'] ?? '') == $period->id)>{{ $period->name }}</option>@endforeach</select>
            </div>
            <div class="col-md-4"><label for="history-type" class="form-label">Tipo de evaluación</label>
                <select class="form-select" id="history-type" name="evaluation_type_id"><option value="">Todos los tipos</option>@foreach($types as $type)<option value="{{ $type->id }}" @selected(($filters['evaluation_type_id'] ?? '') == $type->id)>{{ $type->name }}</option>@endforeach</select>
            </div>
            <div class="col-md-8 d-flex gap-2 flex-wrap">
                <button class="btn btn-primary" type="submit">Consultar historial</button>
                <a class="btn btn-outline-secondary" href="{{ route($personal ? 'mis-evaluaciones.history' : 'reportes.history', $personal ? [] : ['user_id' => $employee?->id]) }}">Limpiar filtros</a>
            </div>
        </form>
        <p class="small text-muted mt-3 mb-0">Primero consulta al colaborador; después elige una plantilla para comparar. Deja todos los periodos para observar la evolución.</p>
    </div></div>
    @if(!$employee)
        <div class="card border-0 shadow-sm"><div class="card-body text-center py-5"><i class="bi bi-person-lines-fill fs-1 text-primary" aria-hidden="true"></i><h2 class="h5 mt-3">Selecciona un colaborador para comenzar</h2><p class="text-muted mb-0">También puedes consultar el historial de cuentas inactivas.</p></div></div>
    @else
        <h2 class="h5 mb-3">{{ $employee->full_name }}</h2>
        <div class="row g-3 mb-4">
            @php
                $latest = $indicators['latest']; $previous = $indicators['previous']; $delta = $indicators['delta'];
                $cards = [
                    ['Resultados publicados', $indicators['count'], 'Con los filtros actuales'],
                    ['Último resultado', $latest ? number_format($latest->total_score, 2) : '—', $latest?->period?->name ?? 'Selecciona una plantilla'],
                    ['Resultado anterior', $previous ? number_format($previous->total_score, 2) : '—', $previous?->period?->name ?? 'Sin periodo anterior'],
                    ['Diferencia en puntos', $delta !== null ? ($delta > 0 ? '+' : '').number_format($delta, 2) : '—', $delta !== null ? ($delta > 0 ? 'Aumento' : ($delta < 0 ? 'Disminución' : 'Sin cambio')) : 'Sin comparación verificable'],
                ];
            @endphp
            @foreach($cards as [$label, $value, $description])
                <div class="col-sm-6 col-xl-3"><div class="card stats-card border-0 h-100"><div class="card-body"><span class="stats-label">{{ $label }}</span><h2>{{ $value }}</h2><small class="text-muted">{{ $description }}</small></div></div></div>
            @endforeach
        </div>
        <div class="card border-0 shadow-sm mb-4"><div class="card-body">
            <h2 class="h5">Evolución entre periodos</h2>
            <p class="{{ $delta === null ? 'text-muted' : '' }}">{{ $indicators['message'] }}</p>
            @if($indicators['series']->count() >= 2)
                @include('evaluaciones.history-chart', ['series' => $indicators['series']->take(-12)->values()])
            @endif
            <p class="small text-muted mb-0">Solo se consideran evaluaciones completadas y publicadas. Se ordenan por las fechas del periodo; si hay varias en un periodo, se toma la última por fecha de evaluación e ID. Una reapertura retira el resultado hasta que vuelva a publicarse. La gráfica muestra hasta 12 periodos consecutivos compatibles con el último resultado.</p>
        </div></div>
        <div class="card border-0 table-card"><div class="card-body">
            <h2 class="h5 mb-3">Evaluaciones registradas</h2>
            @if($evaluations->isEmpty())
                <div class="text-center py-4 text-muted">No hay evaluaciones con estos filtros.</div>
            @else
                <div class="table-responsive"><table class="table align-middle">
                    <thead><tr><th>ID / tipo</th><th>Plantilla</th><th>Periodo / fecha</th><th>Evaluador</th><th>Estado</th><th>Resultado</th><th>Detalle</th></tr></thead>
                    <tbody>@foreach($evaluations as $evaluation)
                        <tr>
                            <td>#{{ $evaluation->id }}<small class="d-block">{{ $evaluation->evaluationType?->name ?? 'Sin tipo' }}</small></td>
                            <td>{{ $evaluation->template?->name ?? 'Plantilla no disponible' }}</td>
                            <td>{{ $evaluation->period?->name ?? 'Sin periodo' }}<small class="d-block text-muted">{{ $evaluation->evaluation_date ? \Carbon\Carbon::parse($evaluation->evaluation_date)->format('d/m/Y') : 'Sin fecha' }}</small></td>
                            <td>{{ $evaluation->evaluator?->full_name ?? 'Sin evaluador' }}</td>
                            <td><span class="badge {{ $evaluation->status === 'completed' && $evaluation->published_at ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $evaluation->publication_label }}</span></td>
                            <td>
                                @if($evaluation->status === 'completed' && (!$personal || $evaluation->published_at))
                                    {{ number_format($evaluation->total_score, 2) }}
                                    @if(!$evaluation->comparison_snapshot)<small class="d-block text-muted">Sin referencia para comparar</small>@endif
                                @else <span class="text-muted">{{ $evaluation->status === 'completed' ? 'Pendiente de publicación' : '—' }}</span> @endif
                            </td>
                            <td><a class="btn btn-outline-primary btn-sm" href="{{ route($personal ? 'mis-evaluaciones.show' : 'reportes.history.show', $evaluation->id) }}" aria-label="Consultar evaluación {{ $evaluation->id }}"><i class="bi bi-eye" aria-hidden="true"></i> Consultar</a></td>
                        </tr>
                    @endforeach</tbody>
                </table></div>
                {{ $evaluations->links() }}
            @endif
        </div></div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.getElementById('history-user')?.addEventListener('change', () => {
    ['history-template', 'history-period', 'history-type'].forEach(id => {
        document.getElementById(id).value = '';
    });
});
</script>
@endpush
