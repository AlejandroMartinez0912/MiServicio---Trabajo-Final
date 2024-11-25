<div>   <!-- Selección de fecha -->
    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha:</label>
        <input type="date" id="fecha" name="fecha" class="form-control" required>
    </div>

    <!-- Selección de horario -->
    <div class="mb-3">
        <label for="horaInicio" class="form-label">Hora de Inicio:</label>
        <input type="time" id="horaInicio" name="horaInicio" class="form-control" required>
    </div>

<form id="appointmentForm" method="POST" action="{{ route('guardar-cita') }}">
    @csrf
    <input type="hidden" id="hiddenDate" name="fecha">
    <input type="hidden" id="hiddenTime" name="horaInicio">
    <input type="hidden" id="hiddenService" name="servicio_id" value="{{ $servicio->id }}">
    <button type="submit" class="btn btn-success">Confirmar</button>
</form>
</div>