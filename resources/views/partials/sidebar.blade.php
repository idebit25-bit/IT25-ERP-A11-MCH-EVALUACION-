<nav class="sidebar sidebar-hidden" aria-label="Menú principal">
    <div class="sidebar-logo">
        <h2>I-DEB</h2>
        <p>Capital Humano</p>
        <small>v2.0</small>
    </div>

    @if(auth()->user()->canManageOperations())
        <ul>
            <li><a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}"><i class="bi bi-grid"></i> Dashboard</a></li>
        </ul>
    @endif

    <p class="sidebar-section">General</p>
    <ul>
        <li><a href="{{ route('mis-evaluaciones.index') }}" class="{{ request()->routeIs('mis-evaluaciones.index') ? 'active' : '' }}"><i class="bi bi-clipboard-check"></i> Mis evaluaciones</a></li>
        <li><a href="{{ url('/documentos') }}" class="{{ request()->is('documentos', 'documentos/*') ? 'active' : '' }}"><i class="bi bi-folder"></i> Documentos</a></li>
        <li><a href="{{ route('planes.index') }}" class="{{ request()->routeIs('planes.*') ? 'active' : '' }}"><i class="bi bi-list-check"></i> Planes de mejora</a></li>
    </ul>

    @if(auth()->user()->hasModulePermission('colaboradores.gestionar') || auth()->user()->hasModulePermission('evaluaciones.gestionar') || auth()->user()->hasModulePermission('reportes.consultar'))
        <p class="sidebar-section">Gestión</p>
        <ul>
            @if(auth()->user()->hasModulePermission('colaboradores.gestionar'))
                <li><a href="{{ url('/colaboradores') }}" class="{{ request()->is('colaboradores', 'colaboradores/*') ? 'active' : '' }}"><i class="bi bi-people"></i> Colaboradores</a></li>
            @endif
            @if(auth()->user()->hasModulePermission('evaluaciones.gestionar'))
                <li><a href="{{ url('/evaluaciones') }}" class="{{ request()->is('evaluaciones', 'evaluaciones/*') ? 'active' : '' }}"><i class="bi bi-clipboard-check"></i> Evaluaciones</a></li>
            @endif
            @if(auth()->user()->hasModulePermission('reportes.consultar'))
                <li><a href="{{ url('/reportes') }}" class="{{ request()->is('reportes', 'reportes/*') ? 'active' : '' }}"><i class="bi bi-bar-chart"></i> Reportes</a></li>
            @endif
        </ul>
    @endif

    @if(auth()->user()->hasModulePermission('configuracion.evaluaciones') || auth()->user()->hasAccessRole('Super Admin'))
        <p class="sidebar-section">Administración</p>
        <ul>
            @if(auth()->user()->hasAccessRole('Super Admin'))
                <li><a href="{{ route('configuracion.roles') }}" class="{{ request()->routeIs('configuracion.roles') ? 'active' : '' }}"><i class="bi bi-shield-lock"></i> Usuarios y permisos</a></li>
            @endif
            @if(auth()->user()->hasModulePermission('configuracion.evaluaciones'))
                <li><a href="{{ url('/configuracion') }}" class="{{ request()->is('configuracion', 'configuracion/*') && !request()->routeIs('configuracion.roles') ? 'active' : '' }}"><i class="bi bi-gear"></i> Configuración</a></li>
            @endif
        </ul>
    @endif
</nav>
