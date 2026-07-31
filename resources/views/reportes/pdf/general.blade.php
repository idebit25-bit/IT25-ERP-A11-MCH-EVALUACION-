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
    padding:8px;
    border:1px solid #ccc;
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

Reporte General de Recursos Humanos

</h2>

<div class="empresa">

I-DEB Soporte y Servicios

</div>

<table>

<thead>

<tr>

    <th>Indicador</th>

    <th>Total</th>

</tr>

</thead>

<tbody>

<tr>

    <td>Colaboradores registrados</td>

    <td>{{ $datos['colaboradores'] }}</td>

</tr>

<tr>

    <td>Evaluaciones registradas</td>

    <td>{{ $datos['evaluaciones'] }}</td>

</tr>

<tr>

    <td>Documentos registrados</td>

    <td>{{ $datos['documentos'] }}</td>

</tr>

<tr>

    <td>Departamentos registrados</td>

    <td>{{ $datos['departamentos'] }}</td>

</tr>

</tbody>

</table>

<div class="footer">

Documento generado automáticamente por el ERP Capital Humano.

<br>

Uso interno de I-DEB Soporte y Servicios.

</div>

</body>

</html>