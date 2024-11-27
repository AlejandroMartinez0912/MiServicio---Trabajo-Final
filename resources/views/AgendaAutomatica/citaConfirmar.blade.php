<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar cita</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #000;
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
            color: #ffffff;
            font-size: 28px;
            margin-top: 15px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .content {
            padding: 30px;
            background-color: #ffffff;
            color: #333;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .content p strong {
            color: #007BFF;
        }

        .details {
            margin-top: 20px;
        }

        .details ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .details ul li {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 12px;
            padding-left: 20px;
            position: relative;
        }

        .details ul li:before {
            content: "•";
            position: absolute;
            left: 0;
            color: #007BFF;
            font-size: 20px;
            top: 0;
        }

        .button {
            display: inline-block;
            padding: 12px 30px;
            margin-top: 20px;
            background-color: #007BFF;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .footer {
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            font-size: 14px;
            color: #777;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
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
            <h1>Confirmar cita para mañana</h1>
        </div>
        
        <!-- Contenido del correo -->
        <div class="content">
            <p>Estimado/a {{$cita->persona->nombre}}{{$cita->persona->apellido}},</p>
            <p>Confirma por favor tu cita para manana, que contiene la siguiente información:</p>
            
            <div class="details">
                <ul>
                    <li><strong>Fecha:</strong> {{ $cita->fechaCita }}</li>
                    <li><strong>Hora de inicio:</strong> {{ $cita->horaInicio }}</li>
                    <li><strong>Hora de fin:</strong> {{ $cita->horaFin }}</li>
                    <li><strong>Servicio contratado:</strong> {{ $cita->servicio->nombre }}</li>
                    <li><strong>Profesional asignado:</strong> {{ $cita->servicio->datos_profesion->users->persona->nombre }}</li>
                </ul>
            </div>

            <p>Para confirmar tu asistencia, por favor, haz clic en el siguiente botón:</p>
            
            <!-- Botón de Confirmación -->
            <a href="{{ route('cita-confirmada', ['id' => $cita->idCita]) }}" class="button">Confirmar cita</a>

            <p>Si necesitas hacer alguna modificación en tu cita, no dudes en ponerte en contacto con nosotros.</p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 MiServicio. Todos los derechos reservados.</p>
            <p>¿Necesitas ayuda? <a href="mailto:support@miservicio.com">Contáctanos</a>.</p>
        </div>
    </div>
</body>
</html>
