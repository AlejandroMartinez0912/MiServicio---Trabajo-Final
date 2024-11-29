<!-- resources/views/emails/agendaProfesional.blade.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agenda del Día</title>
</head>
<body>
    <h1>Hola {{ $citas->first()->profesion->nombre }}!</h1>
    <p>Este es el resumen de las citas confirmadas para hoy:</p>

    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>ID de la Cita</th>
                <th>Servicio</th>
                <th>Fecha y Hora</th>
                <th>Estado del Cliente</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas as $cita)
                <tr>
                    <td>{{ $cita->idCita }}</td>
                    <td>{{ $cita->servicio->nombre }}</td>
                    <td>{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d/m/Y H:i') }}</td>
                    <td>{{ $cita->estado_cliente }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p>Gracias por utilizar nuestra plataforma.</p>
</body>
</html>
