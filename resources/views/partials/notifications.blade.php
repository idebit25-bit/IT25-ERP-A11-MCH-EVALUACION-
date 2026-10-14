@php
    $unreadCount = auth()->user()->unreadNotifications()->count();
    $recentNotifications = auth()->user()->notifications()->limit(5)->get();
@endphp
<div class="dropdown">
    <button class="btn btn-link text-white position-relative" type="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notificaciones: {{ $unreadCount }} sin leer">
        <i class="bi bi-bell fs-5"></i>
        @if($unreadCount)
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-count">{{ $unreadCount > 99 ? '99+' : $unreadCount }}</span>
        @endif
    </button>
    <div class="dropdown-menu dropdown-menu-end notification-menu p-3">
        <h6>Notificaciones</h6>
        @forelse($recentNotifications as $notification)
            <div class="border-bottom py-2 {{ $notification->read_at ? '' : 'fw-semibold' }}">
                <p class="mb-1 small">{{ $notification->data['message'] ?? 'Aviso del sistema' }}</p>
                <small class="text-muted">{{ $notification->created_at->format('d/m/Y H:i') }}</small>
                @if(isset($notification->data['plan_id']))
                    <a class="d-block small" href="{{ route('planes.show', $notification->data['plan_id']) }}">Consultar plan de mejora</a>
                @elseif(isset($notification->data['evaluation_id']))
                    <a class="d-block small" href="{{ route('mis-evaluaciones.show', $notification->data['evaluation_id']) }}">Consultar evaluación</a>
                @endif
                @unless($notification->read_at)
                    <form method="POST" action="{{ route('notificaciones.read', $notification->id) }}">
                        @csrf @method('PATCH')
                        <button class="btn btn-link btn-sm p-0" type="submit">Marcar como leída</button>
                    </form>
                @endunless
            </div>
        @empty
            <p class="small text-muted">No tienes notificaciones.</p>
        @endforelse
        <a class="btn btn-outline-secondary btn-sm w-100 mt-3" href="{{ route('notificaciones.index') }}">Ver todas</a>
    </div>
</div>
