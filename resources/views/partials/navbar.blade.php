<nav class="navbar">

    <div class="navbar-left">

        <!-- Botón hamburguesa -->

        <button id="menu-toggle" class="menu-toggle">

            <i class="bi bi-list"></i>

        </button>

<div class="navbar-title">

    <img
        src="{{ asset('images/footer/ideb-logo-blanco.png') }}"
        alt="I-DEB"
        class="navbar-logo"
    >

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

    <div class="navbar-user-data">

        <span class="navbar-user-name">

            {{ auth()->user()?->first_name }}
            {{ auth()->user()?->paternal_surname }}

        </span>


    </div>

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