@extends('layouts.miservicioIn')

@section('titulo', 'MiServicio | Agendar Cita')
<style>
    /* Estilo para los elementos h5 */
    h3 {
        font-family: sans-serif; /* Fuente gruesa y moderna */
        font-weight: 900; /* Máxima negrita */
        color: #e0e0e0; /* Gris claro para un contraste elegante */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Sombra para mayor profundidad */
    }
    h4 {
        font-family: sans-serif; /* Fuente gruesa y moderna */
        font-weight: 900; /* Máxima negrita */
        color: #e0e0e0; /* Gris claro para un contraste elegante */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Sombra para mayor profundidad */
    }

    #servicio-container, #profesional-container, #horario-container {
        background-color: #333; /* Fondo oscuro */
        padding: 20px;
        border-radius: 10px;
        width: 600px;
        color: #e0e0e0; /* Texto claro */
    }

    /* Estilo para los botones deshabilitados */
    .btn[disabled] {
        background-color: #555;
        color: #888;
        pointer-events: none; /* Evita que se pueda hacer clic */
    }

    /* Contenedor principal */
    .date-picker-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #333; /* Fondo oscuro */
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.4);
        gap: 20px;
        color: #e0e0e0; /* Texto claro */
    }

    /* Botones de navegación */
    .navigation-buttons {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .date-picker-container button {
        background-color: #444; /* Fondo oscuro */
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 18px;
    }

    .date-picker-container button:hover {
        background-color: #0056b3;
    }

    /* Contenedor de fechas */
    .date-display {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        font-size: 18px;
        gap: 10px;
    }

    /* Contenedor de horarios */
    .schedule-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 10px;
        background-color: #444; /* Fondo oscuro */
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        color: #e0e0e0; /* Texto claro */
    }

    /* Días seleccionables */
    .day-box {
        text-align: center;
        background-color: #70e188;
        color: #333;
        padding: 20px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        margin: 2px;
    }

    .day-box.selected {
        background-color: #3f3fd1;
        color: white;
    }

    .day-box.unavailable {
        background-color: #ffebee;
        color: #f44336;
        cursor: not-allowed;
    }

    .day-box span {
        display: block;
    }

    .day-box #month {
        font-size: 18px;
        font-weight: bold;
    }

    .day-box #weekday {
        font-size: 16px;
    }

    .day-box #day {
        font-size: 20px;
        font-weight: bold;
    }

    .schedule-item {
        margin: 5px;
        padding: 10px;
        background-color: #444; /* Fondo oscuro */
        border: 1px solid #555;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        color: #e0e0e0; /* Texto claro */
    }

    .schedule-item:hover {
        background-color: #555;
    }

    .schedule-item.selected {
        background-color: #4caf50;
        color: #fff;
        font-weight: bold;
        border-color: #4caf50;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .modal-dialog {
        margin: 15% auto;
        max-width: 500px;
    }

    .modal-content {
        background-color: #333; /* Fondo oscuro */
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        color: #e0e0e0; /* Texto claro */
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        margin: 10px 0;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
    }

    /* Botón agendar cita */
    .btn-agendar-cita {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 5px;
        color: #fff;
        background-color: #444; /* Fondo oscuro */
        transition: all 0.3s ease;
        border: none;
    }

    .btn-agendar-cita:hover {
        background-color: #3A3F47; /* Color de fondo al pasar el mouse */
        color: #FFD700; /* Color del texto al pasar el mouse */
        cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
    }

    .form-container {
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
        border-radius: 10px;
        background: #444; /* Fondo oscuro */
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
        color: #e0e0e0; /* Texto claro */
    }

    .form-container h4 {
        color: #e0e0e0;
        font-weight: 700;
    }

    .form-control {
        border: 1px solid #555;
        border-radius: 5px;
        padding: 10px;
        background-color: #666; /* Fondo oscuro */
        color: #e0e0e0; /* Texto claro */
    }

    .btn-primary {
        background: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background: #0056b3;
    }
</style>

@section('contenido')

