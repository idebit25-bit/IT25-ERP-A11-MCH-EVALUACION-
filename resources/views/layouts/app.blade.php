<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capital Humano ERP</title>
    <link rel="icon" type="image/png" href="{{ asset('images/company-icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body data-change-saved="{{ session()->has('success') ? '1' : '0' }}"
      data-refresh-list="{{ request()->is('evaluaciones', 'mis-evaluaciones', 'notificaciones', 'dashboard', 'documentos', 'documentos/manuales', 'documentos/formatos', 'documentos/politicas', 'documentos/procedimientos') ? '1' : '0' }}">

    {{-- Navbar --}}
    @include('partials.navbar')

    <div class="main-container">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Contenido --}}
        <main class="content">
            @include('partials.messages')
            @yield('content')
        </main>

    </div>



    @include('partials.footer')

    @stack('scripts')

</body>
</html>
