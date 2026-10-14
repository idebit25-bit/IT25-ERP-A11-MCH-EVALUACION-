@extends('layouts.app')
@section('content')
<div class="content-wrapper improvement-detail">
    <a class="btn btn-outline-secondary mb-4" href="{{ route('planes.index') }}">Volver a planes</a>
    <div class="dashboard-header"><h1>{{ $plan->title }}</h1><p>Plan #{{ $plan->id }} · {{ $plan->user?->full_name ?? 'Cuenta no disponible' }} · Evaluación #{{ $plan->evaluation_id }}</p></div>
    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="card stats-card border-0 h-100"><div class="card-body"><span class="stats-label">Estado</span><h2 class="h4 mt-2">{{ $plan->status_label }}</h2></div></div></div>
        <div class="col-md-4"><div class="card stats-card border-0 h-100"><div class="card-body"><span class="stats-label">Avance reportado</span><h2>{{ number_format($plan->actions->avg('progress') ?? 0, 0) }} %</h2><small class="text-muted">Promedio de las acciones; el cierre requiere confirmación administrativa.</small></div></div></div>
        <div class="col-md-4"><div class="card stats-card border-0 h-100"><div class="card-body"><span class="stats-label">Acciones al 100 %</span><h2>{{ $plan->actions->where('progress', 100)->count() }} / {{ $plan->actions->count() }}</h2></div></div></div>
    </div>
    @if(!$plan->evaluation || $plan->evaluation->status !== 'completed' || !$plan->evaluation->published_at)<div class="alert alert-warning">La evaluación de origen ya no está publicada. El plan conserva sus acciones y seguimiento; el administrador debe revisar si corresponde ajustarlo o cancelarlo.</div>@endif
    <div class="row g-4 align-items-start">
    <aside class="col-xl-4">
    <div class="card border-0 shadow-sm mb-4"><div class="card-body">
        <h2 class="h5">Objetivo</h2><p class="text-break" style="white-space: pre-wrap">{{ $plan->objective }}</p>
        @if($manager)<p class="small text-muted">Resultado al crear el plan: {{ number_format($plan->source_result['total_score'] ?? 0, 2) }}. Esta referencia no cambia si la evaluación se reabre.</p>@endif
        @if($manager || auth()->id() == $plan->user_id)<a class="btn btn-outline-primary btn-sm" href="{{ route('mis-evaluaciones.show', $plan->evaluation_id) }}">Consultar evaluación de origen</a>@endif
        @if($manager && $plan->status === 'active')
            <details class="mt-3" @if(old('_form') === 'objective') open @endif><summary>Editar nombre u objetivo</summary><form class="mt-3" method="POST" action="{{ route('planes.update', $plan->id) }}">@csrf @method('PUT')<input type="hidden" name="version" value="{{ $plan->version }}"><input type="hidden" name="_form" value="objective">
                <label class="form-label" for="edit-title">Nombre</label><input class="form-control mb-3" id="edit-title" name="title" maxlength="180" required value="{{ old('_form') === 'objective' ? old('title') : $plan->title }}">
                <label class="form-label" for="edit-objective">Objetivo</label><textarea class="form-control mb-3" id="edit-objective" name="objective" maxlength="3000" required rows="3">{{ old('_form') === 'objective' ? old('objective') : $plan->objective }}</textarea>
                <label class="form-label" for="objective-note">Motivo del cambio</label><textarea class="form-control mb-3" id="objective-note" name="note" required maxlength="2000">{{ old('_form') === 'objective' ? old('note') : '' }}</textarea><button class="btn btn-primary">Guardar objetivo</button>
            </form></details>
        @endif
    </div></div>
    </aside>
    <section class="col-xl-8" aria-labelledby="plan-actions-title">
    <h2 class="h5 mb-3" id="plan-actions-title">Acciones y responsables</h2>
    @foreach($plan->actions as $action)
        <details class="card border-0 shadow-sm mb-3 plan-action" @if(in_array(old('_form'), ['progress-'.$action->id, 'action-'.$action->id])) open @endif>
            <summary class="p-3">
                <span class="plan-action-heading"><span class="fw-semibold text-break">{{ \Illuminate\Support\Str::limit($action->description, 110) }}</span><i class="bi bi-chevron-down plan-action-chevron" aria-hidden="true"></i></span>
                <span class="d-flex flex-wrap gap-2 mt-2 small text-muted">
                    <span><i class="bi bi-person" aria-hidden="true"></i> {{ $action->responsible?->full_name ?? 'Cuenta no disponible' }}</span>
                    @if($action->responsible?->status !== 'active')<span class="badge text-bg-warning">Requiere reasignación</span>@endif
                    <span><i class="bi bi-calendar3" aria-hidden="true"></i> {{ $action->due_date->format('d/m/Y') }}</span>
                    <span class="badge {{ $action->progress === 100 ? 'text-bg-success' : ($plan->status === 'active' && $action->overdue ? 'text-bg-danger' : 'text-bg-light border') }}">{{ $action->progress }} %{{ $plan->status === 'active' && $action->overdue ? ' - Vencida' : '' }}</span>
                </span>
                <span class="small text-primary d-block mt-2">Ver detalle y seguimiento</span>
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
        <details class="card border-0 shadow-sm p-3 mb-4" @if(old('_form') === 'add') open @endif><summary class="fw-semibold">Agregar otra acción</summary><form class="mt-3" method="POST" action="{{ route('planes.actions.store', $plan->id) }}">@csrf<input type="hidden" name="version" value="{{ $plan->version }}">
            @include('planes._action-fields', ['action' => null, 'formKey' => 'add'])<button class="btn btn-primary">Agregar acción</button>
        </form></details>
    @endif
    @if($manager)
        <details class="card border-0 shadow-sm mb-4 plan-management" @if(old('_form') === 'transition') open @endif><summary class="p-3 fw-semibold">Administrar estado del plan</summary><div class="card-body border-top"><h2 class="h5">{{ $plan->status === 'active' ? 'Cierre administrativo' : 'Reabrir el plan' }}</h2>
            <p class="text-muted">El cierre confirma que se revisó el cumplimiento de todas las acciones. Cancelar o reabrir conserva el historial.</p>
            <form method="POST" action="{{ route('planes.transition', $plan->id) }}" onsubmit="return confirm('¿Confirmas el cambio de estado del plan?');">@csrf @method('PATCH')<input type="hidden" name="version" value="{{ $plan->version }}"><input type="hidden" name="_form" value="transition">
                <label class="form-label" for="next-state">Acción administrativa</label><select class="form-select mb-3" id="next-state" name="status" required><option value="">Selecciona una acción</option>@if($plan->status === 'active')<option value="completed" @disabled($plan->actions->contains(fn ($item) => $item->progress < 100))>Cerrar: requiere todas las acciones al 100 %</option><option value="cancelled">Cancelar plan</option>@else<option value="active">Reabrir para seguimiento</option>@endif</select>
                <label class="form-label" for="state-note">Conclusión o motivo</label><textarea class="form-control mb-3" id="state-note" name="note" rows="3" minlength="10" maxlength="2000" required>{{ old('_form') === 'transition' ? old('note') : '' }}</textarea><button class="btn btn-outline-primary">Confirmar cambio de estado</button>
            </form>
        </div></details>
    @endif
    </section>
    </div>
    <details class="card border-0 shadow-sm mt-4" id="plan-history" @if(request('page')) open @endif><summary class="p-3 fw-semibold">Historial de seguimiento <span class="badge text-bg-light border ms-2">{{ $updates->total() }}</span><span class="d-block small text-muted fw-normal mt-1">Consulta los movimientos, comentarios y responsables de los cambios.</span></summary><div class="card-body border-top">
        @foreach($updates as $update)<div class="border-bottom py-3"><div class="d-flex justify-content-between gap-2 flex-wrap"><strong>{{ $update->event }}{{ $update->action_id ? ' · Acción #'.$update->action_id : '' }}</strong><small class="text-muted">{{ $update->created_at->format('d/m/Y H:i') }}</small></div><small>{{ $update->user?->full_name ?? 'Cuenta no disponible' }}</small><p class="text-break mt-2 mb-1" style="white-space: pre-wrap">{{ $update->note }}</p>
            @if($update->event === 'Avance registrado')<small class="text-muted">Avance: {{ $update->changes['antes'] }} % → {{ $update->changes['despues'] }} %</small>@endif
            @if(in_array($update->event, ['Acción actualizada', 'Objetivo actualizado']))
                <details class="small mt-2"><summary>Consultar datos anteriores</summary>@foreach($update->changes['antes'] ?? [] as $field => $value)<p class="mb-1"><strong>{{ ['description' => 'Acción', 'responsible_id' => 'ID del responsable', 'due_date' => 'Fecha compromiso', 'title' => 'Nombre', 'objective' => 'Objetivo'][$field] ?? $field }}:</strong> {{ $value }}</p>@endforeach</details>
            @endif
        </div>@endforeach
        <div class="mt-3">{{ $updates->links() }}</div>
    </div></details>
</div>
@endsection
