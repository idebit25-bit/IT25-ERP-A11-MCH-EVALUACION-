<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>

        ERP Capital Humano

    </title>
    <link rel="icon" type="image/png" href="{{ asset('images/company-icon.png') }}">

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="bg-light">

    @include('partials.messages')

    @yield('content')

</body>

</html>
