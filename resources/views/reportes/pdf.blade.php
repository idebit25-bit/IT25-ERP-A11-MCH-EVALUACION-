<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #333;
        }

        h1 {
            margin: 0;
            text-align: center;
            font-size: 20px;
        }

        h2 {
            margin: 3px 0 15px;
            text-align: center;
            font-size: 15px;
            color: #555;
        }

        .empresa {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .resumen {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .resumen td {
            padding: 6px;
            border: 1px solid #dcdcdc;
        }

        .resumen td:first-child {
            font-weight: bold;
            width: 180px;
            background: #f3f3f3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background: #2d5d7b;
            color: white;
        }

        th {
            padding: 8px;
            border: 1px solid #999;
            font-size: 10px;
        }

        td {
            padding: 7px;
            border: 1px solid #cfcfcf;
            font-size: 10px;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #666;
        }
    </style>

</head>

<body>

    <h1>ERP Capital Humano</h1>

    <h2>Reporte General de {{ ucfirst($tipo) }}</h2>

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
            <td>{{ $evaluaciones->count() }}</td>
        </tr>

        <tr>
            <td>Tipo de reporte</td>
            <td>{{ ucfirst($tipo) }}</td>
        </tr>

    </table>

    <table>

        <thead>

            <tr>
                <th>Colaborador</th>
                <th>Departamento</th>
                <th>Tipo</th>
                <th>Periodo</th>
                <th>Evaluador</th>
                <th>Calificación</th>
                <th>Estado</th>
            </tr>

        </thead>

        <tbody>

            @forelse($evaluaciones as $evaluacion)

                <tr>

                    <td>{{ $evaluacion->user?->full_name }}</td>

                    <td>{{ $evaluacion->user?->department?->name }}</td>

                    <td>{{ $evaluacion->evaluationType?->name }}</td>

                    <td>{{ $evaluacion->period?->name }}</td>

                    <td>{{ $evaluacion->evaluator?->full_name }}</td>

                    <td align="center">

                        {{ number_format($evaluacion->total_score, 2) }} / 5

                    </td>

                    <td align="center">

                        {{ $evaluacion->status_label }}

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="7" align="center">

                        No existen registros para mostrar.

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