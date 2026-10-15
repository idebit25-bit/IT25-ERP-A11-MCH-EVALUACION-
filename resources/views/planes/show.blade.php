@extends('layouts.app')
@section('content')
<div class="content-wrapper improvement-detail">
    <a class="btn btn-outline-secondary mb-4" href="{{ route('planes.index') }}">Volver a planes</a>
    <div class="dashboard-header"><h1>{{ $plan->title }}</h1><p>Plan #{{ $plan->id }} · {{ $plan->user?->full_name ?? 'Cuenta no disponible' }} · Evaluación #{{ $plan->evaluation_id }}</p></div>
    <div class="card border-0 mb-4 plan-summary">
    <div class="plan-section-heading"><h2 class="h5 mb-0">Resumen del plan</h2></div>
    <div class="row g-0 plan-overview">
        <div class="col-md-4"><div class="card border-0 h-100"><div class="card-body d-flex gap-3 align-items-center"><span class="plan-icon"><i class="bi bi-clipboard-check" aria-hidden="true"></i></span><div><span class="stats-label">Estado del plan</span><h2 class="plan-status-value">{{ $plan->status_label }}</h2></div></div></div></div>
        <div class="col-md-4"><div class="card border-0 h-100"><div class="card-body d-flex gap-3 align-items-center"><span class="plan-icon"><i class="bi bi-graph-up" aria-hidden="true"></i></span><div class="flex-grow-1"><span class="stats-label">Avance reportado</span><h2>{{ number_format($plan->actions->avg('progress') ?? 0, 0) }} <small>%</small></h2><div class="progress plan-progress" role="progressbar" aria-label="Avance reportado del plan" aria-valuenow="{{ round($plan->actions->avg('progress') ?? 0) }}" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: {{ round($plan->actions->avg('progress') ?? 0) }}%"></div></div></div></div></div></div>
        <div class="col-md-4"><div class="card border-0 h-100"><div class="card-body d-flex gap-3 align-items-center"><span class="plan-icon"><i class="bi bi-list-check" aria-hidden="true"></i></span><div><span class="stats-label">Acciones al 100 %</span><h2>{{ $plan->actions->where('progress', 100)->count() }} <small>/ {{ $plan->actions->count() }}</small></h2></div></div></div></div>
    </div>
    <p class="small text-muted plan-overview-help">El avance es el promedio de las acciones. El cierre requiere confirmación administrativa.</p>
    </div>
    @if(!$plan->evaluation || $plan->evaluation->status !== 'completed' || !$plan->evaluation->published_at)<div class="alert alert-warning">La evaluación de origen ya no está publicada. El plan conserva sus acciones y seguimiento; el administrador debe revisar si corresponde ajustarlo o cancelarlo.</div>@endif
    <div class="row g-4 align-items-start">
    <aside class="col-xl-4">
    <div class="card border-0 shadow-sm mb-4 plan-objective"><div class="card-body">
        <h2 class="h5"><i class="bi bi-bullseye text-primary me-2" aria-hidden="true"></i>Objetivo</h2><p class="text-break plan-objective-text" style="white-space: pre-wrap">{{ $plan->objective }}</p>
        @if($manager)<div class="plan-source mb-3"><span class="small text-muted">Resultado de origen</span><strong class="d-block fs-5">{{ number_format($plan->source_result['total_score'] ?? 0, 2) }}</strong><small class="text-muted">Referencia conservada al crear el plan.</small></div>@endif
        @if($manager || auth()->id() == $plan->user_id)<a class="btn btn-outline-primary btn-sm" href="{{ route('mis-evaluaciones.show', $plan->evaluation_id) }}">Consultar evaluación de origen</a>@endif
        @if($manager && $plan->status === 'active')
            <details class="mt-3" @if(old('_form') === 'objective') open @endif><summary>Editar nombre u objetivo</summary><form class="mt-3" method="POST" action="{{ route('planes.update', $plan->id) }}">@csrf @method('PUT')<input type="hidden" name="version" value="{{ $plan->version }}"><input type="hidden" name="_form" value="objective">
                <label class="form-label" for="edit-title">Nombre</label><input class="form-control mb-3" id="edit-title" name="title" maxlength="180" required value="{{ old('_form') === 'objective' ? old('title') : $plan->title }}">
                <label class="form-label" for="edit-objective">Objetivo</label><textarea class="form-control mb-3" id="edit-objective" name="objective" maxlength="3000" required rows="3">{{ old('_form') === 'objective' ? old('objective') : $plan->objective }}</textarea>
                <label class="form-label" for="objective-note">Motivo del cambio</label><textarea class="form-control mb-3" id="objective-note" name="note" required maxlength="2000">{{ old('_form') === 'objective' ? old('note') : '' }}</textarea><button class="btn btn-primary">Guardar objetivo</button>
            </form></details>
        @endif
    </div></div>
    @if($manager)
        <details class="card border-0 shadow-sm mb-4 plan-management" @if(old('_form') === 'transition') open @endif><summary class="p-3 fw-semibold">Administrar estado del plan</summary><div class="card-body border-top"><h2 class="h5">{{ $plan->status === 'active' ? 'Cierre administrativo' : 'Reabrir el plan' }}</h2>
            <p class="text-muted">El cierre confirma que se revisó el cumplimiento de todas las acciones. Cancelar o reabrir conserva el historial.</p>
            <form method="POST" action="{{ route('planes.transition', $plan->id) }}" onsubmit="return confirm('¿Confirmas el cambio de estado del plan?');">@csrf @method('PATCH')<input type="hidden" name="version" value="{{ $plan->version }}"><input type="hidden" name="_form" value="transition">
                <label class="form-label" for="next-state">Acción administrativa</label><select class="form-select mb-3" id="next-state" name="status" required><option value="">Selecciona una acción</option>@if($plan->status === 'active')<option value="completed" @disabled($plan->actions->contains(fn ($item) => $item->progress < 100))>Cerrar: requiere todas las acciones al 100 %</option><option value="cancelled">Cancelar plan</option>@else<option value="active">Reabrir para seguimiento</option>@endif</select>
                <label class="form-label" for="state-note">Conclusión o motivo</label><textarea class="form-control mb-3" id="state-note" name="note" rows="3" minlength="10" maxlength="2000" required>{{ old('_form') === 'transition' ? old('note') : '' }}</textarea><button class="btn btn-outline-primary">Confirmar cambio de estado</button>
            </form>
        </div></details>
    @endif
    </aside>
    <section class="col-xl-8" aria-labelledby="plan-actions-title">
    <div class="card border-0 mb-4 plan-actions-panel">
    <div class="plan-section-heading d-flex align-items-center justify-content-between"><h2 class="h5 mb-0" id="plan-actions-title">Acciones y responsables</h2><span class="badge text-bg-light border">{{ $plan->actions->count() }}</span></div>
    <div class="card-body">
    @foreach($plan->actions as $action)
        <details class="card border-0 shadow-sm mb-3 plan-action" @if(in_array(old('_form'), ['progress-'.$action->id, 'action-'.$action->id])) open @endif>
            <summary class="p-3">
                <span class="plan-action-heading"><span><span class="plan-action-number">Acción #{{ $action->id }}</span><span class="fw-semibold text-break d-block">{{ \Illuminate\Support\Str::limit($action->description, 160) }}</span></span><i class="bi bi-chevron-down plan-action-chevron" aria-hidden="true"></i></span>
                <span class="plan-action-meta">
                    <span><span class="plan-meta-label">Responsable</span><span class="d-block"><i class="bi bi-person me-1" aria-hidden="true"></i>{{ $action->responsible?->full_name ?? 'Cuenta no disponible' }}</span>@if($action->responsible?->status !== 'active')<span class="badge text-bg-warning mt-1">Requiere reasignación</span>@endif</span>
                    <span><span class="plan-meta-label">Fecha compromiso</span><span class="d-block"><i class="bi bi-calendar3 me-1" aria-hidden="true"></i>{{ $action->due_date->format('d/m/Y') }}</span></span>
                    <span><span class="plan-meta-label">Avance</span><span class="badge {{ $action->progress === 100 ? 'text-bg-success' : ($plan->status === 'active' && $action->overdue ? 'text-bg-danger' : 'bg-primary-subtle text-primary-emphasis') }}">{{ $action->progress }} %{{ $plan->status === 'active' && $action->overdue ? ' · Vencida' : '' }}</span></span>
                </span>
                <span class="small text-primary d-block mt-3">Detalle y seguimiento <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i></span>
            </summary>
            <div class="card-body border-top">
            <div class="d-flex justify-content-between gap-3 flex-wrap"><h3 class="h6">Acción #{{ $action->id }}</h3><span class="badge {{ $action->progress === 100 ? 'text-bg-success' : ($plan->status === 'active' && $action->overdue ? 'text-bg-danger' : 'text-bg-secondary') }}">{{ $action->progress === 100 ? '100 % reportado' : ($plan->status === 'active' && $action->overdue ? 'Vencida' : ($action->progress > 0 ? 'En proceso' : 'Pendiente')) }}</span></div>
            <p class="text-break" style="white-space: pre-wrap">{{ $action->description }}</p>
            <p class="mb-2"><strong>Responsable:</strong> {{ $action->responsible?->full_name ?? 'Cuenta no disponible' }} @if($action->responsible?->status !== 'active')<span class="badge text-bg-warning">Requiere reasignación</span>@endif · <strong>Fecha compromiso:</strong> {{ $action->due_date->format('d/m/Y') }}</p>
            <div class="progress mb-2" role="progressbar" aria-label="Avance de acción {{ $action->id }}" aria-valuenow="{{ $action->progress }}" aria-valuemin="0" aria-valuemax="100"><div class="progress-bar" style="width: {{ $action->progress }}%"></div></div><p class="small text-muted">{{ $action->progress }} % reportado</p>
            @if($plan->status === 'active' && ($manager || auth()->id() == $action->responsible_id))
                <details @if(old('_form') === 'progress-'.$action->id) open @endif><summary>Registrar avance o comentario</summary>
                    <form class="mt-3" method="POST" action="{{ route('planes.progress', [$plan->id, $action->id]) }}">@csrf<input type="hidden" name="version" value="{{ $action->version }}"><input type="hidden" name="_form" value="progress-{{ $action->id }}">
                        <label class="form-label" for="progress-{{ $action->id }}">Porcentaje de avance</label><input class="form-control mb-3" type="number" id="progress-{{ $action->id }}" name="progress" min="0" max="100" step="1" value="{{ old('_form') === 'progress-'.$action->id ? old('progress') : $action->progress }}" required>
                        <label class="form-label" for="progress-note-{{ $action->id }}">Qué se realizó, evidencia descrita o motivo de corrección</label><textarea class="form-control mb-3" id="progress-note-{{ $action->id }}" name="note" rows="3" required maxlength="2000">{{ old('_form') === 'progress-'.$action->id ? old('note') : '' }}</textarea><button class="btn btn-primary">Guardar avance</button>
                    </form>
                </details>
            @endif
            @if($manager && $plan->status === 'active')
                <details class="mt-3" @if(old('_form') === 'action-'.$action->id) open @endif><summary>Editar acción, responsable o fecha</summary><form class="mt-3" method="POST" action="{{ route('planes.actions.update', [$plan->id, $action->id]) }}">@csrf @method('PUT')<input type="hidden" name="version" value="{{ $action->version }}">
                    @include('planes._action-fields', ['formKey' => 'action-'.$action->id])
                    <label class="form-label" for="action-note-{{ $action->id }}">Motivo del cambio</label><textarea class="form-control mb-3" id="action-note-{{ $action->id }}" name="note" required maxlength="2000">{{ old('_form') === 'action-'.$action->id ? old('note') : '' }}</textarea><button class="btn btn-primary">Guardar acción</button>
                </form></details>
            @endif
        </div></details>
    @endforeach
    @if($manager && $plan->status === 'active')
        <details class="plan-add-action p-3" @if(old('_form') === 'add') open @endif><summary class="fw-semibold text-primary"><i class="bi bi-plus-circle me-2" aria-hidden="true"></i>Agregar otra acción</summary><form class="mt-3" method="POST" action="{{ route('planes.actions.store', $plan->id) }}">@csrf<input type="hidden" name="version" value="{{ $plan->version }}">
            @include('planes._action-fields', ['action' => null, 'formKey' => 'add'])<button class="btn btn-primary">Agregar acción</button>
        </form></details>
    @endif
    </div></div>
    <section class="card border-0 shadow-sm mb-4" id="plan-history" aria-labelledby="plan-history-title"><div class="plan-section-heading"><h2 class="h5 mb-0" id="plan-history-title">Historial de seguimiento <span class="badge text-bg-light border ms-2">{{ $updates->total() }}</span></h2><span class="d-block small text-muted fw-normal mt-2">Consulta los movimientos, comentarios y responsables de los cambios.</span></div><div class="card-body plan-history-body">
        @foreach($updates as $update)<div class="border-bottom py-3"><div class="d-flex justify-content-between gap-2 flex-wrap"><strong>{{ $update->event }}{{ $update->action_id ? ' · Acción #'.$update->action_id : '' }}</strong><small class="text-muted">{{ $update->created_at->format('d/m/Y H:i') }}</small></div><small>{{ $update->user?->full_name ?? 'Cuenta no disponible' }}</small><p class="text-break mt-2 mb-1" style="white-space: pre-wrap">{{ $update->note }}</p>
            @if($update->event === 'Avance registrado')<small class="text-muted">Avance: {{ $update->changes['antes'] }} % → {{ $update->changes['despues'] }} %</small>@endif
            @if(in_array($update->event, ['Acción actualizada', 'Objetivo actualizado']))
                <details class="small mt-2"><summary>Consultar datos anteriores</summary>@foreach($update->changes['antes'] ?? [] as $field => $value)<p class="mb-1"><strong>{{ ['description' => 'Acción', 'responsible_id' => 'ID del responsable', 'due_date' => 'Fecha compromiso', 'title' => 'Nombre', 'objective' => 'Objetivo'][$field] ?? $field }}:</strong> {{ $value }}</p>@endforeach</details>
            @endif
        </div>@endforeach
        <div class="mt-3">{{ $updates->links() }}</div>
    </div></section>
    </section>
    </div>
</div>
@endsection
