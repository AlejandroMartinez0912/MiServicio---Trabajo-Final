<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura de Pago</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; color: #333; }
        .container { width: 100%; max-width: 600px; margin: 30px auto; background-color: #ffffff; border-radius: 8px;
                     box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); overflow: hidden; }
        .header { background-color: black; padding: 20px; text-align: center; }
        .header img { width: 100px; height: auto; }
        .header h1 { color: #ffffff; font-size: 24px; margin: 10px 0 0; }
        .content { padding: 20px; }
        .content p { font-size: 16px; line-height: 1.6; margin-bottom: 20px; }
        .footer { text-align: center; padding: 10px; background-color: #f8f9fa; font-size: 14px; color: #777; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('Images/logo.png') }}" alt="MiServicio Logo">
            <h1>Factura de Pago</h1>
        </div>
        <div class="content">
            <p>Estimado/a <strong>{{ $persona->nombre }} {{ $persona->apellido }}</strong>,</p>
            <p>Tu pago ha sido procesado exitosamente. Aquí están los detalles de tu factura:</p>
            <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif;">
                <tr style="background-color: #f4f4f4;">
                    <th style="text-align: left; padding: 10px; border-bottom: 2px solid #ddd;">Detalle</th>
                    <th style="text-align: left; padding: 10px; border-bottom: 2px solid #ddd;">Información</th>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Fecha de Pago:</strong></td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $factura->fecha_pago }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Monto Total:</strong></td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">${{ number_format($factura->total, 2) }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;"><strong>Método de Pago:</strong></td>
                    <td style="padding: 10px; border-bottom: 1px solid #ddd;">{{ $factura->metodo_pago }}</td>
                </tr>
                <tr>
                    <td style="padding: 10px;"><strong>Servicio:</strong></td>
                    <td style="padding: 10px;">{{ $cita->servicio->nombre }}</td>
                </tr>
            </table>
            
            <p>Gracias por confiar en <strong>MiServicio</strong>. ¡Esperamos verte pronto!</p>
        </div>
        <div class="footer">
            <p>&copy; 2024 MiServicio. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>
