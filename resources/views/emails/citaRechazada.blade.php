<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rechazo de Cita</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 30px auto;  
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: black;
            padding: 20px;
            text-align: center;
        }

        .header img {
            width: 100px;
            height: auto;
        }

        .header h1 {
            color: #ffffff;
            font-size: 24px;
            margin: 10px 0 0;
        }

        .content {
            padding: 20px;
        }

        .content p {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .content ul {
            list-style-type: none;
            padding: 0;
        }

        .content ul li {
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 10px;
        }

        .content ul li strong {
            color: #007BFF;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f9fa;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header con el logo -->
        <div class="header">
            <img src="{{ asset('Images/logo.png') }}" alt="MiServicio Logo">
            <h1>¡Cita rechazada! </h1>
        </div>
        
        <!-- Contenido del correo -->
        <div class="content">
            <p>Estimado/a,</p>
            <p>Lamentamos informarte que tu cita ha sido rechaza. Sigue buscando la mejor alternativa en <strong>MiServicio</strong></p>
            
            <p>¡Esperamos verte pronto!</p>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>&copy; 2024 MiServicio. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