<div class="container" style="background:linear-gradient(135deg, #2a2a2a, #1c1c1c); padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3); color: #f8f9fa;">
    <h3 class="text-center mb-5 text-uppercase font-weight-bold">Agendar Cita</h3>
    <div class="container" style="padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3); display: flex; gap: 20px; background:linear-gradient(135deg, #2a2a2a, #1c1c1c);">
        <div style="flex: 1;">
            <!-- Contenido del primer div -->
            <h4 style="color: #f8f9fa;"><i class="bx bx-wrench"></i> Servicio elegido</h4>
            <div class="d-flex align-items-center mt-3">
                <div>
                    <h6 class="mb-0" style="font-family: 'Roboto', sans-serif; font-weight: bold; font-size: 1.2rem; color: #f8f9fa;">
                        {{ $servicio->nombre }}
                    </h6>
    
                    @php
                        // Convertir tiempo de formato HH:MM a minutos
                        $duracionEstimada = \Carbon\Carbon::parse($servicio->duracion_estimada);
                        $duracionEnMinutos = $duracionEstimada->hour * 60 + $duracionEstimada->minute;
                    @endphp
                    <!-- Duración formateada en horas y minutos -->
                    <p class="card-text" style="font-size: 0.9rem; color: #adb5bd;">
                        Duración: {{ floor($duracionEnMinutos / 60) }}h {{ $duracionEnMinutos % 60 }}m
                    </p>
                    <!-- Precio estimado -->
                    <p class="card-text" style="font-size: 0.9rem; color: #adb5bd;">
                        Precio estimado: ${{ number_format($servicio->precio_base, 2) }}
                    </p>
                </div>
            </div>
        </div>
        <div style="flex: 1;">
            <!-- Contenido del segundo div -->
            <div class="d-flex justify-content-between align-items-center">
                <h4 style="color: #f8f9fa;"><i class='bx bxs-briefcase-alt-2'></i> Profesional encargado</h4>
            </div>
            <div class="d-flex align-items-center mt-3">
                <div>
                    <h6 class="mb-0" style="font-family: 'Roboto', sans-serif; font-weight: bold; font-size: 1.2rem; color: #f8f9fa;">
                        {{ $persona->nombre }} {{ $persona->apellido }}
                    </h6>
                    <p class="card-text" style="font-size: 0.9rem; color: #adb5bd;">Ubicación: {{ $datosProfesion->ubicacion }}</p>
                    <p class="card-text" style="font-size: 0.9rem; color: #adb5bd;">Teléfono: {{ $datosProfesion->telefono }}</p>
                    @if ($datosProfesion->calificacion == 0)
                        <p class="card-text" style="font-size: 0.9rem; color: #adb5bd;">Calificación: No calificado</p>
                    @else
                        <p class="card-text" style="font-size: 0.9rem; color: #adb5bd;">Calificación: {{ $datosProfesion->calificacion }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Elección de fecha y horario -->
    <div class="container" style="padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3); background:linear-gradient(135deg, #2a2a2a, #1c1c1c);">
        <hr style="border-color: #495057;">
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-3" style="color: #f8f9fa;"><i class='bx bxs-calendar'></i> Elegir fecha y horario</h4>
        </div>
        <form id="citaForm" method="POST" action="{{ route('guardar-cita') }}">
            @csrf
            <!-- Campo oculto para el id del servicio -->
            <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">

            <!-- Selección de fecha -->
            <div class="form-group mb-3">
                <label for="fecha" class="form-label" style="color: #f8f9fa;"><i class="bx bx-calendar"></i> Fecha de la cita:</label>
                <input type="text" id="fecha" name="fecha" class="form-control" placeholder="Seleccione una fecha" required style="background-color: white; color: black;">
            </div>

            <!-- Selección de hora -->
            <div class="form-group mb-3">
                <label for="horaInicio" class="form-label" style="color: #f8f9fa;"><i class="bx bx-time"></i> Hora de inicio:</label>
                <input type="text" id="horaInicio" name="horaInicio" class="form-control" placeholder="Seleccione la hora de inicio" required style="background-color: white ; color: black ;">
            </div>

            <!-- Botón de enviar -->
            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#confirmModal">Confirmar</button>
        </form>
    </div>
</div>




<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmar Cita</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas confirmar la cita con la siguiente información?</p>
                <p><strong>Fecha:</strong> <span id="confirmFecha"></span></p>
                <p><strong>Hora de inicio:</strong> <span id="confirmHora"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmarCita">Confirmar</button>
            </div>
        </div>
    </div>
</div>
<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Inicializar Flatpickr
    flatpickr("#fecha", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        minDate: "today"
    });

    flatpickr("#horaInicio", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });

    // Función para actualizar los datos de la cita en el modal de confirmación
    document.querySelector('button[data-bs-toggle="modal"]').addEventListener('click', function() {
        const fecha = document.getElementById('fecha').value;
        const horaInicio = document.getElementById('horaInicio').value;

        document.getElementById('confirmFecha').textContent = fecha;
        document.getElementById('confirmHora').textContent = horaInicio;
    });

    // Confirmar la cita y enviar el formulario
    document.getElementById('confirmarCita').addEventListener('click', function() {
        document.getElementById('citaForm').submit();  // Envía el formulario
    });
</script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">




@endsection

