<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <style>

        body{
            font-family: DejaVu Sans, sans-serif;
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

            font-weight:bold;
            background:#f3f3f3;
            width:180px;

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

Reporte General de Colaboradores

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

    <th>Colaborador</th>

    <th>Departamento</th>

    <th>Puesto</th>

    <th>Estatus</th>

</tr>

</thead>

<tbody>

@forelse($datos as $usuario)

<tr>

    <td>

        {{ $usuario->employee_code }}

    </td>

    <td>

        {{ $usuario->full_name }}

    </td>

    <td>

        {{ $usuario->department?->name }}

    </td>

    <td>

        {{ $usuario->position?->name }}

    </td>

    <td>

        {{ ucfirst($usuario->status) }}

    </td>

</tr>

@empty

<tr>

    <td colspan="5" align="center">

        No existen colaboradores registrados.

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