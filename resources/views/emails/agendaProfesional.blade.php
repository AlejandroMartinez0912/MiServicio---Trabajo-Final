<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda del día</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #333;
            color: white;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            background-color: #1c1c1c;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: black;
            padding: 30px;
            text-align: center;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .header img {
            width: 120px;
            height: auto;
        }

        .header h1 {
            color: white;
            font-size: 28px;
            margin-top: 15px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .content {
            padding: 30px;
            background-color: #ffffff;
            color: #333;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .details {
            margin-top: 20px;
        }

        .details table {
            width: 100%;
            border-collapse: collapse;
        }

        .details table th, .details table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .details table th {
            background-color: #333;
            color: white;
        }

        .details table td {
            background-color: #f9f9f9;
        }

        .details table td:nth-child(even) {
            background-color: #f1f1f1;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            margin-top: 20px;
            background-color: #333;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: black;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            font-size: 14px;
            color: #777;
        }

        .footer a {
            color: #007BFF;
            text-decoration: none;
            font-weight: 600;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .container {
                margin: 20px;
            }

            .header h1 {
                font-size: 24px;
            }

            .content {
                padding: 20px;
            }

            .footer {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header con el logo -->
        <div class="header">
            <img src="{{ asset('Images/logo.png') }}" alt="MiServicio Logo">
            <h1>Cita confirmada para mañana</h1>
        </div>
        
        <!-- Contenido del correo -->
        <div class="content">
            <p>Estimado/a,</p>
            <p>Te enviamos el resumen de las citas agendadas para mañana:</p>

            <div class="details">
                <table>
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Servicio</th>
                            <th>Precio base</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($citas as $cita)
                            <tr>
                                <td>{{ $cita->persona->nombre }} {{ $cita->persona->apellido }}</td>
                                <td>{{ $cita->servicio->nombre }}</td>
                                <td>${{ $cita->servicio->precio_base }}</td>
                                <td style="background-color: yellow; padding: 5px; border-radius: 5px;"><strong>{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d/m/Y') }}</strong></td>
                                <td style="background-color: yellow; padding: 5px; border-radius: 5px;"><strong>{{ \Carbon\Carbon::parse($cita->horaInicio)->format('H:i') }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <p>Si tienes alguna consulta o necesitas modificar tu cita, no dudes en ponerte en contacto con nosotros.</p>

            <a href="mailto:support@miservicio.com" class="button">Contáctanos</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 MiServicio. Todos los derechos reservados.</p>
            <p>¿Necesitas ayuda? <a href="mailto:support@miservicio.com">Contáctanos</a>.</p>
        </div>
    </div>
</body>
</html>
