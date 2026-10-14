@php
    $recover = old('_form') === $formKey;
    $description = $recover ? old('description') : ($action?->description ?? '');
    $responsibleId = $recover ? old('responsible_id') : ($action?->responsible_id ?? '');
    $dueDate = $recover ? old('due_date') : ($action?->due_date?->toDateString() ?? '');
@endphp
<input type="hidden" name="_form" value="{{ $formKey }}">
<div class="mb-3"><label class="form-label" for="{{ $formKey }}-description">Acción y resultado esperado</label><textarea class="form-control" name="description" id="{{ $formKey }}-description" rows="3" maxlength="1000" required>{{ $description }}</textarea><div class="form-text">Describe una actividad concreta y cómo se comprobará su cumplimiento.</div></div>
<div class="row g-3 mb-3">
    <div class="col-md-7"><label class="form-label" for="{{ $formKey }}-responsible">Responsable</label><select class="form-select" id="{{ $formKey }}-responsible" name="responsible_id" required><option value="">Selecciona una cuenta activa</option>@foreach($users as $user)<option value="{{ $user->id }}" @selected($responsibleId == $user->id)>{{ $user->full_name }}</option>@endforeach</select></div>
    <div class="col-md-5"><label class="form-label" for="{{ $formKey }}-due">Fecha compromiso</label><input class="form-control" id="{{ $formKey }}-due" type="date" name="due_date" value="{{ $dueDate }}" required @if(!$action) min="{{ today()->toDateString() }}" @endif></div>
</div>
