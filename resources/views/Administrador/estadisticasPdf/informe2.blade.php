<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MiServicio | Optimización de Precios según Demanda y Calificaciones
    </title>

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
            <h1><strong>MiServicio</strong> | Optimización de Precios s</h1>
            <h3>Reporte de servicios del {{ date('d-m-Y') }}</h3>
        </div>
        <div class="content">
            <p>En este informe se muestran llos servicios por rubros.</p>
            <!-- Tabla de auditorías -->
            <table border="1">
                <thead>
                    <tr>
                        <th>Servicio</th>
                        <th>Precio Base</th>
                        <th>Calificación</th>
                        <th>Cantidad de Reservas</th>
                        <th>Precio Sugerido</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($serviciosOptimizado as $servicio)
                        <tr>
                            <td>{{ $servicio->nombre }}</td>
                            <td>{{ number_format($servicio->precio_base, 2) }}</td>
                            <td>{{ $servicio->calificacion }}</td>
                            <td>{{ $servicio->cantidad_reservas }}</td>
                            <td>{{ number_format($servicio->precio_sugerido, 2) }}</td>
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