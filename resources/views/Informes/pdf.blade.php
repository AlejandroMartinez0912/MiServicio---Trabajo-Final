<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiServicio | Informe de Citas</title>
    <style>

        body {
            font-family: "Montserrat", sans-serif;
            background-color: #1a1a1a;
            margin: 0;
            padding: 0;
            color: #eaeaea;
            line-height: 1.6;
        }

        

        .header {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 2px solid #444;
        }

        .header h1 {
            color: #fff;
            font-size: 32px;
            margin-top: 15px;
            letter-spacing: 1px;
        }

        .header h1 strong {
            color: #00aaff;
        }

        .content {
            padding: 20px;
        }

        .content p {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 25px;
            color: #dcdcdc;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            color: #eaeaea;
        }

        .table th, .table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #444;
        }

        .table th {
            background-color: #444;
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
        }

        .table td {
            background-color: #555;
        }

        .table tr:hover {
            background-color: #666;
            transition: background-color 0.3s;
        }

        .footer {
            text-align: center;
            padding: 15px;
            background-color: #222;
            color: #bbb;
            font-size: 14px;
        }

        .footer p {
            margin: 0;
        }

        /* Mejoras en la estética de los botones */
        .button {
            background-color: #007bff;
            border: none;
            color: #fff;
            padding: 12px 20px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        .button:hover {
            background-color: #0056b3;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><strong>MiServicio</strong> | Informe de Citas</h1>
        </div>
        <div class="content">
            <p>En este informe se muestran las citas programadas junto con la información de servicio, estado y calificaciones.</p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Fecha de Cita</th>
                        <th>Estado</th>
                        <th>Calificación Profesional</th>
                        <th>Calificación Cliente</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($citas as $cita)
                        <tr>
                            <td>{{ $cita->servicio->nombre }}</td>
                            <td>{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d-m-Y H:i') }}</td>
                            @php
                                if ($cita->estado == 4) {
                                    $cita->estado = 'Pagada';
                                } elseif ($cita->estado == 3) {
                                    $cita->estado = 'Re-confirmada';
                                } elseif ($cita->estado == 2) {
                                    $cita->estado = 'Cancelada';
                                } elseif ($cita->estado == 1) {
                                    $cita->estado = 'Confirmada';
                                } elseif ($cita->estado == 0) {
                                    $cita->estado = 'Pendiente';
                                } else {
                                    $cita->estado = 'No corresponde';
                                }
                            @endphp
                            <td>{{ $cita->estado }}</td>
                            <td>{{ $cita->calificacionesProfesion->calificacion ?? 'No corresponde' }}</td>
                            <td>{{ $cita->calificacionesCliente->calificacion ?? 'No corresponde' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="footer">
            <p>&copy; 2024 MiServicio. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
