@extends('layouts.miservicioIn')

@section('titulo', 'MiServicio | Gestión de Servicios')

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
                    <a class="nav-link" onclick="showSection('caja')"><i class='bx bx-dollar'></i> Caja</a>
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
            
                <h3 class="text-uppercase font-weight-bold text-white mb-4">Datos Profesionales</h3>
                
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
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-control" id="estado" name="estado">
                            <option value="1" {{ $datosProfesion->estado == 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $datosProfesion->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="calificacion" class="form-label">Experiencia</label>
                        <div class="form-control-plaintext">
                            {{ $datosProfesion->experiencia }} 
                        </div>
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
            
                <h3 text-white class="text-uppercase font-weight-bold text-dark mb-4">Datos Profesionales</h3>
                
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
            background: #222;
            border-radius: 8px;
            padding: 20px;
            color: #ccc;
        }
    
        #datos-profesionales h3 {
            color: #fff;
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }
    
        #datos-profesionales label {
            font-weight: bold;
            font-size: 0.9rem;
            color: #ccc;
        }
    
        #datos-profesionales input, 
        #datos-profesionales select {
            border: 1px solid #555;
            border-radius: 4px;
            padding: 10px;
            background-color: #444;
            color: #ccc;
            transition: all 0.3s;
        }
    
        #datos-profesionales input:focus, 
        #datos-profesionales select:focus {
            border-color: #333399;
            background-color: #333;
        }
    
        #datos-profesionales .btn-success {
            background: linear-gradient(90deg, #ff00cc, #333399);
            color: white;
            font-size: 1rem;
            font-weight: bold;
        }
    
        #datos-profesionales .form-control-plaintext {
            color: #fff;
            font-weight: bold;
        }
    
        .modal-header, .modal-footer {
            border: none;
        }
    
        .modal-content {
            border-radius: 10px;
            background-color: #333;
            color: #ccc;
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
            <h3 class="text-uppercase font-weight-bold text-white mb-4">Horarios de atención</h3>
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
                                        class="btn-action edit"><i class="bx bx-edit" style="font-size: 20px;"></i>
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
                                            class="btn-action anular"><i class='bx bx-x' style="font-size: 20px;"></i>
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
                                            class="btn-action activar"><i class='bx bx-check' style="font-size: 20px;"></i>
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
                                        class="btn-action eliminar"><i class='bx bx-trash' style="font-size: 20px;"></i>
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
            background: #222;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
            color: #ccc;
        }
    
        #horarios h3 {
            color: #fff;
            text-align: center;
            border-bottom: 2px solid #444;
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
            border-bottom: 1px solid #444;
        }
    
        .horarios-table th {
            background-color: #333;
            color: #fff;
            font-weight: bold;
        }
    
        .horarios-table tr:hover {
            background-color: #444;
        }
    
        .horarios-table td {
            font-size: 0.9rem;
            color: #bbb;
        }
    
        .btn-action {
            font-size: 0.875rem;
            font-weight: bold;
            padding: 6px 12px;
        }
    
        .btn-warning {
            background-color: #ffcc00;
            color: black;
        }
    
        .btn-warning:hover {
            background-color: #e6b800;
        }
    
        .btn-danger {
            background-color: #c9302c;
            color: white;
        }
    
        .btn-danger:hover {
            background-color: #a8231d;
        }
    
        .btn-success {
            background: linear-gradient(90deg, #ff00cc, #333399);
            color: white;
            font-size: 1rem;
            font-weight: bold;
        }
    
        .modal-content {
            border-radius: 10px;
            background: #333;
            color: #ccc;
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
            color: #ccc;
        }
    
        input[type="time"], .form-control {
            border: 1px solid #555;
            border-radius: 4px;
            padding: 10px;
            background-color: #444;
            color: #ccc;
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
            color: #333;
        }
    
        .btn-action.anular {
            background: linear-gradient(90deg, #333399, #333350); /* Estilo para el botón de anular */
            color: #fff;
        }
    
        .btn-action.activar {
            background: linear-gradient(90deg, #218838, #28a745); /* Estilo para el botón de activar */
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }
    </style>
    
</div>

<div id="servicios" class="section" style="display: none;">
    <div id="servicios">
        <h3 class="text-uppercase font-weight-bold text-white mb-4" >Servicios</h3>
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
                        <button type="button" class="btn-action edit" data-bs-toggle="modal" data-bs-target="#editarServicioModal{{ $servicio->id }}">
                            <i class="bx bx-edit" style="font-size: 20px;"></i>
                        </button>
        
                        <!-- Modal para editar un servicio existente -->
                        <div class="modal fade" id="editarServicioModal{{ $servicio->id }}" tabindex="-1" aria-labelledby="editarServicioModalLabel{{ $servicio->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editarServicioModalLabel{{ $servicio->id }}">Editar Servicio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('actualizar-servicio', $servicio->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
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
                            <button type="button" class="btn-action anular" data-bs-toggle="modal" data-bs-target="#anularServicioModal{{ $servicio->id }}">
                                <i class='bx bx-x' style="font-size: 20px;"></i>
                            </button>
                             <!-- Modal para anular servicio -->
                            <div class="modal fade" id="anularServicioModal{{ $servicio->id }}" tabindex="-1" aria-labelledby="anularServicioModalLabel{{ $servicio->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="anularServicioModalLabel{{ $servicio->id }}">Anular Servicio</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('anular-servicio', $servicio->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
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
                        @else
                            <button type="button" class="btn-action activar" data-bs-toggle="modal" data-bs-target="#activarServicioModal{{ $servicio->id }}">
                                <i class='bx bx-check' style="font-size: 20px;"></i>
                            </button>   
                            <!-- Modal para activar servicio -->
                            <div class="modal fade" id="activarServicioModal{{ $servicio->id }}" tabindex="-1" aria-labelledby="activarServicioModalLabel{{ $servicio->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="activarServicioModalLabel{{ $servicio->id }}">Activar Servicio</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('activar-servicio', $servicio->id) }}" method="POST">
                                            @csrf
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
                        @endif
        
                       
        
                        
        
                        <!-- Eliminar servicio-->
                        <button type="button" class="btn-action eliminar" data-bs-toggle="modal" data-bs-target="#eliminarServicioModal{{ $servicio->id }}">
                            <i class='bx bx-trash' style="font-size: 20px;"></i>
                        </button>
                        
                        <div class="modal fade" id="eliminarServicioModal{{ $servicio->id }}" tabindex="-1" aria-labelledby="eliminarServicioModalLabel{{ $servicio->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="eliminarServicioModalLabel{{ $servicio->id }}">Eliminar Servicio</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('eliminar-servicio', $servicio->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
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
            background: linear-gradient(135deg, #121212, #1f1f1f);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
    
        #servicios h3 {
            color: #fff;
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }
    
        /* Estilo para cuando no hay servicios */
        #servicios p {
            font-size: 1rem;
            text-align: center;
            color: #aaa;
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
            background: #2a2a2a;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            width: 100%;
            max-width: 300px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
    
        .service-card h3.titulo-servicio {
            color: #fff;
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 10px;
        }
    
        /* Estilo para la columna de información */
        .service-card p {
            font-size: 0.9rem;
            margin-bottom: 8px;
            color: #ddd;
        }
    
        .service-card ul {
            list-style-type: none;
            padding-left: 0;
        }
    
        .service-card li {
            font-size: 0.9rem;
            color: #bbb;
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
            color: #666;
        }
    
        /* Estilo para la columna de acciones */
        .service-actions {
            display: flex; /* Alinea los botones en fila */
            justify-content: start; /* Alinea los botones al inicio */
            gap: 10px; /* Espaciado entre los botones */
        }
    
        .btn-action {
            display: inline-block;
            padding: 10px;
            border: none;
            cursor: pointer;
            background-color: #444;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
    
        .btn-action:hover {
            background-color: #555;
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
    <div id="citas">
        <h3 class="text-uppercase font-weight-bold text-white mb-4"> Mis Citas</h3>
        <div class="row">
            <div class="col-md-12">
                <div class="card-body">
                    @if ($citas->isEmpty())

                        <p class="text-center">No tienes citas agendadas.</p>
                    <!-- Si la fecha de la cita es menor a la fecha actual, no se muestra la cita-->
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
                                            <td>
                                                {{$cita->persona->nombre . ' ' . $cita->persona->apellido}}
                                                <a href="#" data-bs-toggle="modal" data-bs-target="#clienteModal{{ $cita->persona->id }}" style="color: #007bff; text-decoration: none;">
                                                    Ver detalle
                                                </a>
                                                
                                                <!-- Modal para mostrar los datos del cliente -->
                                                <div class="modal fade" id="clienteModal{{ $cita->persona->id }}" tabindex="-1" aria-labelledby="clienteModalLabel{{ $cita->persona->id }}" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="clienteModalLabel{{ $cita->persona->id }}">Datos del Cliente</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Nombre:</strong> {{ $cita->persona->nombre }} {{ $cita->persona->apellido }}</p>
                                                                <p><strong>Email:</strong> {{ $cita->persona->user->email }}</p>
                                                                <p><strong>Teléfono:</strong> {{ $cita->persona->telefono }}</p>
                                                                <p><strong>Dirección:</strong> {{ $cita->persona->domicilio }}</p>
                                                                @if ($cita->persona->calificacion == 0.0)
                                                                    <p><strong>Calificación:</strong> No calificado</p>
                                                                @else
                                                                    <p><strong>Calificación:</strong> 
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            @if ($i <= $cita->persona->calificacion)
                                                                                <i class="fas fa-star"></i> <!-- Estrella llena -->
                                                                            @else
                                                                                <i class="far fa-star"></i> <!-- Estrella vacía -->
                                                                            @endif
                                                                        @endfor
                                                                    </p>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($cita->servicio)
                                                    {{ $cita->servicio->nombre }}
                                                @else
                                                    No asignado
                                                @endif

                                            </td>
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
                                                @elseif ($cita->estado == 4)
                                                    <span class="badge badge-success" style="background-color: #28a745;"><strong>Pagada</strong></span>
                                                @endif
                                            </td>
                                            
                                            <td>
                                                @if ($cita->estado === 0)

                                                    <!-- Botón que abre el modal de confirmar cita -->
                                                    <button type="button" class="btn btn-modern" data-bs-toggle="modal" data-bs-target="#confirmCitaModal{{ $cita->idCita }}">
                                                        Confirmar Cita
                                                    </button>
                                                     
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
                                                @elseif ($cita->estado == 4 && $cita->calificacion_cliente == 0)
                                                    <!-- Botón para abrir el modal -->
                                                    <button type="button" class="btn btn-modern1" data-bs-toggle="modal" data-bs-target="#calificacionModal{{ $cita->idCita }}">
                                                        Calificar
                                                    </button>

                                                    <!-- Modal de Calificación -->
                                                    <div class="modal fade" id="calificacionModal{{ $cita->idCita }}" tabindex="-1" aria-labelledby="calificacionModalLabel{{ $cita->idCita }}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="calificacionModalLabel{{ $cita->idCita }}">Calificar al Cliente</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form id="calificacionForm{{ $cita->idCita }}" method="POST" action="{{ route('calificaciones-cliente.guardar', ['id' => $cita->idCita]) }}">
                                                                        @csrf <!-- Token CSRF de Laravel -->
                                                                        
                                                                        <div class="mb-3">
                                                                            <label for="calificacion{{ $cita->idCita }}" class="form-label">Calificación:</label>
                                                                            <select name="calificacion" id="calificacion{{ $cita->idCita }}" class="form-select">
                                                                                <option value="1">1</option>
                                                                                <option value="2">2</option>
                                                                                <option value="3">3</option>
                                                                                <option value="4">4</option>
                                                                                <option value="5">5</option>
                                                                            </select>
                                                                        </div>
                                                                        
                                                                        <div class="mb-3">
                                                                            <label for="comentario{{ $cita->idCita }}" class="form-label">Comentario:</label>
                                                                            <textarea name="comentario" id="comentario{{ $cita->idCita }}" class="form-control" rows="4"></textarea>
                                                                        </div>
                                                                        
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" class="btn btn-primary">Guardar Calificación</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <style>
                                                        /* Modal overlay */
                                                        .modal {
                                                            display: none;
                                                            position: fixed;
                                                            top: 0;
                                                            left: 0;
                                                            width: 100%;
                                                            height: 100%;
                                                            background-color: rgba(0, 0, 0, 0.6);
                                                            z-index: 9999;
                                                            justify-content: center;
                                                            align-items: center;
                                                        }

                                                        /* Modal content */
                                                        .modal-content {
                                                            background-color: #333;
                                                            padding: 30px;
                                                            border-radius: 10px;
                                                            width: 400px;
                                                            max-width: 90%;
                                                            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.3);
                                                            text-align: center;
                                                            color: #fff;
                                                            font-family: 'Arial', sans-serif;
                                                            position: relative;
                                                        }

                                                        /* Title styling */
                                                        .modal h3 {
                                                            font-size: 24px;
                                                            color: #fff;
                                                            margin-bottom: 20px;
                                                            font-weight: bold;
                                                            text-transform: uppercase;
                                                        }

                                                        /* Form layout */
                                                        .modal form {
                                                            display: flex;
                                                            flex-direction: column;
                                                            gap: 15px;
                                                        }

                                                        .modal label {
                                                            font-size: 14px;
                                                            color: #ccc;
                                                            margin-bottom: 5px;
                                                            text-align: left;
                                                            font-weight: 500;
                                                        }

                                                        /* Input and textarea styling */
                                                        .modal select,
                                                        .modal textarea {
                                                            padding: 10px;
                                                            border: 1px solid #555;
                                                            border-radius: 5px;
                                                            font-size: 14px;
                                                            width: 100%;
                                                            background-color: #222;
                                                            color: #fff;
                                                            box-sizing: border-box;
                                                        }

                                                        .modal textarea {
                                                            resize: vertical;
                                                        }

                                                        /* Button styling */
                                                        .modal button {
                                                            padding: 12px;
                                                            background-color: #ff00cc;
                                                            color: #fff;
                                                            border: none;
                                                            border-radius: 5px;
                                                            font-size: 14px;
                                                            cursor: pointer;
                                                            transition: background-color 0.3s ease;
                                                            text-transform: uppercase;
                                                            font-weight: bold;
                                                        }

                                                        .modal button:hover {
                                                            background-color: #333399;
                                                        }

                                                        /* Close button */
                                                        .close-btn {
                                                            background-color: transparent;
                                                            border: none;
                                                            color: #fff;
                                                            font-size: 20px;
                                                            cursor: pointer;
                                                            position: absolute;
                                                            top: 15px;
                                                            right: 15px;
                                                        }

                                                        .close-btn:hover {
                                                            color: #ff00cc;
                                                        }

                                                        /* Modal animation */
                                                        .modal-content {
                                                            animation: fadeIn 0.4s ease-in-out;
                                                        }

                                                        @keyframes fadeIn {
                                                            0% {
                                                                opacity: 0;
                                                                transform: scale(0.8);
                                                            }
                                                            100% {
                                                                opacity: 1;
                                                                transform: scale(1);
                                                            }
                                                        }

                                                        /* Make modal visible */
                                                        .modal.show {
                                                            display: flex;
                                                        }
                                                    </style>
                                                @elseif ($cita->estado == 4 && $cita->calificacion_cliente == 1)
                                                    <span class="badge badge-success" style="background-color: #007bff"><strong>Calificado</strong></span>

                                                @endif
                                        </td>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
                
    </div>
    <style>
        /* Estilo para el contenedor de citas */
        #citas {
            background: linear-gradient(135deg, #121212, #1f1f1f);
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }

        #citas h3 {
            color: #fff;
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }

        /* Estilo para las etiquetas */
        #citas label {
            font-weight: bold;
            font-size: 0.9rem;
            color: #bbb;
        }

        /* Estilo para los inputs y selects */
        #citas input, 
        #citas select {
            background-color: #2a2a2a;
            border: 1px solid #444;
            border-radius: 4px;
            padding: 10px;
            color: #ddd;
            transition: all 0.3s;
        }

        /* Estilo cuando los inputs/selects están enfocados */
        #citas input:focus, 
        #citas select:focus {
            border-color: #28a745;
            outline: none;
        }

        /* Estilo para el botón de acción */
        #citas .btn-success {
            background: linear-gradient(90deg, #ff00cc, #333399);
            font-size: 1rem;
            font-weight: bold;
            border-radius: 4px;
            padding: 10px 20px;
            color: white;
        }

        #citas .btn-success:hover {
            background: linear-gradient(90deg, #333399, #ff00cc);
        }

        /* Estilo para el texto dentro de inputs o selects de solo lectura */
        #citas .form-control-plaintext {
            color: #bbb;
            font-weight: bold;
        }

        /* Estilos generales para el modal */
        .modal-content {
            background-color: #1f1f1f; /* Fondo oscuro */
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            padding: 20px;
        }

        /* Cabecera del modal */
        .modal-header {
            border-bottom: 2px solid #444;
            padding-bottom: 15px;
        }

        /* Título del modal */
        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
            color: linear-gradient(90deg, #ff00cc, #333399);;
        }

        /* Botón de cierre */
        .btn-close {
            background-color: transparent;
            border: none;
            font-size: 1.5rem;
            color: linear-gradient(90deg, #ff00cc, #333399);;
        }

        /* Cuerpo del modal */
        .modal-body {
            font-size: 1rem;
            color: #ddd;
            padding-bottom: 10px;
        }

        /* Pie de página del modal */
        .modal-footer {
            border-top: 1px solid #444;
            padding-top: 10px;
        }

        /* Botones dentro del modal */
        .modal-footer .btn-secondary {
            background-color: #444;
            color: white;
            border-radius: 5px;
            padding: 8px 20px;
            font-size: 1rem;
        }

        .modal-footer .btn-secondary:hover {
            background-color: linear-gradient(90deg, #ff00cc, #333399);
            color: white;
        }

        /* Fondo oscuro de la pantalla cuando el modal está abierto */
        .modal-backdrop.show {
            background-color: rgba(0, 0, 0, 0.7);
        }

        /* Estilos generales para los badges */

        /* Estado Pendiente */
        .badge-warning {
            background-color: #f0ad4e;
            color: white;
        }

        /* Estado Confirmada */
        .badge-success {
            background-color: #28a745;
            color: white;
        }

        /* Estado Cancelada */
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        /* Estilos generales para los botones */

        /* Botón Confirmar Cita */
        .btn-modern {
            background-color: #28a745;
            color: white;
        }

        .btn-modern:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        /* Botón Rechazar Cita */
        .btn-modern1 {
            background-color: #dc3545;
            color: white;
        }

        .btn-modern1:hover {
            background-color: #c82333;
            transform: scale(1.05);
        }

    </style>
</div>

<div id="caja" class="section" style="display: none;">
    <div id="caja">
        <h3 class="text-uppercase font-weight-bold text-white mb-4" >Caja y Movimientos</h3>
        <!-- Si $mercadoPagoAccounts no está vacío, mostrar datos de Mercado Pago; de lo contrario, mostrar formulario -->
        @if (!empty($mercadoPagoAccounts))
            <div id="mercadoPago">
                <h5>Mercado Pago</h5>
            
                <div style="margin-bottom: 20px; background-color: #333; padding: 20px; border-radius: 8px; display: flex; flex-direction: column; gap: 15px;">
                    <!-- Botón de vinculación con Mercado Pago -->
                    <button class="btn btn-mercadopago" type="submit" >
                        <img src="{{ asset('Images/mercadopago.png') }}" alt="Mercado Pago" style="width: 20px; margin-right: 8px;"> 
                        Cuenta de Mercado Pago Vinculada
                    </button> 
                    <!-- Botón de desvinculación con Mercado Pago -->
                    <button class="btn btn-mercadopago-desvincular" type="submit" >
                        Desvincular Cuenta de Mercado Pago
                    </button>
                </div>
            </div>
            <div id="movimientos">
                <h5>Movimientos</h5>
                <form method="GET" action="{{ route('gestion-servicios') }}" style="margin-bottom: 20px; background-color: #333; padding: 20px; border-radius: 8px;">
                    <div style="display: flex; gap: 20px; flex-wrap: wrap; justify-content: space-between;">
                        <!-- Filtro por Fecha -->
                        <div style="flex: 1; min-width: 200px;">
                            <label for="fecha" style="color: white; font-size: 14px;">Fecha:</label>
                            <input type="date" id="fecha" name="fecha" value="{{ request('fecha') }}" class="form-control" style="width: 100%; padding: 10px; margin-top: 5px; background-color: #555; color: white; border: 1px solid #444; border-radius: 4px;">
                        </div>
                
                        <!-- Filtro por Nombre del Cliente -->
                        <div style="flex: 1; min-width: 200px;">
                            <label for="cliente" style="color: white; font-size: 14px;">Cliente:</label>
                            <input type="text" id="cliente" name="cliente" placeholder="Nombre del cliente" value="{{ request('cliente') }}" class="form-control" style="width: 100%; padding: 10px; margin-top: 5px; background-color: #555; color: white; border: 1px solid #444; border-radius: 4px;">
                        </div>
                
                        <!-- Filtro por Monto -->
                        <div style="flex: 1; min-width: 200px;">
                            <label for="monto_min" style="color: white; font-size: 14px;">Rango de Monto:</label>
                            <div style="display: flex; gap: 10px;">
                                <input type="number" id="monto_min" name="monto_min" placeholder="Mínimo" value="{{ request('monto_min') }}" class="form-control" style="width: 48%; padding: 10px; background-color: #555; color: white; border: 1px solid #444; border-radius: 4px;">
                                <input type="number" id="monto_max" name="monto_max" placeholder="Máximo" value="{{ request('monto_max') }}" class="form-control" style="width: 48%; padding: 10px; background-color: #555; color: white; border: 1px solid #444; border-radius: 4px;">
                            </div>
                        </div>

                
                        <!-- Filtro por Servicio -->
                        <div style="flex: 1; min-width: 200px;">
                            <label for="servicio" style="color: white; font-size: 14px;">Servicio:</label>
                            <input type="text" name="servicio" placeholder="Servicio" value="{{ request('servicio') }}" style="width: 100%; padding: 10px; margin-top: 5px; background-color: #555; color: white; border: 1px solid #444; border-radius: 4px;"> <!-- Nuevo filtro -->
                        </div>
                
                        <!-- Botones de Acción -->
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <button type="submit" class="btn" style="background-color: #444; color: white; border: none; padding: 10px 20px; cursor: pointer; border-radius: 4px; transition: background-color 0.3s;">
                                Filtrar
                            </button>
                            <a href="{{ route('gestion-servicios') }}" class="btn" style="background-color: #555; color: white; padding: 10px 20px; border: none; border-radius: 4px; text-decoration: none; transition: background-color 0.3s;">
                                Limpiar
                            </a>
                        </div>
                    </div>
                </form>
                <!-- Tabla -->
                <table id="movimientos-table" style="width: 100%; border-collapse: collapse; margin-top: 20px; background-color: #333; color: white;">
                    <thead style="background-color: #444;">
                        <tr>
                            <th style="padding: 10px; border: 1px solid #555;">Servicio</th>
                            <th style="padding: 10px; border: 1px solid #555;">Fecha</th>
                            <th style="padding: 10px; border: 1px solid #555;">Monto</th>
                            <th style="padding: 10px; border: 1px solid #555;">Tipo</th>
                            <th style="padding: 10px; border: 1px solid #555;">Cliente</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($citasFiltradas as $cita)
                            <tr style="background-color: #444;">
                                <td style="padding: 10px; border: 1px solid #555;">{{ $cita->servicio->nombre }}</td>
                                <td style="padding: 10px; border: 1px solid #555;">{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d/m/Y') }}</td>
                                <td style="padding: 10px; border: 1px solid #555;">${{ $cita->servicio->precio_base }}</td>
                                <td style="padding: 10px; border: 1px solid #555;">Pagado</td>
                                <td style="padding: 10px; border: 1px solid #555;">{{ $cita->persona->nombre }} {{ $cita->persona->apellido }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
            

        @else
            <div id="mercadoPago" style="margin-border: 20px;">
                <p style="color: white">Usted no tiene una cuenta de Mercado Pago vinculada. Por favor vincule su cuenta de Mercado Pago para continuar.</p>
                <!-- Formulario para vincular Mercado Pago -->
                <a href="{{ route('mercado-pago-vincular') }}" class="btn btn-mercadopago">
                    <img src="{{ asset('Images/mercadopago.png') }}" alt="Mercado Pago" style="width: 20px; margin-right: 8px;">
                    Vincular cuenta de Mercado Pago
                </a>
            </div>
            
        @endif
    </div>
    <style>
        /* Estilo para el contenedor de servicios */
        #caja {
            background: linear-gradient(135deg, #121212, #1f1f1f);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
        }
    
        #caja h3 {
            color: #fff;
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
        }
        #caja h5 {
            color: #fff;
            text-align: center;
            border-bottom: 2px solid #444;
            padding-bottom: 10px;
            border-top: 2px;
        }
    
        /* Estilo para cuando no hay servicios */
        #caja p {
            font-size: 1rem;
            text-align: center;
            color: #aaa;
        }
        .btn-mercadopago {
            background-color: white;
            color:#0063b1;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .btn-mercadopago:hover {
            background-color: #005087;
            color: white;
            cursor: pointer;
        }

        .btn-mercadopago:focus {
            outline: none;
        }
        .btn-mercadopago-desvincular {
            background-color: #cc0000;
            color:white;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .btn-mercadopago-desvincular:hover {
            background-color: white;
            color: #cc0000;
            cursor: pointer;
        }

        .btn-mercadopago-desvincular:focus {
            outline: none;
        }
        .btn-movimientos {
            background-color: #218838;
            color:white;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .btn-movimientos:hover {
            background-color: #28a745;
            color: white;
            cursor: pointer;
        }
    
        /* Estilo para el botón Crear servicio */
        .btn-create-caja {
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


    
    </style>
    
</div>






@endsection
