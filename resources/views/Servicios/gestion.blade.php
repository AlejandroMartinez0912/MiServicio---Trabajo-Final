@extends('layouts.plantillain')

@section('titulo', 'Gestión de servicio')

@section('contenido')
<style>
    /* Ajuste de la barra de navegación */
    .navbar-nav .nav-link {
        display: flex;
        align-items: center; /* Alinea verticalmente el contenido */
        justify-content: center; /* Centra el contenido horizontalmente */
        font-size: 0.9rem; /* Reduce el tamaño de la fuente */
        height: 50px; /* Altura consistente para los ítems */
        padding: 0 10px; /* Espaciado horizontal */
        color: #fff; /* Color de texto */
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .navbar-nav .nav-link:hover {
        background-color: #3A3F47;
        border-radius: 5px;
        color: #FFD700; /* Color del texto al hacer hover */
    }

    .navbar-nav .nav-link i {
        margin-right: 5px; /* Espaciado entre el ícono y el texto */
        font-size: 1rem; /* Tamaño del ícono */
    }

    /* Ajustes para ítems más pequeños */
    .navbar-nav .nav-item {
        margin: 0 5px; /* Espaciado entre los ítems */
    }
    /* Efecto hover para los botones */
    .nav-button:hover {
        background-color: #3A3F47;
        border-radius: 5px;
        color: #FFD700;
        cursor: pointer;
    }

    /* Fondo de la barra de navegación más oscuro y sutil sombra */
    .container {
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        padding: 10px 0;
    }

    /* Transición suave al pasar el ratón */
    .nav-button {
        font-family: 'Arial', sans-serif;
        font-weight: 500;
        font-size: 1.1rem;
        padding: 10px 20px;
        transition: all 0.3s ease;
        display: inline-block;
        margin: 5px 10px;
        border-radius: 5px;
        color: #fff;
        background-color: #333;
    }

    /* Logo más estilizado */
    .navbar-brand {
        font-family: 'Segoe UI', sans-serif;
        font-size: 1.5rem;
        letter-spacing: 1px;
    }

    /* Estilo para el contenedor de los botones */
    .nav-button.active-tab {
        background-color: #3A3F47;
        color: #FFD700;
    }

    /* Estilo para los iconos */
    .nav-button i {
        margin-right: 8px;
    }

    /* Estilo para el contenedor de botones */
    .d-flex {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    /* Estilo general para las secciones */
    .content-section {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        width: 800px;
        margin: 0 auto;
    }

    /* Estilo para los títulos */
    h3 {
        font-family: sans-serif;
        font-weight: 900;
        color: #333333;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        text-align: center;
        margin-bottom: 30px;
    }

    /* Estilo para los botones */
    .btn {
        background-color: #28a745;
        color: white;
        font-weight: bold;
        border-radius: 5px;
    }

    .btn[disabled] {
        background-color: #e0e0e0;
        color: #b0b0b0;
        pointer-events: none;
    }

    /* Estilo para los grupos de formulario */
    .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .form-group {
        width: 48%;
    }

    .form-control {
        border-radius: 5px;
        padding: 10px;
    }

    .form-label {
        font-weight: bold;
    }

    /* Estilo para los campos de texto */
    input[type="text"], input[type="number"], select {
        font-size: 1rem;
        padding: 10px;
        border-radius: 5px;
    }

    /* Estilo de la modal */
    .modal-body {
        padding: 20px;
    }
    /* Estilo para la tabla de horarios */
    .horarios-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 30px;
        background-color: #fff;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Encabezado de la tabla */
    .horarios-table thead {
        background-color: #333;
        color: #fff;
        text-align: left;
    }

    .horarios-table th {
        padding: 15px;
        font-size: 1rem;
        font-weight: 600;
        text-transform: uppercase;
    }

    /* Celdas de la tabla */
    .horarios-table td {
        padding: 12px;
        font-size: 0.95rem;
        border-bottom: 1px solid #ddd;
        text-align: center;
    }

    /* Colores alternos para las filas */
    .horarios-table tbody tr:nth-child(odd) {
        background-color: #f9f9f9;
    }

    .horarios-table tbody tr:nth-child(even) {
        background-color: #f1f1f1;
    }

    /* Efecto hover en filas */
    .horarios-table tbody tr:hover {
        background-color: #f0f0f0;
        transition: background-color 0.3s ease;
    }

    /* Botones de acción */
    .btn-action {
        font-size: 0.9rem;
        padding: 5px 10px;
        margin: 2px;
        border-radius: 5px;
        transition: all 0.3s ease;
        color: #fff;
        border: none;
    }

    .btn-action.edit {
        background-color: #007bff;
    }

    .btn-action.edit:hover {
        background-color: #0056b3;
    }

    .btn-action.anular {
        background-color: #ffc107;
        color: #333;
    }

    .btn-action.anular:hover {
        background-color: #e0a800;
    }

    .btn-action.activar {
        background-color: #28a745;
    }

    .btn-action.activar:hover {
        background-color: #218838;
    }

    .btn-action.eliminar {
        background-color: #dc3545;
    }

    .btn-action.eliminar:hover {
        background-color: #c82333;
    }

    /* Botón para crear horario */
    .btn-primary {
        background-color: #333;
        color: #fff;
        border: none;
        font-size: 1rem;
        padding: 10px 20px;
        margin-top: 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #3A3F47;
        color: #FFD700;
    }

    /* Modales */
    .modal-body {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
    }

    /* Títulos dentro de la modal */
    .modal-body h3 {
        text-align: center;
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 20px;
    }

    /* Inputs en modales */
    .modal-body .form-control {
        border-radius: 5px;
        padding: 10px;
        font-size: 1rem;
        margin-bottom: 15px;
    }

   /* Estilo para el título principal */
   .services-title {
        font-family: 'Segoe UI', sans-serif;
        font-size: 2rem;
        font-weight: bold;
        color: #333;
        text-transform: uppercase;
        margin-bottom: 30px;
        text-align: center;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
    }
    h3.services-title {
        color: #333;
    }

    /* Contenedor de los servicios */
    #card-serviciosIndividual {
        margin: 20px auto;
        padding: 20px;
        border-radius: 10px;
        background-color: #f8f9fa;
        box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
    }

    /* Estilo para cada tarjeta de servicio */
    .service-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .service-card h3 {
        color: #007bff;
        font-size: 1.5rem;
        font-weight: 700;
    }

    .service-card .text-success {
        font-weight: bold;
    }

    .service-card .text-danger {
        font-weight: bold;
    }

    .service-card p {
        margin-bottom: 10px;
    }

    .service-card ul {
        padding-left: 20px;
        margin-top: 10px;
    }

    .service-card li {
        font-size: 0.9rem;
        color: #333;
        padding: 5px 0;
    }

    /* Botones de acción dentro de las tarjetas */
    .service-actions button {
        margin-top: 10px;
    }

    .service-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    /* Botón crear servicio */
    .btn-create-service {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 5px;
        color: #fff;
        background-color: #333;
        transition: all 0.3s ease;
    }

    .btn-create-service:hover {
        background-color: #3A3F47;
        color: #FFD700;
    }
    .titulo-servicio {
        color: #333; /* Negro */
        font-family: 'Segoe UI', sans-serif;
        font-size: 1.5rem;
    }
    h3 {
        color: #333 !important; /* Usa !important como último recurso */
    }

</style>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark"">
        <div class="container-fluid">
            <!-- Logo de la marca -->
            <a class="navbar-brand" href="#" style="font-family: 'Roboto', sans-serif; font-weight: 700; letter-spacing: 2px;">Gestión Servicios</a>

            <!-- Icono para el menú en móviles -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menú de navegación -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" onclick="showSection('datos')"><i class='bx bxs-business'></i> Datos Profesionales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="showSection('horarios')"><i class='bx bxs-time'></i>Horarios Atención</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="showSection('servicios')"><i class='bx bx-donate-blood'></i> Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="showSection('citas')"><i class='bx bx-list-check'></i>Mis citas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="showSection('agenda')"><i class='bx bxs-calendar'></i> Agenda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="showSection('informes')"><i class='bx bxs-detail'></i> Informes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="showSection('caja')"><i class='bx bx-dollar'></i> Caja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" onclick="{{ route('privada') }}">Volver</a>
                    </li>
                </ul>
            </div>
        </div>
</nav>

<!-- Secciones de contenido -->

<!-- Datos Profesionales -->
<div id="datos" class="content-section">
    @if($datosProfesion)
        <form action="{{ route('actualizar-datos', $datosProfesion->id) }}" method="POST">
            @csrf
            @method('PUT')
            
                <h3 class="text-uppercase font-weight-bold text-dark">Datos Profesionales</h3>
                <div class="card-body">
                    <!-- Sección: Nombre -->
                    <div class="form-row mb-4">
                        <div class="form-group">
                            <label for="nombre_fantasia" class="form-label">Nombre Fantasía</label>
                            <input type="text" class="form-control" id="nombre_fantasia" name="nombre_fantasia" value="{{ $datosProfesion->nombre_fantasia }}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="slogan" class="form-label">Slogan</label>
                            <input type="text" class="form-control" id="slogan" name="slogan" value="{{ $datosProfesion->slogan }}">
                        </div>
                    </div>

                    <!-- Sección: Ubicación y Contacto -->
                    <div class="form-row mb-4">
                        <div class="form-group">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{ $datosProfesion->ubicacion }}" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $datosProfesion->telefono }}">
                        </div>
                    </div>

                    <!-- Sección: Otros datos -->
                    <div class="form-row mb-4">
                        <div class="form-group">
                            <label for="experiencia" class="form-label">Experiencia</label>
                            <input type="number" id="experiencia" name="experiencia" class="form-control" min="0" step="1" placeholder="Ingrese la experiencia" required value="{{$datosProfesion->experiencia}}">
                        </div>
                        <div class="form-group">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-control" id="estado" name="estado">
                                <option value="1" {{ $datosProfesion->estado == 1 ? 'selected' : '' }}>Activo</option>
                                <option value="0" {{ $datosProfesion->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="calificacion" class="form-label">Calificación</label>
                            <div class="form-control-plaintext">
                                {{ $promedio }} 
                            </div>
                        </div>
                    </div>

                    <!-- Botón para actualizar -->
                    <button type="button" class="btn btn-success btn-lg w-100 mt-3 shadow-sm" data-toggle="modal" data-target="#confirmUpdateModal">
                        Actualizar Datos
                    </button>
                    <!-- Modal para confirmar actualización -->
                    <div class="modal fade" id="confirmUpdateModal" tabindex="-1" role="dialog" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmUpdateModalLabel">Confirmación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas actualizar los datos?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
        </form>
    @else
        <!-- Si no existen los datos, mostramos los campos vacíos para crear los datos -->
        <form action="{{ route('guardar-datos') }}" method="POST">
            @csrf

                <h3 class="text-uppercase font-weight-bold text-dark">Datos Profesionales</h3>
                <div class="card-body p-4">
                    <!-- Sección: Nombre -->
                    <div class="form-row mb-4">
                        <div class="form-group">
                            <label for="nombre_fantasia" class="form-label">Nombre Fantasía</label>
                            <input type="text" class="form-control" id="nombre_fantasia" name="nombre_fantasia" required>
                        </div>
                        <div class="form-group">
                            <label for="slogan" class="form-label">Slogan</label>
                            <input type="text" class="form-control" id="slogan" name="slogan">
                        </div>
                    </div>

                    <!-- Sección: Ubicación y Contacto -->
                    <div class="form-row mb-4">
                        <div class="form-group">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono">
                        </div>
                    </div>

                    <!-- Sección: Otros datos -->
                    <div class="form-row mb-4">
                        <div class="form-group">
                            <label for="experiencia" class="form-label">Experiencia</label>
                            <input type="number" id="experiencia" name="experiencia" class="form-control" min="0" step="1" placeholder="Ingrese la experiencia" required>
                        </div>
                    </div>
                    <!-- Botón para guardar -->
                    <button type="button" class="btn btn-success btn-lg w-100 mt-3 shadow-sm" data-toggle="modal" data-target="#confirmSaveModal">
                        Guardar Datos
                    </button>
                    <!-- Modal para confirmar guardado -->
                    <div class="modal fade" id="confirmSaveModal" tabindex="-1" role="dialog" aria-labelledby="confirmSaveModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="confirmSaveModalLabel">Confirmación</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    ¿Estás seguro de que deseas guardar los datos?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-success">Confirmar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    @endif
</div>

<!-- Sección de Horarios -->
<div  id="horarios" class="content-section">

            <!-- Modal para Crear Horario -->
            <div class="modal fade" id="crearHorarioModal" tabindex="-1" role="dialog" aria-labelledby="crearHorarioModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="crearHorarioModalLabel">Crear Horario de Trabajo</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('guardar-horario') }}" method="POST">
                                @csrf
                                
                                <!-- Mensajes de error -->
                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <!-- Campo de selección de Día -->
                                <div class="form-group">
                                    <label for="dia_id">Día</label>
                                    <select name="dia_id" id="dia_id" class="form-control" required>
                                        @foreach($dias as $dia)
                                            <option value="{{ $dia->id }}">{{ $dia->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Campo de Hora de Inicio -->
                                <div class="form-group">
                                    <label for="hora_inicio">Hora de Inicio</label>
                                    <input type="time" name="hora_inicio" class="form-control" required>
                                </div>

                                <!-- Campo de Hora de Fin -->
                                <div class="form-group">
                                    <label for="hora_fin">Hora de Fin</label>
                                    <input type="time" name="hora_fin" class="form-control" required>
                                </div>

                                <!-- Campo de Hora de Inicio (segunda franja) -->
                                <div class="form-group">
                                    <label for="hora_inicio1">Hora de Inicio (segunda franja)</label>
                                    <input type="time" name="hora_inicio1" class="form-control">
                                </div>

                                <!-- Campo de Hora de Fin (segunda franja) -->
                                <div class="form-group">
                                    <label for="hora_fin1">Hora de Fin (segunda franja)</label>
                                    <input type="time" name="hora_fin1" class="form-control">
                                </div>

                                <!-- Botón de Enviar -->
                                <button type="submit" class="btn btn-primary btn-block">Crear Horario</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mostrar los horarios ya creados -->
            @if($horariosTrabajo && $horariosTrabajo->isNotEmpty())
                    <h3 class="text-center mb-5 text-uppercase font-weight-bold">Horarios de atención</h3>
                    <table class="horarios-table">
                        <thead>
                            <tr>
                                <th>Día</th>
                                <th>Hora de Inicio</th>
                                <th>Hora de Fin</th>
                                <th>Hora de Inicio segundo horario</th>
                                <th>Hora de Fin segundo horario</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $diasSemana = [
                                    1 => 'Lunes',
                                    2 => 'Martes',
                                    3 => 'Miércoles',
                                    4 => 'Jueves',
                                    5 => 'Viernes',
                                    6 => 'Sábado',
                                    7 => 'Domingo',
                                ];
                            @endphp
                            @foreach($horariosTrabajo as $horario)
                                    <tr>
                                        <td>{{ $diasSemana[$horario->dias_id] ?? 'N/A' }}</td>  
                                        <td>{{ $horario->hora_inicio }}</td> 
                                        <td>{{ $horario->hora_fin }}</td>
                                        <td>{{ $horario->hora_inicio1 ?? 'N/A' }}</td>
                                        <td>{{ $horario->hora_fin1 ?? 'N/A' }}</td>
                                        <td>{{ $horario->estado == 1 ? 'Activo' : 'Inactivo' }}</td> 
                                        <td>
                                           <!-- Botón de Edición -->
                                            <button 
                                                data-toggle="modal" 
                                                data-target="#editarHorarioModal" 
                                                data-id="{{ $horario->id }}"
                                                data-hora_inicio="{{ $horario->hora_inicio }}"
                                                data-hora_fin="{{ $horario->hora_fin }}"
                                                data-hora_inicio1="{{ $horario->hora_inicio1 }}"
                                                data-hora_fin1="{{ $horario->hora_fin1 }}"
                                                class="btn-action edit">Editar
                                            </button>
                                            <!-- Modal para editar el horario -->
                                            <div class="modal fade" id="editarHorarioModal" tabindex="-1" role="dialog" aria-labelledby="editarHorarioModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editarHorarioModalLabel">Editar Horario</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <form action="{{ route('actualizar-horario', ':id') }}" method="POST" id="form-editar-horario">
                                                            @csrf
                                                            @method('PATCH')
                                                            <div class="modal-body">
                                                                <input type="hidden" id="horario-id-editar" name="id" value="">
                                                                
                                                                <!-- Campo de Hora de Inicio -->
                                                                <div class="form-group">
                                                                    <label for="hora_inicio">Hora de Inicio</label>
                                                                    <input type="time" name="hora_inicio" class="form-control" required>
                                                                </div>

                                                                <!-- Campo de Hora de Fin -->
                                                                <div class="form-group">
                                                                    <label for="hora_fin">Hora de Fin</label>
                                                                    <input type="time" name="hora_fin" class="form-control" required>
                                                                </div>

                                                                <!-- Campo de Hora de Inicio (segunda franja) -->
                                                                <div class="form-group">
                                                                    <label for="hora_inicio1">Hora de Inicio (segunda franja)</label>
                                                                    <input type="time" name="hora_inicio1" class="form-control">
                                                                </div>

                                                                <!-- Campo de Hora de Fin (segunda franja) -->
                                                                <div class="form-group">
                                                                    <label for="hora_fin1">Hora de Fin (segunda franja)</label>
                                                                    <input type="time" name="hora_fin1" class="form-control">
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                // Configuración del modal de edición
                                                $('#editarHorarioModal').on('show.bs.modal', function (event) {
                                                    var button = $(event.relatedTarget);
                                                    var horarioId = button.data('id');
                                                    var horaInicio = button.data('hora_inicio');
                                                    var horaFin = button.data('hora_fin');
                                                    var horaInicio1 = button.data('hora_inicio1');
                                                    var horaFin1 = button.data('hora_fin1');

                                                    // Actualizar los valores del formulario
                                                    $('#form-editar-horario').attr('action', '{{ route("actualizar-horario", ":id") }}'.replace(':id', horarioId));
                                                    $('#horario-id-editar').val(horarioId);
                                                    $('#hora_inicio').val(horaInicio);
                                                    $('#hora_fin').val(horaFin);
                                                    $('#hora_inicio1').val(horaInicio1);
                                                    $('#hora_fin1').val(horaFin1);
                                                });
                                            </script>
                                            

                                            <!-- Boton de anular/activar-->
                                            @if ($horario->estado == 1)
                                                <!-- Botón de Anular -->
                                                <button 
                                                    data-toggle="modal" 
                                                    data-target="#anularHorarioModal" 
                                                    data-id="{{ $horario->id }}" 
                                                    class="btn-action anular">Anular
                                                </button>
                                                <!-- Modal para anular el horario -->
                                                <div class="modal fade" id="anularHorarioModal" tabindex="-1" role="dialog" aria-labelledby="anularHorarioModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="anularHorarioModalLabel">Anular Horario</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('anular-horario', ':id') }}" method="POST" id="form-anular-horario">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-body">
                                                                    <p>¿Estás seguro de que deseas anular este horario? Esta acción cambiará su estado a inactivo.</p>
                                                                    <input type="hidden" id="horario-id" name="id" value="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <button type="submit" class="btn btn-danger">Anular</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <script>
                                                    // Este script se ejecutará cuando el modal se active
                                                    $('#anularHorarioModal').on('show.bs.modal', function (event) {
                                                        var button = $(event.relatedTarget); // El botón que abrió el modal
                                                        var horarioId = button.data('id'); // El ID del horario

                                                        // Actualizar la acción del formulario y el valor oculto con el ID del horario
                                                        var formAction = '{{ route("anular-horario", ":id") }}';
                                                        formAction = formAction.replace(':id', horarioId);
                                                        $('#form-anular-horario').attr('action', formAction);

                                                        // Llenar el campo oculto con el ID del horario
                                                        $('#horario-id').val(horarioId);
                                                    });
                                                </script>
                                            @else
                                                <!-- Botón de Activar -->
                                                <button 
                                                    data-toggle="modal" 
                                                    data-target="#activarHorarioModal" 
                                                    data-id="{{ $horario->id }}" 
                                                    class="btn-action activar">Activar
                                                </button>

                                                <!-- Modal para activar el horario -->
                                                <div class="modal fade" id="activarHorarioModal" tabindex="-1" role="dialog" aria-labelledby="activarHorarioModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="activarHorarioModalLabel">Activar Horario</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <form action="{{ route('activar-horario', ':id') }}" method="POST" id="form-activar-horario">
                                                                @csrf
                                                                @method('PATCH')
                                                                <div class="modal-body">
                                                                    <p>¿Estás seguro de que deseas activar este horario? Esta acción cambiará su estado a activo.</p>
                                                                    <input type="hidden" id="activar-horario-id" name="id" value="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                    <button type="submit" class="btn btn-success">Activar</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    // Este script se ejecutará cuando el modal se active
                                                    $('#activarHorarioModal').on('show.bs.modal', function (event) {
                                                        var button = $(event.relatedTarget); // El botón que abrió el modal
                                                        var horarioId = button.data('id'); // El ID del horario

                                                        // Actualizar la acción del formulario y el valor oculto con el ID del horario
                                                        var formAction = '{{ route("activar-horario", ":id") }}';
                                                        formAction = formAction.replace(':id', horarioId);
                                                        $('#form-activar-horario').attr('action', formAction);

                                                        // Llenar el campo oculto con el ID del horario
                                                        $('#activar-horario-id').val(horarioId);
                                                    });
                                                </script>

                                            @endif
                                            
                                            <!-- Botones de Eliminar-->
                                            <button 
                                                data-toggle="modal" 
                                                data-target="#eliminarHorarioModal" 
                                                data-id="{{ $horario->id }}" 
                                                class="btn-action eliminar">
                                                Eliminar
                                            </button>
                                            <!-- Modal para confirmar eliminación de horario -->
                                            <div class="modal fade" id="eliminarHorarioModal" tabindex="-1" aria-labelledby="eliminarHorarioModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="eliminarHorarioModalLabel">Confirmar Eliminación</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            ¿Estás seguro de que deseas eliminar este horario?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                            <form id="eliminarHorarioForm" method="POST" action="">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">Eliminar</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <script>
                                                // Al abrir el modal, obtiene el ID del horario y establece la acción del formulario
                                                $('#eliminarHorarioModal').on('show.bs.modal', function (event) {
                                                    var button = $(event.relatedTarget); // Botón que activó el modal
                                                    var horarioId = button.data('id'); // Extrae el ID del horario desde el atributo data-id
                                                    
                                                    // Configura la acción del formulario con el ID del horario
                                                    var action = "{{ route('eliminar-horario', ':id') }}";
                                                    action = action.replace(':id', horarioId);
                                                    $('#eliminarHorarioForm').attr('action', action);
                                                });
                                            </script>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Sección para crear un nuevo horario -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearHorarioModal">
                        Crear Horario de Trabajo
                    </button>
            @else
                <p class="no-horarios-msg">No tienes horarios de trabajo registrados.</p>
                    <!-- Sección para crear un nuevo horario -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearHorarioModal">
                    Crear Horario de Trabajo
                </button>
            @endif
</div>
 
<!-- Servicios -->
<div id="servicios" class="content-section">

    <h3 class="services-title" color="text-black" >Servicios</h3>

    @if ($servicios->isEmpty())
        <p>No hay servicios creados.</p>
        <!-- Botón para abrir el modal -->
        <button type="button" class="btn-create-service" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
            Crear servicio
        </button>
    @else
        <div id="card-serviciosIndividual">
            @foreach ($servicios as $servicio)
                <div class="service-card">
                    <!-- Columna de información -->
                    <div>
                        <h3 class="titulo-servicio" >{{ $servicio->nombre }}</h3>
                        <p class="font-weight-bold">Estado: 
                            <span class="{{ $servicio->estado == 'activo' ? 'text-success' : 'text-danger' }}">
                                {{ ucfirst($servicio->estado) }}
                            </span>
                        </p>
                        <p class="font-weight-bold">Precio: <span class="text-success" >{{ $servicio->precio_base }}</span></p>
                        <p class="font-weight-bold">Calificación: 
                            <span class="text-warning">
                                @if ($servicio->calificacion > 0)
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi {{ $i <= $servicio->calificacion ? 'bi-star-fill' : 'bi-star' }}"></i>
                                    @endfor
                                @else
                                    No calificado
                                @endif
                            </span>
                        </p>
                        <p class="font-weight-bold">Rubros:</p>
                        <ul>
                            @foreach ($servicio->rubros as $rubro)
                                <li>{{ $rubro->nombre }}</li>
                            @endforeach
                        </ul>
                    </div>
    
                    <!-- Columna de acciones -->
                    <div class="service-actions">
                        <button type="button" class="btn-action edit" data-bs-toggle="modal" data-bs-target="#editarServicioModal">Editar</button>
                        
                        @if ($servicio->estado == 'activo')
                            <button type="button" class="btn-action anular" data-bs-toggle="modal" data-bs-target="#anularServicioModal">Anular</button>
                        @else
                            <button type="button" class="btn-action activar" data-bs-toggle="modal" data-bs-target="#activarServicioModal">Activar</button>                        
                        @endif
                        
                        <button type="button" class="btn-action eliminar" data-bs-toggle="modal" data-bs-target="#eliminarServicioModal">Eliminar</button>
                    </div>
                </div>
            @endforeach
        </div>
    
        <!-- Botón para abrir el modal -->
        <button type="button" class="btn-create-service" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
            Crear servicio
        </button>
              
                <!-- Modal para editar un servicio existente -->
                <div class="modal fade" id="editarServicioModal" tabindex="-1" aria-labelledby="editarServicioModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editarServicioModalLabel">Editar Servicio</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('actualizar-servicio', $servicio->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Usamos PUT para indicar una actualización -->
                                <div class="modal-body">
                                    <!-- Nombre -->
                                    <div class="mb-3">
                                        <label for="nombre" class="form-label">Nombre del Servicio</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $servicio->nombre) }}" placeholder="Ingrese el nombre del servicio" required>
                                    </div>

                                    <!-- Rubros -->
                                    <div class="form-group">
                                        <label for="rubros">Selecciona los Rubros</label>
                                        <select id="rubros" name="rubros[]" class="form-control select2" multiple="multiple" style="width: 100%;" required>
                                            @foreach($rubros as $rubro)
                                                <option value="{{ $rubro->id }}" 
                                                    @if(in_array($rubro->id, $servicio->rubros->pluck('id')->toArray())) 
                                                        selected
                                                    @endif
                                                >{{ $rubro->nombre }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Descripción -->
                                    <div class="mb-3">
                                        <label for="descripcion" class="form-label">Descripción</label>
                                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción del servicio">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                                    </div>

                                    <!-- Precio Base -->
                                    <div class="mb-3">
                                        <label for="precio_base" class="form-label">Precio Base</label>
                                        <input type="number" class="form-control" id="precio_base" name="precio_base" step="0.01" value="{{ old('precio_base', $servicio->precio_base) }}" placeholder="Ingrese el precio base" required>
                                    </div>

                                    <!-- Duración Estimada -->
                                    <div class="mb-3">
                                        <label for="duracion_estimada" class="form-label">Duración Estimada</label>
                                        <input type="time" class="form-control" id="duracion_estimada" name="duracion_estimada" value="{{ old('duracion_estimada', $servicio->duracion_estimada) }}" required>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal para anular servicio -->
                <div class="modal fade" id="anularServicioModal" tabindex="-1" aria-labelledby="anularServicioModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="anularServicioModalLabel">Anular Servicio</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('anular-servicio', $servicio->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Usamos PUT para la actualización -->
                                <div class="modal-body">
                                    <p>¿Estás seguro de que deseas anular este servicio? El estado del servicio cambiará a inactivo.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-danger">Anular Servicio</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <<!-- Modal para activar servicio -->
                <div class="modal fade" id="activarServicioModal" tabindex="-1" aria-labelledby="activarServicioModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="activarServicioModalLabel">Activar Servicio</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('activar-servicio', $servicio->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Usamos PUT para la actualización -->
                                <div class="modal-body">
                                    <p>¿Estás seguro de que deseas activar este servicio? El estado del servicio cambiará a activo.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-success">Activar Servicio</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal para eliminar servicio -->
                <div class="modal fade" id="eliminarServicioModal" tabindex="-1" aria-labelledby="eliminarServicioModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="eliminarServicioModalLabel">Eliminar Servicio</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('eliminar-servicio', $servicio->id) }}" method="POST">
                                @csrf
                                @method('DELETE') <!-- Método DELETE para eliminar -->
                                <div class="modal-body">
                                    <p>¿Estás seguro de que deseas eliminar este servicio? Esta acción es irreversible.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-danger">Eliminar Servicio</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        <!-- Modal para crear un nuevo servicio -->
        <div class="modal fade" id="crearServicioModal" tabindex="-1" aria-labelledby="crearServicioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearServicioModalLabel">Crear Servicio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('guardar-servicio') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <!-- Nombre -->
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre del Servicio</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del servicio" required>
                            </div>

                            <!-- Rubros -->
                            <div class="form-group">
                                <label for="rubros">Selecciona los Rubros</label>
                                <select id="rubros" name="rubros[]" class="form-control select2" multiple="multiple" style="width: 100%;" required>
                                    @foreach($rubros as $rubro)
                                        <option value="{{ $rubro->id }}">{{ $rubro->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Descripción -->
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción del servicio"></textarea>
                            </div>
                            
                    

                            <!-- Precio Base -->
                            <div class="mb-3">
                                <label for="precio_base" class="form-label">Precio Base</label>
                                <input type="number" class="form-control" id="precio_base" name="precio_base" step="0.01" placeholder="Ingrese el precio base" required>
                            </div>

                            <!-- Duración Estimada -->
                            <div class="mb-3">
                                <label for="duracion_estimada" class="form-label">Duración Estimada</label>
                                <input type="time" class="form-control" id="duracion_estimada" name="duracion_estimada" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary">Guardar Servicio</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Script de inicialización de Select2 -->
        <script>
            $(document).ready(function() {
                $('#rubros').select2({
                    placeholder: 'Selecciona los rubros',
                    allowClear: true
                });
            });
        </script>
</div>
<!-- Mis citas -->
<div id="citas" class="content-section">
    <h3> MIS CITAS</h3>
    <div class="row">
        <div class="col-md-12">
                <div class="card-body">
                    @if ($citas->isEmpty())

                        <p class="text-center">No tienes citas agendadas.</p>
                    @else
                        <table class="table horarios-table table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Servicio</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($citas as $cita)
                                        <tr>
                                            <td>{{$cita->persona->nombre . ' ' . $cita->persona->apellido}}
                                                <a href="#" data-toggle="modal" data-target="#clienteModal{{ $cita->persona->id }}" style="color: #007bff; text-decoration: none;">
                                                       Ver detalle
                                                </a>
                                                <!-- Modal para mostrar los datos del cliente -->
                                                <div class="modal fade" id="clienteModal{{ $cita->persona->id }}" tabindex="-1" role="dialog" aria-labelledby="clienteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="clienteModalLabel">Datos del Cliente</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Nombre:</strong> {{ $cita->persona->nombre }} {{ $cita->persona->apellido }}</p>
                                                                <p><strong>Email:</strong> {{ $cita->persona->user->email }}</p>
                                                                <p><strong>Teléfono:</strong> {{ $cita->persona->telefono }}</p>
                                                                <p><strong>Dirección:</strong> {{ $cita->persona->domicilio }}</p>
                                                                @if ($cita->persona->calificacion == 0.0)
                                                                    <p><strong>Calificación:</strong> No calificado</p>
                                                                @else
                                                                    <p><strong>Calificación:</strong> {{ $cita->persona->calificacion }}</p>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $cita->servicio->nombre }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cita->horaInicio)->format('H:i') }}</td>
                                            <td>
                                                @if ($cita->estado === 0)
                                                    <span class="badge badge-warning">Pendiente</span>
                                                    </span>
                                                @elseif ($cita->estado === 1)
                                                    <span class="badge badge-success">Confirmada</span>
                                                @elseif ($cita->estado === 2)
                                                    <span class="badge badge-danger">Cancelada</span>
                                                @elseif ($cita->estado === 3)
                                                    <span class="badge badge-success"><strong>Re-confirmada</strong></span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($cita->estado === 0)

                                                    <!-- Botón que abre el modal de confirmar cita -->
                                                    <button type="button" class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#confirmCitaModal{{ $cita->idCita }}">
                                                        Confirmar Cita
                                                    </button>
                                                    <style> 
                                                        .btn-modern {
                                                            font-size: 10px; /* Tamaño de texto pequeño */
                                                            padding: 6px 12px; /* Ajusta el espacio interno */
                                                            border: none; /* Elimina bordes predeterminados */
                                                            border-radius: 5px; /* Esquinas redondeadas */
                                                            background: linear-gradient(135deg, #4CAF50, #2E7D32); /* Gradiente moderno */
                                                            color: #fff; /* Texto blanco */
                                                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra sutil */
                                                            transition: all 0.3s ease; /* Animación suave */
                                                            cursor: pointer; /* Cambia el cursor al pasar el ratón */
                                                            margin-bottom: 10px;
                                                        }
                                                        .btn-modern1 {
                                                            font-size: 10px; /* Tamaño de texto pequeño */
                                                            padding: 6px 12px; /* Ajusta el espacio interno */
                                                            border: none; /* Elimina bordes predeterminados */
                                                            border-radius: 5px; /* Esquinas redondeadas */
                                                            background: linear-gradient(135deg, #c82333, #dc3545); /* Gradiente moderno */
                                                            color: #fff; /* Texto blanco */
                                                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra sutil */
                                                            transition: all 0.3s ease; /* Animación suave */
                                                            cursor: pointer; /* Cambia el cursor al pasar el ratón */
                                                        }

                                                    </style>   
                                                    <!-- Modal de confirmacion -->
                                                    <div class="modal fade" id="confirmCitaModal{{ $cita->idCita }}" tabindex="-1" aria-labelledby="confirmCitaModalLabel{{ $cita->idCita }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="confirmCitaModalLabel{{ $cita->idCita }}">Confirmar Cita</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    ¿Estás seguro de que deseas confirmar esta cita?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                    <!-- Formulario para confirmar la cita -->
                                                                    <form action="{{ route('confirmar-cita') }}" method="POST" style="display: inline;">
                                                                        @csrf
                                                                        <input type="hidden" name="citaId" value="{{ $cita->idCita }}">
                                                                        <button type="submit" class="btn btn-success">Confirmar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Botón que abre el modal de cancelar cita -->
                                                    <button type="button" class="btn btn-modern1" data-bs-toggle="modal" data-bs-target="#cancelCitaModal{{ $cita->idCita }}">
                                                        Rechazar cita
                                                    </button>
                                                    <!-- Modal de rechazo cita -->
                                                    <div class="modal fade" id="cancelCitaModal{{ $cita->idCita }}" tabindex="-1" aria-labelledby="cancelCitaModalLabel{{ $cita->idCita }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="cancelCitaModalLabel{{ $cita->idCita }}">Confirmar Cita</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    ¿Estás seguro de que deseas Rechazar esta cita?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                    <!-- Formulario para confirmar la cita -->
                                                                    <form action="{{ route('cancelar-cita') }}" method="POST" style="display: inline;">
                                                                        @csrf
                                                                        <input type="hidden" name="citaId" value="{{ $cita->idCita }}">
                                                                        <button type="submit" class="btn btn-success">Confirmar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @elseif ($cita->estado == 1)
                                                    <!-- Botón que abre el modal de cancelar cita -->
                                                    <button type="button" class="btn btn-modern1" data-bs-toggle="modal" data-bs-target="#cancelCitaModal{{ $cita->idCita }}">
                                                        Rechazar cita
                                                    </button>
                                                    <style> 
                                                        .btn-modern {
                                                            font-size: 10px; /* Tamaño de texto pequeño */
                                                            padding: 6px 12px; /* Ajusta el espacio interno */
                                                            border: none; /* Elimina bordes predeterminados */
                                                            border-radius: 5px; /* Esquinas redondeadas */
                                                            background: linear-gradient(135deg, #4CAF50, #2E7D32); /* Gradiente moderno */
                                                            color: #fff; /* Texto blanco */
                                                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra sutil */
                                                            transition: all 0.3s ease; /* Animación suave */
                                                            cursor: pointer; /* Cambia el cursor al pasar el ratón */
                                                            margin-bottom: 10px;
                                                        }
                                                        .btn-modern1 {
                                                            font-size: 10px; /* Tamaño de texto pequeño */
                                                            padding: 6px 12px; /* Ajusta el espacio interno */
                                                            border: none; /* Elimina bordes predeterminados */
                                                            border-radius: 5px; /* Esquinas redondeadas */
                                                            background: linear-gradient(135deg, #c82333, #dc3545); /* Gradiente moderno */
                                                            color: #fff; /* Texto blanco */
                                                            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra sutil */
                                                            transition: all 0.3s ease; /* Animación suave */
                                                            cursor: pointer; /* Cambia el cursor al pasar el ratón */
                                                        }

                                                    </style> 
                                                    <!-- Modal de rechazo cita -->
                                                    <div class="modal fade" id="cancelCitaModal{{ $cita->idCita }}" tabindex="-1" aria-labelledby="cancelCitaModalLabel{{ $cita->idCita }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="cancelCitaModalLabel{{ $cita->idCita }}">Confirmar Cita</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    ¿Estás seguro de que deseas Rechazar esta cita?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                    <!-- Formulario para confirmar la cita -->
                                                                    <form action="{{ route('cancelar-cita') }}" method="POST" style="display: inline;">
                                                                        @csrf
                                                                        <input type="hidden" name="citaId" value="{{ $cita->idCita }}">
                                                                        <button type="submit" class="btn btn-success">Confirmar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                           </td>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
    </div>
</div>

    <!-- Agenda -->
    <div id="agenda" class="content-section">
        <h3>Agenda</h3>
        <p>Aquí puedes gestionar los turnos de la empresa.</p>
    </div>

    <!-- Informes -->
    <div id="informes" class="content-section d-none">
        <h3>Informes</h3>
        <p>Generación y revisión de informes.</p>
    </div>

    <!-- Caja -->
    <div id="caja" class="content-section d-none">
        <h3>Caja</h3>
        <p>Administración de ingresos y egresos de la caja.</p>
    </div>

@endsection

<!-- Script para mostrar la sección activa en la barra de navegación -->
<script>
    function showSection(sectionId) {
        document.querySelectorAll('.content-section').forEach((section) => {
            section.classList.add('d-none');
        });
        document.querySelectorAll('.nav-button').forEach((button) => {
            button.classList.remove('active-tab');
        });
        document.getElementById(sectionId).classList.remove('d-none');
        document.querySelector(`.nav-button[onclick="showSection('${sectionId}')"]`).classList.add('active-tab');
    }
</script>

<!-- Script para alerta con mensaje de exitos o error-->
<script>
    document.getElementById('form-actualizar').addEventListener('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: data.success,
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
            } else if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.error,
                    timer: 2000,
                    showConfirmButton: false,
                    position: 'top-end',
                    toast: true
                });
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>

<!-- Estilos adicionales (Opcional) -->
<style>
    .section {
        padding: 30px 0;
        border-bottom: 1px solid #ccc;
    }

    .section:last-child {
        border-bottom: none;
    }

    /* Opcional: resaltar la sección activa */
    .active {
        background-color: #f1f1f1;
    }
</style>

<!-- Script para cambiar de sección -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.section');  // Obtener todas las secciones
        const navLinks = document.querySelectorAll('.navbar-nav .nav-link');  // Obtener todos los enlaces de navegación

        // Función para ocultar todas las secciones
        function hideSections() {
            sections.forEach(section => {
                section.style.display = 'none';
            });
        }

        // Mostrar la sección seleccionada y ocultar las demás
        function showSection(sectionId) {
            hideSections();
            const selectedSection = document.getElementById(sectionId);
            if (selectedSection) {
                selectedSection.style.display = 'block';
            }
        }

        // Agregar un evento de click a cada enlace de la barra de navegación
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();  // Prevenir el comportamiento por defecto (scroll)
                const targetId = link.getAttribute('href').substring(1);  // Obtener el id de la sección destino
                showSection(targetId);  // Mostrar la sección correspondiente
                // Resaltar el enlace activo
                navLinks.forEach(navLink => navLink.classList.remove('active'));
                link.classList.add('active');
            });
        });

        // Mostrar la primera sección al cargar la página
        showSection('datos');
    });
</script>

