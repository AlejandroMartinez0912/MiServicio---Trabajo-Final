@extends('layouts.plantillain')

@section('titulo', 'Gestión de servicio')

@section('contenido')
    <style>
        /* Estilo adicional para los botones de la barra de navegación */
        .nav-button {
            padding: 10px 20px; /* Ajusta el padding para que el botón se ajuste al contenido */
            display: flex;
            align-items: center;
            gap: 8px; /* Espacio entre el icono y el texto */
            background-color: #e0e0e0;
            color: #555;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem; /* Ajusta el tamaño del texto */
            margin: 0 5px;
        }
        .nav-button i {
            font-size: 1.5rem; /* Tamaño del icono */
        }
        .nav-button:hover {
            background-color: #d1cfcf;
        }
        .active-tab {
            background-color: #3f3fd1;
            color: #fff;
        }

    </style>

<div class="container mt-5">
    <div class="d-flex justify-content-center mb-4">
        <!-- Botones de navegación -->
        <div class="nav-button active-tab" onclick="showSection('datos')"><i class='bx bxs-business'></i>Datos Profesionales</div>
        <div class="nav-button" onclick="showSection('horarios')"><i class='bx bx-donate-blood'></i> Horarios atencion</div>
        <div class="nav-button" onclick="showSection('servicios')"><i class='bx bx-donate-blood'></i> Servicios</div>
        <div class="nav-button" onclick="showSection('agenda')"><i class='bx bxs-calendar'></i> Agenda</div>
        <div class="nav-button" onclick="showSection('clientes')"><i class='bx bxs-user-check'></i> Clientes</div>
        <div class="nav-button" onclick="showSection('informes')"><i class='bx bxs-detail'></i> Informes</div>
        <div class="nav-button" onclick="showSection('caja')"><i class='bx bx-dollar'></i> Caja</div>
        <div class="nav-button" onclick="showSection('ajustes')"><i class='bx bx-slider'></i> Ajustes</div>
        <div class="nav-button" onclick="{{ route('privada') }}">Volver</div>
    </div>

    <!-- Secciones de contenido -->

    <!-- Datos Profesionales -->
    <div id="datos" class="content-section">
        
        @if($datosProfesion)
            <!-- Si ya existen los datos profesionales, se muestran y algunos campos no son editables -->
            <form action="{{ route('actualizar-datos', $datosProfesion->id) }}" method="POST">

                @csrf
                @method('PUT')
                
                <div class="card shadow-lg mb-5">
                    <h3 class="text-center mb-4">Datos Profesionales</h3>

                    <div class="card-body">

                        <!-- Sección: Nombre -->
                        <div class="form-section">
                            <h4 class="section-title">Nombre</h4>
                            <div class="form-group">
                                <label for="nombre_fantasia" class="form-label">Nombre Fantasía</label>
                                <input type="text" class="form-control" id="nombre_fantasia" name="nombre_fantasia" value="{{ $datosProfesion->nombre_fantasia }}" disabled>
                            </div>
                            <div class="form-group">
                                <label for="slogan" class="form-label">Slogan</label>
                                <input type="text" class="form-control" id="slogan" name="slogan" value="{{ $datosProfesion->slogan }}">
                            </div>
                        </div>

                        <!-- Sección: Ubicación -->
                        <div class="form-section">
                            <h4 class="section-title">Ubicación</h4>
                            <div class="form-group">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" value="{{ $datosProfesion->ubicacion }}" required>
                            </div>
                        </div>

                        <!-- Sección: Contacto -->
                        <div class="form-section">
                            <h4 class="section-title">Contacto</h4>
                            <div class="form-group">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="{{ $datosProfesion->telefono }}">
                            </div>
                        </div>

                        <!-- Sección: Otros datos -->
                        <div class="form-section">
                            <h4 class="section-title">Otros Datos</h4>
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

                        <button type="button" class="btn btn-success btn-lg w-100 mt-3" data-toggle="modal" data-target="#confirmModal">Actualizar Datos</button>
                    </div>
                </div>
            </form>
        @else
            <!-- Si no existen los datos, mostramos los campos vacíos para crear los datos -->
            <form action="{{ route('guardar-datos') }}" method="POST">
                @csrf

                <div class="card shadow-lg mb-5">
                    <h3 class="text-center mb-4">Datos Profesionales</h3>

                    <div class="card-body">

                        <!-- Sección: Nombre -->
                        <div class="form-section">
                            <h4 class="section-title">Nombre</h4>
                            <div class="form-group">
                                <label for="nombre_fantasia" class="form-label">Nombre Fantasía</label>
                                <input type="text" class="form-control" id="nombre_fantasia" name="nombre_fantasia" required>
                            </div>
                            <div class="form-group">
                                <label for="slogan" class="form-label">Slogan</label>
                                <input type="text" class="form-control" id="slogan" name="slogan">
                            </div>
                        </div>

                        <!-- Sección: Ubicación -->
                        <div class="form-section">
                            <h4 class="section-title">Ubicación</h4>
                            <div class="form-group">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                            </div>
                        </div>

                        <!-- Sección: Contacto -->
                        <div class="form-section">
                            <h4 class="section-title">Contacto</h4>
                            <div class="form-group">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>

                        <!-- Sección: Otros datos -->
                        <div class="form-section">
                            <h4 class="section-title">Otros Datos</h4>
                            <div class="form-group">
                                <label for="experiencia" class="form-label">Experiencia</label>
                                <input type="number" id="experiencia" name="experiencia" class="form-control" min="0" step="1" placeholder="Ingrese la experiencia" required>
                            </div>
                            <div class="form-group">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="calificacion" class="form-label">Calificación</label>
                                <div class="form-control-plaintext">
                                    {{ $promedio }} 
                                </div>                        
                        </div>
                        <button type="button" class="btn btn-primary btn-lg w-100 mt-3" data-toggle="modal" data-target="#confirmModal">Guardar Datos</button>
                    </div>
                </div>
            </form>
        @endif
        <!-- Modal de Confirmación -->
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Confirmar Acción</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Estás seguro de que quieres guardar los cambios?
                    </div>
                    <div class="modal-footer">
                        <!-- Botón de Cancelar -->
                        <button type="button" class="btn btn-secondary btn-lg w-100" data-dismiss="modal">Cancelar</button>
                        <!-- Botón de Confirmar -->
                        <button type="button" class="btn btn-primary btn-lg w-100" id="confirmSave">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            // Al confirmar en el modal, enviar el formulario
            document.getElementById('confirmSave').addEventListener('click', function () {
                // Encuentra el formulario correspondiente
                var form = document.querySelector('form');
                
                // Enviar el formulario
                form.submit();
            });
        </script>
        <!-- Estilo CSS -->
        <style>
            .card {
                background-color: #f0f0f0;
                border-radius: 10px;
                padding: 20px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .form-section {
                margin-bottom: 2rem;
            }

            .section-title {
                font-size: 1.2rem;
                font-weight: 600;
                margin-bottom: 1rem;
                color: #3f3fd1;
            }

            .form-group {
                margin-bottom: 1.5rem;
            }

            .form-control {
                border-radius: 10px;
                padding: 10px;
                width: 100%;
            }

            .form-control-plaintext {
                font-size: 1rem;
                font-weight: 500;
                color: #6c757d;
            }

            .btn-primary, .btn-success {
                border-radius: 50px;
                font-size: 1.2rem;
                padding: 12px 20px;
                transition: background-color 0.3s ease-in-out;
            }

            .btn-primary:hover, .btn-success:hover {
                background-color: #0069d9;
            }

            .text-center {
                font-family: 'Poppins', sans-serif;
                font-weight: bold;
                color: #3f3fd1;
            }
            /* Personalización para los botones del modal */
            .modal-footer .btn {
                margin-top: 10px; /* Agrega un pequeño margen superior */
            }

            .modal-footer .btn-lg {
                font-size: 1.1rem; /* Aumenta ligeramente el tamaño de la fuente */
            }

            .modal-footer .btn-secondary {
                background-color: #6c757d; /* Color gris más suave */
                border-color: #6c757d;
            }

            .modal-footer .btn-primary {
                background-color: #007bff; /* Color azul más vibrante */
                border-color: #007bff;
            }

        </style>
    </div>

<!-- Sección de Horarios -->
<div  id="horarios" class="content-section">
    <style>
        /* Estilo CSS para el Modal */

        .modal-content {
            border-radius: 10px;
            padding: 20px;
        }

        .modal-header {
            border-bottom: 1px solid #ccc;
            font-weight: bold;
            background-color: #f5f5f5;
            color: #3f3fd1;
        }

        .modal-footer {
            border-top: 1px solid #ccc;
            display: flex;
            justify-content: space-between;
        }

        .form-control {
            border-radius: 10px;
            padding: 10px;
        }

        .btn-primary {
            background-color: #3f3fd1;
            border-color: #3f3fd1;
            padding: 10px 20px;
            font-size: 1.1rem;
            border-radius: 50px;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #0069d9;
        }

        .text-center {
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            color: #3f3fd1;
        }

        .form-group label {
            font-weight: 600;
            color: #3f3fd1;
        }

        .modal-footer .btn {
            margin-top: 10px;
        }

        /* Estilo general de la tabla */
        .horarios-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        /* Estilo de las celdas de la tabla */
        .horarios-table th, .horarios-table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
        }

        /* Fondo de las celdas de encabezado */
        .horarios-table th {
            background-color: #3f3fd1;
            color: white;
            font-weight: bold;
        }

        /* Estilo de las filas alternas de la tabla */
        .horarios-table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        /* Estilo de las filas al pasar el ratón */
        .horarios-table tr:hover {
            background-color: #e6e6e6;
        }

        /* Botones de acción (Editar, Eliminar) */
        .btn-action {
            font-size: 0.9rem;
            padding: 8px 15px;
            border-radius: 25px;
            text-decoration: none;
            color: #fff;
            text-align: center;
            display: inline-block;
            transition: background-color 0.3s ease;
        }

        /* Botón Editar */
        .btn-action.edit {
            background-color: #ff9800;
        }

        .btn-action.edit:hover {
            background-color: #f57c00;
        }

        /* Botón Eliminar */
        .btn-action.eliminar {
            background-color: #f44336;
        }

        .btn-action.eliminar:hover {
            background-color: #d32f2f;
        }
        .btn-action.anular{
            background-color: blue;
        }
        .btn-action.anular:hover{
            background-color: blue;
        }

        /* Mensaje de cuando no hay horarios */
        .no-horarios-msg {
            text-align: center;
            font-size: 1.2rem;
            color: #555;
            font-family: 'Poppins', sans-serif;
        }

        /* Botón de Crear Horario */
        .btn-crear-horario {
            background-color: #3f3fd1;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 30px;
            font-size: 1.1rem;
            font-weight: bold;
            transition: background-color 0.3s ease;
            margin-bottom: 20px;
        }

        .btn-crear-horario:hover {
            background-color: #2c2ca5;
        }
    </style>

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
            <!-- Sección para crear un nuevo horario -->
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#crearHorarioModal">
                Crear Horario de Trabajo
            </button>
            <h3 class="text-center">Horarios de Trabajo</h3>
            <table class="horarios-table">
                <thead>
                    <tr>
                        <th>Día</th>
                        <th>Hora de Inicio</th>
                        <th>Hora de Fin</th>
                        <th>Hora de Inicio (segunda franja)</th>
                        <th>Hora de Fin (segunda franja)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($horariosTrabajo as $horario)
                        @if($horario->estado == 1)
                            <tr>
                                <td>{{ $ $horario->dia->abreviatura ?? 'Día no especificado' }}</td>
                                <td>{{ $horario->hora_inicio }}</td>
                                <td>{{ $horario->hora_fin }}</td>
                                <td>{{ $horario->hora_inicio1 ?? 'N/A' }}</td>
                                <td>{{ $horario->hora_fin1 ?? 'N/A' }}</td>
                                <td>
                                    <!-- Botones de Edición -->
                                    <button 
                                        data-toggle="modal" 
                                        data-target="#editarHorarioModal" 
                                        data-id="{{ $horario->id }}"
                                        data-dia="{{ $horario->dias_id }}"
                                        data-hora_inicio="{{ $horario->hora_inicio }}"
                                        data-hora_fin="{{ $horario->hora_fin }}"
                                        data-hora_inicio1="{{ $horario->hora_inicio1 }}"
                                        data-hora_fin1="{{ $horario->hora_fin1 }}"
                                        class="btn-action edit">
                                        Editar
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
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <input type="hidden" id="horario-id" name="id" value="">

                                                        <!-- Día -->
                                                        <div class="form-group">
                                                            <label for="dia_id">Día</label>
                                                            <select name="dia_id" id="dia_id" class="form-control">
                                                                <option value="">Seleccionar Día</option>
                                                                @foreach($dias as $dia)
                                                                    <option value="{{ $dia->id }}">{{ $dia->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Hora de inicio -->
                                                        <div class="form-group">
                                                            <label for="hora_inicio">Hora de Inicio</label>
                                                            <input type="time" name="hora_inicio" id="hora_inicio" class="form-control" required>
                                                        </div>

                                                        <!-- Hora de fin -->
                                                        <div class="form-group">
                                                            <label for="hora_fin">Hora de Fin</label>
                                                            <input type="time" name="hora_fin" id="hora_fin" class="form-control" required>
                                                        </div>

                                                        <!-- Hora de inicio adicional (opcional) -->
                                                        <div class="form-group">
                                                            <label for="hora_inicio1">Hora de Inicio 2 (Opcional)</label>
                                                            <input type="time" name="hora_inicio1" id="hora_inicio1" class="form-control">
                                                        </div>

                                                        <!-- Hora de fin adicional (opcional) -->
                                                        <div class="form-group">
                                                            <label for="hora_fin1">Hora de Fin 2 (Opcional)</label>
                                                            <input type="time" name="hora_fin1" id="hora_fin1" class="form-control">
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
                                        // Este script se ejecutará cuando el modal se active
                                        $('#editarHorarioModal').on('show.bs.modal', function (event) {
                                            var button = $(event.relatedTarget); // El botón que abrió el modal
                                            var horarioId = button.data('id'); // El ID del horario
                                            var diaId = button.data('dia'); // El ID del día
                                            var horaInicio = button.data('hora_inicio'); // La hora de inicio
                                            var horaFin = button.data('hora_fin'); // La hora de fin
                                            var horaInicio1 = button.data('hora_inicio1'); // La hora de inicio adicional
                                            var horaFin1 = button.data('hora_fin1'); // La hora de fin adicional

                                            // Llenar el formulario con los datos del horario
                                            var formAction = '{{ route("actualizar-horario", ":id") }}';
                                            formAction = formAction.replace(':id', horarioId);
                                            $('#form-editar-horario').attr('action', formAction);

                                            $('#horario-id').val(horarioId);
                                            $('#dia_id').val(diaId);
                                            $('#hora_inicio').val(horaInicio);
                                            $('#hora_fin').val(horaFin);
                                            $('#hora_inicio1').val(horaInicio1);
                                            $('#hora_fin1').val(horaFin1);
                                        });
                                    </script>

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

                                    <!-- Botones de Eliminar-->
                                    <!-- Botón para eliminar horario -->
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
                        @endif
                    @endforeach
                </tbody>
            </table>
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
        <h3>Servicios</h3>
        <p>Aquí puedes gestionar los servicios de la empresa.</p>
    

    <!-- Agenda -->
    <div id="agenda" class="content-section">
        <h3>Agenda</h3>
        <p>Aquí puedes gestionar los turnos de la empresa.</p>
    </div>

    <!-- Clientes -->
    <div id="clientes" class="content-section d-none">
        <h3>Clientes</h3>
        <p>Gestiona los clientes registrados en la empresa.</p>
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

 

    <!-- Ajustes -->
    <div id="ajustes" class="content-section d-none">
        <h3>Ajustes</h3>
        <p>Ajustes de la cuenta y preferencias del usuario.</p>
    </div>
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

