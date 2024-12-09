@extends('layouts.miservicioIn')

@section('titulo', 'Gestión de servicio')

@section('contenido')

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark">
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
                    <a class="nav-link" onclick="showSection('horarios')"><i class='bx bxs-time'></i> Horarios Atención</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="showSection('servicios')"><i class='bx bx-donate-blood'></i> Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" onclick="showSection('citas')"><i class='bx bx-list-check'></i> Mis citas</a>
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
<style>
    .nav-link.active {
        color: #ff00cc;
        font-weight: bold;
        border-bottom: 2px solid #333399;
        
    }
</style>
<script>
    // Función para mostrar solo la sección activa
    function showSection(sectionId) {
        // Ocultar todas las secciones
        const sections = document.querySelectorAll('.section');
        sections.forEach(section => {
            section.style.display = 'none';
        });

        // Mostrar la sección activa
        const activeSection = document.getElementById(sectionId);
        if (activeSection) {
            activeSection.style.display = 'block';
        }

        // Actualizar el enlace activo
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.classList.remove('active');
        });
        const activeLink = document.querySelector(`.nav-link[onclick="showSection('${sectionId}')"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }

        // Guardar la sección activa en localStorage
        localStorage.setItem('activeSection', sectionId);
    }

    // Mostrar la sección activa al cargar la página
    document.addEventListener('DOMContentLoaded', () => {
        // Obtener la sección activa de localStorage o mostrar la sección principal por defecto
        const savedSection = localStorage.getItem('activeSection') || 'datos';
        showSection(savedSection);
    });

</script>

<!-- Contenido de las secciones -->

<!-- Sección: Datos Profesionales -->
<div id="datos" class="section" style="display: block;">
    @if($datosProfesion)
        <div id="datos-profesionales">
            <form action="{{ route('actualizar-datos', $datosProfesion->id) }}" method="POST" class="p-4">
                @csrf
                @method('PUT')
            
                <h3 class="text-uppercase font-weight-bold text-dark mb-4">Datos Profesionales</h3>
                
                <!-- Sección: Nombre -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="nombre_fantasia" class="form-label">Nombre Fantasía</label>
                        <input type="text" class="form-control" id="nombre_fantasia" name="nombre_fantasia" 
                            value="{{ $datosProfesion->nombre_fantasia }}" disabled>
                    </div>
                    <div class="col-md-6">
                        <label for="slogan" class="form-label">Slogan</label>
                        <input type="text" class="form-control" id="slogan" name="slogan" 
                            value="{{ $datosProfesion->slogan }}">
                    </div>
                </div>
            
                <!-- Sección: Ubicación y Contacto -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" 
                            value="{{ $datosProfesion->ubicacion }}" required>
                    </div>
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" 
                            value="{{ $datosProfesion->telefono }}">
                    </div>
                </div>
            
                <!-- Sección: Otros datos -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="experiencia" class="form-label">Experiencia</label>
                        <input type="number" id="experiencia" name="experiencia" class="form-control" 
                            min="0" step="1" placeholder="Ingrese la experiencia" required value="{{$datosProfesion->experiencia}}">
                    </div>
                    <div class="col-md-4">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="1" {{ $datosProfesion->estado == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $datosProfesion->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="calificacion" class="form-label">Calificación</label>
                        <div class="form-control-plaintext">
                            {{ $promedio }} 
                        </div>
                    </div>
                </div>
            
                <!-- Botón para actualizar -->
                <button type="button" class="btn btn-success w-100 mt-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmUpdateModal">
                    Actualizar Datos
                </button>
            
                <!-- Modal para confirmar actualización -->
                <div class="modal fade" id="confirmUpdateModal" tabindex="-1" aria-labelledby="confirmUpdateModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmUpdateModalLabel">Confirmación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas actualizar los datos?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @else
        <div id="datos-profesionales">
            <!-- Si no existen los datos, mostramos los campos vacíos para crear los datos -->
            <form action="{{ route('guardar-datos') }}" method="POST" class="p-4">
                @csrf
            
                <h3 class="text-uppercase font-weight-bold text-dark mb-4">Datos Profesionales</h3>
                
                <!-- Sección: Nombre -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="nombre_fantasia" class="form-label">Nombre Fantasía</label>
                        <input type="text" class="form-control" id="nombre_fantasia" name="nombre_fantasia" required>
                    </div>
                    <div class="col-md-6">
                        <label for="slogan" class="form-label">Slogan</label>
                        <input type="text" class="form-control" id="slogan" name="slogan">
                    </div>
                </div>
            
                <!-- Sección: Ubicación y Contacto -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="ubicacion" class="form-label">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                    </div>
                    <div class="col-md-6">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono">
                    </div>
                </div>
            
                <!-- Sección: Otros datos -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="experiencia" class="form-label">Experiencia</label>
                        <input type="number" id="experiencia" name="experiencia" class="form-control" 
                            min="0" step="1" placeholder="Ingrese la experiencia" required>
                    </div>
                </div>
            
                <!-- Botón para guardar -->
                <button type="button" class="btn btn-success w-100 mt-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#confirmSaveModal">
                    Guardar Datos
                </button>
            
                <!-- Modal para confirmar guardado -->
                <div class="modal fade" id="confirmSaveModal" tabindex="-1" aria-labelledby="confirmSaveModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmSaveModalLabel">Confirmación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas guardar los datos?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-success">Confirmar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    @endif
    <script>
        // Este script asegura que el modal se cierre correctamente y realice una acción adicional si es necesario
        const confirmUpdateModal = document.getElementById('confirmUpdateModal');
        const confirmSaveModal = document.getElementById('confirmSaveModal');

        // Opcional: agregar comportamiento personalizado a los modales
        $('#confirmUpdateModal').on('shown.bs.modal', function () {
            // Acción personalizada cuando el modal se muestre
        });
        
        $('#confirmSaveModal').on('shown.bs.modal', function () {
            // Acción personalizada cuando el modal se muestre
        });
    </script>
    <style>
        #datos-profesionales {
            background: linear-gradient(135deg, #ffffff, #f0f0f5);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        #datos-profesionales h3 {
            color: #4a4a4a;
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        #datos-profesionales label {
            font-weight: bold;
            font-size: 0.9rem;
            color: #555555;
        }

        #datos-profesionales input, 
        #datos-profesionales select {
            border: 1px solid #dcdcdc;
            border-radius: 4px;
            padding: 10px;
            transition: all 0.3s;
        }

        #datos-profesionales input:focus, 
       

        #datos-profesionales .btn-success {
            background: linear-gradient(90deg, #ff00cc, #333399);
            font-size: 1rem;
            font-weight: bold;
        }


        #datos-profesionales .form-control-plaintext {
            color: #4a4a4a;
            font-weight: bold;
        }

        .modal-header, .modal-footer {
            border: none;
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .modal-footer .btn-success {
            width: 100%;
        }

    </style>
</div>
    
<div id="horarios" class="section" style="display: none;">
    <!-- Modal para Crear Horario -->
    <div class="modal fade" id="crearHorarioModal" tabindex="-1" aria-labelledby="crearHorarioModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="crearHorarioModalLabel">Crear Horario de Trabajo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario -->
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
    
                        <!-- Día -->
                        <div class="mb-3">
                            <label for="dia_id" class="form-label">Día</label>
                            <select name="dia_id" id="dia_id" class="form-control" required>
                                @foreach($dias as $dia)
                                    <option value="{{ $dia->id }}">{{ $dia->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
    
                        <!-- Horarios -->
                        <div class="mb-3">
                            <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                            <input type="time" name="hora_inicio" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora_fin" class="form-label">Hora de Fin</label>
                            <input type="time" name="hora_fin" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="hora_inicio1" class="form-label">Hora de Inicio (segunda franja)</label>
                            <input type="time" name="hora_inicio1" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="hora_fin1" class="form-label">Hora de Fin (segunda franja)</label>
                            <input type="time" name="hora_fin1" class="form-control">
                        </div>
    
                        <!-- Botón de envío -->
                        <button type="submit" class="btn btn-success w-100 mt-3 shadow-sm">Crear Horario</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id= "horarios">
        <!-- Mostrar los horarios ya creados -->
        @if($horariosTrabajo && $horariosTrabajo->isNotEmpty())
            <h3 class="text-uppercase font-weight-bold text-dark mb-4">Horarios de atención</h3>
            <table class="horarios-table">
                <thead>
                    <tr>
                        <th>Día</th>
                        <th>Hora de Inicio</th>
                        <th>Hora de Fin</th>
                        <th>Inicio Segundo Horario</th>
                        <th>Fin Segundo Horario</th>
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
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editarHorarioModal" 
                                        data-id="{{ $horario->id }}"
                                        data-hora_inicio="{{ $horario->hora_inicio }}"
                                        data-hora_fin="{{ $horario->hora_fin }}"
                                        data-hora_inicio1="{{ $horario->hora_inicio1 }}"
                                        data-hora_fin1="{{ $horario->hora_fin1 }}"
                                        class="btn-action edit">Editar
                                    </button>
                            
                                    <!-- Modal para editar el horario -->
                                    <div class="modal fade" id="editarHorarioModal" tabindex="-1" aria-labelledby="editarHorarioModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarHorarioModalLabel">Editar Horario</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('actualizar-horario', ':id') }}" method="POST" id="form-editar-horario">
                                                    @csrf
                                                    @method('PATCH')
                                                    <!-- Horarios -->
                                                    <div class="mb-3">
                                                        <label for="hora_inicio" class="form-label">Hora de Inicio</label>
                                                        <input type="time" name="hora_inicio" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="hora_fin" class="form-label">Hora de Fin</label>
                                                        <input type="time" name="hora_fin" class="form-control" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="hora_inicio1" class="form-label">Hora de Inicio (segunda franja)</label>
                                                        <input type="time" name="hora_inicio1" class="form-control">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="hora_fin1" class="form-label">Hora de Fin (segunda franja)</label>
                                                        <input type="time" name="hora_fin1" class="form-control">
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        // Configuración del modal de edición
                                        document.getElementById('editarHorarioModal').addEventListener('show.bs.modal', function (event) {
                                            var button = event.relatedTarget; // Botón que disparó el modal
                                            var horarioId = button.getAttribute('data-id');
                                            var horaInicio = button.getAttribute('data-hora_inicio');
                                            var horaFin = button.getAttribute('data-hora_fin');
                                            var horaInicio1 = button.getAttribute('data-hora_inicio1');
                                            var horaFin1 = button.getAttribute('data-hora_fin1');

                                            // Actualizar los valores del formulario
                                            var formEditarHorario = document.getElementById('form-editar-horario');
                                            formEditarHorario.action = '{{ route("actualizar-horario", ":id") }}'.replace(':id', horarioId);
                                            document.getElementById('horario-id-editar').value = horarioId;
                                            document.getElementById('hora_inicio_editar').value = horaInicio;
                                            document.getElementById('hora_fin_editar').value = horaFin;
                                            document.getElementById('hora_inicio1_editar').value = horaInicio1;
                                            document.getElementById('hora_fin1_editar').value = horaFin1;
                                        });

                                    </script>
                                    
                                    <!-- Botón de Anular/Activar -->
                                    @if ($horario->estado == 1)
                                        <!-- Botón de Anular -->
                                        <button 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#anularHorarioModal" 
                                            data-id="{{ $horario->id }}" 
                                            class="btn-action anular">Anular
                                        </button>
                                        <!-- Modal para anular el horario -->
                                        <div class="modal fade" id="anularHorarioModal" tabindex="-1" aria-labelledby="anularHorarioModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="anularHorarioModalLabel">Anular Horario</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <form action="{{ route('anular-horario', ':id') }}" method="POST" id="form-anular-horario">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <p>¿Estás seguro de que deseas anular este horario? Esta acción cambiará su estado a inactivo.</p>
                                                            <input type="hidden" id="horario-id" name="id" value="">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-danger">Anular</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.getElementById('anularHorarioModal').addEventListener('show.bs.modal', function (event) {
                                                var button = event.relatedTarget; // Botón que abre el modal
                                                var horarioId = button.getAttribute('data-id'); // Obtener ID del horario

                                                // Actualizar el action del formulario y el input oculto
                                                var formAction = '{{ route("anular-horario", ":id") }}'.replace(':id', horarioId);
                                                document.getElementById('form-anular-horario').setAttribute('action', formAction);
                                                document.getElementById('horario-id').value = horarioId;
                                            });
                                        </script>
                                    @else
                                        <!-- Botón de Activar -->
                                        <button 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#activarHorarioModal" 
                                            data-id="{{ $horario->id }}" 
                                            class="btn-action activar">Activar
                                        </button>

                                        <!-- Modal para activar el horario -->
                                        <div class="modal fade" id="activarHorarioModal" tabindex="-1" aria-labelledby="activarHorarioModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="activarHorarioModalLabel">Activar Horario</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                    </div>
                                                    <form action="{{ route('activar-horario', ':id') }}" method="POST" id="form-activar-horario">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <p>¿Estás seguro de que deseas activar este horario? Esta acción cambiará su estado a activo.</p>
                                                            <input type="hidden" id="activar-horario-id" name="id" value="">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            <button type="submit" class="btn btn-success">Activar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            document.getElementById('activarHorarioModal').addEventListener('show.bs.modal', function (event) {
                                                var button = event.relatedTarget; // Botón que abre el modal
                                                var horarioId = button.getAttribute('data-id'); // Obtener ID del horario

                                                // Actualizar el action del formulario y el input oculto
                                                var formAction = '{{ route("activar-horario", ":id") }}'.replace(':id', horarioId);
                                                document.getElementById('form-activar-horario').setAttribute('action', formAction);
                                                document.getElementById('activar-horario-id').value = horarioId;
                                            });
                                        </script>
                                    @endif

                                    <!-- Botones de Eliminar -->
                                    <button 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#eliminarHorarioModal" 
                                        data-id="{{ $horario->id }}" 
                                        class="btn-action eliminar">Eliminar
                                    </button>
                                    <!-- Modal para confirmar eliminación de horario -->
                                    <div class="modal fade" id="eliminarHorarioModal" tabindex="-1" aria-labelledby="eliminarHorarioModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="eliminarHorarioModalLabel">Confirmar Eliminación</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que deseas eliminar este horario?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
                                        document.getElementById('eliminarHorarioModal').addEventListener('show.bs.modal', function (event) {
                                            var button = event.relatedTarget; // Botón que activó el modal
                                            var horarioId = button.getAttribute('data-id'); // Extrae el ID del horario desde el atributo data-id
                                            
                                            // Configura la acción del formulario con el ID del horario
                                            var action = "{{ route('eliminar-horario', ':id') }}";
                                            action = action.replace(':id', horarioId);
                                            document.getElementById('eliminarHorarioForm').setAttribute('action', action);
                                        });
                                    </script>
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Sección para crear un nuevo horario -->
            <button type="button" class="btn btn-success w-100 mt-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#crearHorarioModal">
                Crear Horario de Trabajo
            </button>
        @else
            <p class="no-horarios-msg">No tienes horarios de trabajo registrados.</p>
            <!-- Sección para crear un nuevo horario -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearHorarioModal">
                Crear Horario de Trabajo
            </button>
        @endif
    </div>
    <style>
        #horarios {
            background: linear-gradient(135deg, #ffffff, #f0f0f5);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        #horarios h3 {
            color: #4a4a4a;
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        .horarios-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .horarios-table th, .horarios-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .horarios-table th {
            background-color: #f0f0f5;
            color: #333;
            font-weight: bold;
        }

        .horarios-table tr:hover {
            background-color: #f9f9f9;
        }

        .horarios-table td {
            font-size: 0.9rem;
            color: #555;
        }

        .btn-action {
            font-size: 0.875rem;
            font-weight: bold;
            padding: 6px 12px;
        }

        .btn-warning {
            background-color: #f0ad4e;
            color: white;
        }

        .btn-warning:hover {
            background-color: #ec971f;
        }

        .btn-danger {
            background-color: #d9534f;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c9302c;
        }

        .btn-success {
            background: linear-gradient(90deg, #ff00cc, #333399);
            color: white;
            font-size: 1rem;
            font-weight: bold;
        }

        .modal-content {
            border-radius: 10px;
        }

        .modal-header, .modal-footer {
            border: none;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .modal-footer .btn-success {
            width: 100%;
        }

        .form-label {
            font-weight: bold;
            color: #555555;
        }

        input[type="time"], .form-control {
            border: 1px solid #dcdcdc;
            border-radius: 4px;
            padding: 10px;
            transition: all 0.3s;
        }

        input:focus, .form-control:focus {
            border-color: #333399;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer button {
            font-size: 1rem;
        }

        @media (max-width: 768px) {
            .horarios-table th, .horarios-table td {
                font-size: 0.8rem;
            }
        }
        /* Estilos para los botones de Editar, Anular y Eliminar */
        .btn-action {
            font-weight: bold;
            font-size: 10px;  
            padding: 5px 10px;
            text-transform: uppercase;
            padding: 10px 20px;
            border-radius: 5px;
            transition: all 0.3s ease-in-out;
            border: none;
        }

        .btn-action.edit {
            background: linear-gradient(90deg, #ffcc00, #ff9900); /* Estilo para el botón de editar */
            color: #fff;
        }


        .btn-action.anular {
            background: linear-gradient(90deg, #333399, #333350); /* Estilo para el botón de anular */
            color: #fff;
        }

        .btn-action.activar {
            background: linear-gradient(90deg, #218838, #28a745); /* Estilo para el botón de anular */
            color: #fff;
        }

     

        .btn-action.eliminar {
            background: linear-gradient(90deg, #cc0000, #c9302c); /* Estilo para el botón de eliminar */
            color: #fff;
        }

        .btn-action.inactive {
            background: linear-gradient(90deg, #6c757d, #5a6268); /* Estilo para el botón de desactivar */
            color: #fff;
        }

        .btn-action.inactive:hover {
            background: linear-gradient(90deg, #5a6268, #6c757d); /* Efecto hover */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }


    </style>
</div>

<div id="servicios" class="section" style="display: none;">
    <div id="servicios">
        <h3 class="text-uppercase font-weight-bold text-dark mb-4" >Servicios</h3>
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
                        </div>
        
                        <!-- Columna de acciones -->
                        <div class="service-actions">
                            <!-- Editar servicio-->
                            <button type="button" class="btn-action edit" data-bs-toggle="modal" data-bs-target="#editarServicioModal">Editar</button>
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

                            <!-- Anular o activar servicio-->
                            @if ($servicio->estado == 'activo')
                                <button type="button" class="btn-action anular" data-bs-toggle="modal" data-bs-target="#anularServicioModal">Anular</button>
                            @else
                                <button type="button" class="btn-action activar" data-bs-toggle="modal" data-bs-target="#activarServicioModal">Activar</button>                        
                            @endif
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
                            <!-- Modal para activar servicio -->
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

                            <!-- Eliminar servicio-->
                            <button type="button" class="btn-action eliminar" data-bs-toggle="modal" data-bs-target="#eliminarServicioModal">Eliminar</button>
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
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        <!-- Botón para crear un nuevo servicio -->
        <button type="button" class="btn btn-success w-100 mt-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
            Crear Servicio
        </button>
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
    </div>
    <style>
        /* Estilo para el contenedor de servicios */
        #servicios {
            background: linear-gradient(135deg, #f0f0f5, #ffffff);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        #servicios h3 {
            color: #4a4a4a;
            text-align: center;
            border-bottom: 2px solid black;
            padding-bottom: 10px;
        }

        /* Estilo para cuando no hay servicios */
        #servicios p {
            font-size: 1rem;
            text-align: center;
            color: #777;
        }

        /* Estilo para el botón Crear servicio */
        .btn-create-service {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-create-service:hover {
            background-color: #218838;
        }

        /* Estilo para las tarjetas de servicio */
        #card-serviciosIndividual {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .service-card {
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 300px;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }

        .service-card h3.titulo-servicio {
            color: #333;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Estilo para la columna de información */
        .service-card p {
            font-size: 0.9rem;
            margin-bottom: 8px;
        }

        .service-card ul {
            list-style-type: none;
            padding-left: 0;
        }

        .service-card li {
            font-size: 0.9rem;
            color: #555;
        }

        .service-card .text-success {
            color: #28a745;
        }

        .service-card .text-danger {
            color: #dc3545;
        }

        .service-card .text-warning {
            color: #ffc107;
        }

        .service-card .bi-star-fill {
            color: #ffc107;
        }

        .service-card .bi-star {
            color: #e0e0e0;
        }

        /* Estilo para la columna de acciones */
        .service-actions {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-top: 20px;
        }

        .service-actions button {
            font-size: 0.875rem;
            padding: 6px 12px;
            border-radius: 5px;
            text-transform: uppercase;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .service-actions .btn-action {
            width: 100%;
        }

        /* Estilos específicos para los botones de acción */
        .btn-action.edit {
            background: linear-gradient(90deg, #ffcc00, #ff9900);
            color: #fff;
        }

        .btn-action.edit:hover {
            background: linear-gradient(90deg, #ff9900, #ffcc00);
        }

        .btn-action.anular {
            background: linear-gradient(90deg, #333399, #333350);
            color: #fff;
        }

        .btn-action.anular:hover {
            background: linear-gradient(90deg, #333350, #333399);
        }

        .btn-action.activar {
            background: linear-gradient(90deg, #218838, #28a745);
            color: #fff;
        }

        .btn-action.activar:hover {
            background: linear-gradient(90deg, #28a745, #218838);
        }

        .btn-action.eliminar {
            background: linear-gradient(90deg, #cc0000, #c9302c);
            color: #fff;
        }

        .btn-action.eliminar:hover {
            background: linear-gradient(90deg, #c9302c, #cc0000);
        }

    </style>
</div>

<div id="citas" class="section" style="display: none;">
    <h1>Mis Citas</h1>
    <p>Contenido de la sección Mis Citas.</p>
</div>
<div id="agenda" class="section" style="display: none;">
    <h1>Agenda</h1>
    <p>Contenido de la sección Agenda.</p>
</div>
<div id="informes" class="section" style="display: none;">
    <h1>Informes</h1>
    <p>Contenido de la sección Informes.</p>
</div>
<div id="caja" class="section" style="display: none;">
    <h1>Caja</h1>
    <p>Contenido de la sección Caja.</p>
</div>


@endsection
