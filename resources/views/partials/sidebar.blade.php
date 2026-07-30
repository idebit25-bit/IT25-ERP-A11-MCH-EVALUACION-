<!-- Sidebar -->

<div class="sidebar sidebar-hidden">

    <!-- Logo sistema -->

    <div class="sidebar-logo">

        <h2>
            I-DEB
        </h2>

        <p>
            Capital Humano
        </p>

        <small>
            v1.0
        </small>

    </div>

    <!-- Menú -->

    <ul>

<li>

    <a
        href="{{ url('/dashboard') }}"
        class="{{ request()->is('dashboard') ? 'active' : '' }}"
    >

        <i class="bi bi-grid"></i>

        Dashboard

    </a>

</li>

        <li>

            <a href="{{ url('/evaluaciones') }}"
                class="{{ request()->is('evaluaciones') ? 'active' : '' }}"
            >
                <i class="bi bi-clipboard-check"></i>

                Evaluaciones

            </a>

        </li>

        <li>

            <a href="{{ url('/documentos') }}"
                class="{{ request()->is('documentos') ? 'active' : '' }}"
            >
                <i class="bi bi-folder"></i>

                Documentos

            </a>

        </li>

        <li>

            <a href="{{ url('/colaboradores') }}"
                class="{{ request()->is('colaboradores') ? 'active' : '' }}"
            >

                <i class="bi bi-people"></i>

                Colaboradores

            </a>

        </li>

        <li>

            <a href="{{ url('/reportes') }}"
                class="{{ request()->is('reportes') ? 'active' : '' }}"
            >

                <i class="bi bi-bar-chart"></i>

                Reportes

            </a>

        </li>

        <li>

            <a href="{{ url('/configuracion') }}"
                class="{{ request()->is('configuracion') ? 'active' : '' }}"
            >

                <i class="bi bi-gear"></i>

                Configuración

            </a>

        </li>

    </ul>

</div>