<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<style>

body{
    font-family: DejaVu Sans,sans-serif;
    font-size:11px;
    color:#333;
}

h1{
    margin:0;
    text-align:center;
    font-size:20px;
}

h2{
    margin:3px 0 15px;
    text-align:center;
    font-size:15px;
    color:#555;
}

.empresa{
    text-align:center;
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:#2d5d7b;
    color:white;
}

th{
    padding:8px;
    border:1px solid #999;
}

td{
    padding:7px;
    border:1px solid #ccc;
}

.resumen{
    margin-bottom:20px;
}

.resumen td:first-child{
    width:180px;
    font-weight:bold;
    background:#f3f3f3;
}

.footer{
    margin-top:25px;
    text-align:center;
    font-size:9px;
    color:#666;
}

</style>

</head>

<body>

<h1>

ERP Capital Humano

</h1>

<h2>

Reporte General de Documentos

</h2>

<div class="empresa">

I-DEB Soporte y Servicios

</div>

<table class="resumen">

<tr>

    <td>Fecha de generación</td>

    <td>{{ now()->format('d/m/Y H:i') }}</td>

</tr>

<tr>

    <td>Generado por</td>

    <td>{{ $usuario->full_name }}</td>

</tr>

<tr>

    <td>Total de registros</td>

    <td>{{ $datos->count() }}</td>

</tr>

</table>

<table>

<thead>

<tr>

    <th>Código</th>

    <th>Documento</th>

    <th>Tipo</th>

    <th>Versión</th>

    <th>Estado</th>

    <th>Vigencia</th>

</tr>

</thead>

<tbody>

@forelse($datos as $documento)

<tr>

    <td>{{ $documento->code }}</td>

    <td>{{ $documento->name }}</td>

    <td>{{ $documento->type }}</td>

    <td>{{ $documento->version }}</td>

    <td>{{ $documento->status }}</td>

    <td>

        {{ $documento->expiration_date
            ? \Carbon\Carbon::parse($documento->expiration_date)->format('d/m/Y')
            : 'N/A' }}

    </td>

</tr>

@empty

<tr>

    <td colspan="6" align="center">

        No existen documentos registrados.

    </td>

</tr>

@endforelse

</tbody>

</table>

<div class="footer">

Documento generado automáticamente por el ERP Capital Humano.

<br>

Uso interno de I-DEB Soporte y Servicios.

</div>

</body>

</html>