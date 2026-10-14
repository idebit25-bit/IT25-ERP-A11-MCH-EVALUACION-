@extends('layouts.app')
@section('content')
<div class="content-wrapper">
    <div class="dashboard-header"><h1>Planes de mejora</h1><p>{{ auth()->user()->hasModulePermission('evaluaciones.gestionar') ? 'Administra objetivos, acciones y seguimiento de los colaboradores.' : 'Consulta tus planes y registra avances de las acciones a tu cargo.' }}</p></div>
    @if(auth()->user()->hasModulePermission('evaluaciones.gestionar'))<a class="btn btn-primary mb-4" href="{{ route('planes.create') }}"><i class="bi bi-plus-lg"></i> Nuevo plan</a>@endif
    <div class="card border-0 shadow-sm"><div class="card-body">
        <form method="GET" class="row g-3 align-items-end mb-4" action="{{ route('planes.index') }}">
            @if(!empty($filters['evaluation_id']))<input type="hidden" name="evaluation_id" value="{{ $filters['evaluation_id'] }}">@endif
            <div class="col-md-5"><label class="form-label" for="plan-search">Buscar por nombre del plan</label><input class="form-control" name="search" id="plan-search" maxlength="100" value="{{ $filters['search'] ?? '' }}"></div>
            <div class="col-md-4"><label class="form-label" for="plan-status">Estado</label><select class="form-select" name="status" id="plan-status">@foreach(['' => 'Todos', 'active' => 'En seguimiento', 'overdue' => 'Con acciones vencidas', 'completed' => 'Cerrados', 'cancelled' => 'Cancelados'] as $value => $label)<option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>@endforeach</select></div>
            <div class="col-md-3 d-flex gap-2"><button class="btn btn-primary">Filtrar</button><a class="btn btn-outline-secondary" href="{{ route('planes.index') }}">Limpiar</a></div>
        </form>
        @if(!empty($filters['evaluation_id']))<p class="text-muted">Planes de la evaluación #{{ $filters['evaluation_id'] }}.</p>@endif
        @if($plans->isEmpty())<div class="text-center py-5"><i class="bi bi-list-check fs-1 text-muted"></i><h2 class="h5 mt-3">No hay planes disponibles</h2><p class="text-muted mb-0">No hay registros con estos filtros o aún no participas en un plan.</p></div>
        @else
            <div class="table-responsive"><table class="table align-middle"><thead><tr><th>Plan</th><th>Colaborador</th><th>Estado</th><th>Avance reportado</th><th>Acciones</th><th>Detalle</th></tr></thead><tbody>
            @foreach($plans as $plan)<tr><td><strong>{{ $plan->title }}</strong><small class="d-block text-muted">#{{ $plan->id }} · Evaluación #{{ $plan->evaluation_id }}</small></td><td>{{ $plan->user?->full_name ?? 'Cuenta no disponible' }}</td><td><span class="badge {{ $plan->status === 'completed' ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $plan->status_label }}</span></td><td>{{ number_format($plan->actions_avg_progress ?? 0, 0) }} %</td><td>{{ $plan->actions_count }}</td><td><a class="btn btn-outline-primary btn-sm" href="{{ route('planes.show', $plan->id) }}">Consultar</a></td></tr>@endforeach
            </tbody></table></div>
            {{ $plans->links() }}
        @endif
    </div></div>
</div>
@endsection
