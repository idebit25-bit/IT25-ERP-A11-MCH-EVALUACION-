<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Capital Humano ERP</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    {{-- Navbar --}}
    @include('partials.navbar')

    <div class="main-container">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        {{-- Contenido --}}
        <main class="content">
            @yield('content')
        </main>

    </div>

    {{-- Footer --}}
    @include('partials.footer')

    @stack('scripts')

</body>
</html>