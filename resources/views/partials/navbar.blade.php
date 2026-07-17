<nav class="navbar">

    <div class="navbar-left">

        <!-- Botón hamburguesa -->

        <button id="menu-toggle" class="menu-toggle">

            <i class="bi bi-list"></i>

        </button>

        <div class="navbar-title">

            <strong>I-DEB</strong>

            <span>
                | Capital Humano
            </span>

        </div>

    </div>

<div class="navbar-user dropdown">

    <div
        class="navbar-user-info"
        data-bs-toggle="dropdown"
        aria-expanded="false">

        <i class="bi bi-person-circle"></i>

        <span>

            {{ auth()->user()?->first_name }}
            {{ auth()->user()?->paternal_surname }}

        </span>

        <i class="bi bi-chevron-down"></i>

    </div>

    <ul class="dropdown-menu dropdown-menu-end">

        <li>

            <form
                action="{{ route('logout') }}"
                method="POST">

                @csrf

                <button
                    type="submit"
                    class="dropdown-item">

                    <i class="bi bi-box-arrow-right"></i>

                    Cerrar sesión

                </button>

            </form>

        </li>

    </ul>

</div>

</nav>