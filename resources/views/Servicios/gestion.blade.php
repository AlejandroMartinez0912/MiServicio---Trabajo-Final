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
        /* Estilos generales para el cuadro */
        .card {
            background-color: #ffffff; /* Fondo blanco para el cuadro */
            border-radius: 10px; /* Bordes redondeados */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Sombra suave para un efecto flotante */
            padding: 20px; /* Espaciado interno */
            margin: 15px 0; /* Separación entre el cuadro y otros elementos */
            transition: box-shadow 0.3s ease; /* Transición suave para la sombra */
        }

        /* Efecto al pasar el ratón sobre el cuadro */
        .card:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Aumentar la sombra para un efecto flotante */
        }

        /* Estilo para las secciones dentro del cuadro */
        .card .card-header {
            font-size: 1.25rem;
            font-weight: bold;
            color: #333;
            border-bottom: 2px solid #e0e0e0; /* Línea divisoria sutil */
            padding-bottom: 10px;
            margin-bottom: 15px;
        }

        /* Estilo para los textos o contenido dentro del cuadro */
        .card .card-body {
            font-size: 1rem;
            color: #555;
            line-height: 1.5;
        }

        /* Estilo para los botones dentro del cuadro */
        .card .nav-button {
            padding: 10px 20px;
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: #e0e0e0;
            color: #555;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem;
            margin: 0 5px;
        }

        .card .nav-button i {
            font-size: 1.5rem;
        }

        .card .nav-button:hover {
            background-color: #d1cfcf;
        }

        .card .active-tab {
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
        <style>
            /* Estilo general para los títulos */
            h3.text-center {
                font-size: 2rem; /* Tamaño grande */
                color: #333;
                letter-spacing: 1px;
            }

            /* Estilo para las secciones del formulario */
            .form-section {
                margin-bottom: 24px; /* Espaciado entre secciones */
            }

            .section-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #444;
                margin-bottom: 12px;
                text-transform: uppercase;
                letter-spacing: 1px;
            }

            /* Estilo para las etiquetas de los inputs */
            .form-label {
                font-size: 1rem;
                font-weight: 500;
                color: #555;
                margin-bottom: 8px;
            }

            /* Estilo para los inputs */
            .form-control {
                border-radius: 10px; /* Bordes más suaves */
                padding: 12px; /* Mayor espaciado en los inputs */
                font-size: 1rem;
                border: 1px solid #ccc;
                transition: border-color 0.3s ease;
            }

            .form-control:focus {
                border-color: #3f3fd1; /* Color azul al enfocar */
                box-shadow: 0 0 8px rgba(63, 63, 209, 0.2); /* Sombra sutil en el foco */
            }

            /* Estilo para el select */
            .form-control {
                height: 40px; /* Altura de los selects */
            }

            /* Estilo para el botón de guardar */
            .btn-primary {
                background-color: #3f3fd1; /* Azul principal */
                border-color: #3f3fd1;
                font-size: 1.1rem;
                padding: 12px;
                text-transform: uppercase;
                font-weight: bold;
                border-radius: 12px;
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #2e2e9b; /* Azul más oscuro al pasar el ratón */
                border-color: #2e2e9b;
                transform: scale(1.05); /* Efecto de escala */
            }

            .btn-primary:focus, .btn-primary:active {
                background-color: #232391; /* Color más oscuro en foco y clic */
            }

            /* Estilo para el texto en el campo de Calificación */
            .form-control-plaintext {
                font-size: 1.1rem;
                color: #333;
                font-weight: 500;
                padding-left: 0; /* Para eliminar el padding extra */
            }

            /* Espaciado y sombras para el contenedor principal */
            .card-body {
                padding: 20px;
                background-color: #f9f9f9; /* Fondo claro */
                border-radius: 12px; /* Bordes redondeados en todo el cuerpo */
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Sombra sutil */
            }
            /* Si deseas cambiar el color del botón "Actualizar Datos" */
            .btn-success {
                background-color: #3f3fd1; /* Verde para el botón de actualización */
                border-color: #3f3fd1;
            }

        </style>
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
                    <h3 class="text-center mb-5 text-uppercase font-weight-bold">Datos Profesionales</h3>
                    <div class="card-body p-4">
                        <!-- Sección: Nombre -->
                        <div class="form-section mb-4">
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
                        <div class="form-section mb-4">
                            <h4 class="section-title">Ubicación</h4>
                            <div class="form-group">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                            </div>
                        </div>

                        <!-- Sección: Contacto -->
                        <div class="form-section mb-4">
                            <h4 class="section-title">Contacto</h4>
                            <div class="form-group">
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>

                        <!-- Sección: Otros datos -->
                        <div class="form-section mb-4">
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
                        </div>

                        <button type="button" class="btn btn-primary btn-lg w-100 mt-4 shadow-lg" data-toggle="modal" data-target="#confirmModal">Guardar Datos</button>
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
    </div>

    <!-- Sección de Horarios -->
    <div  id="horarios" class="content-section">
        <style>
            /* Estilo para la tabla de horarios */
            .horarios-table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                font-family: Arial, sans-serif;
            }

            .horarios-table th, .horarios-table td {
                border: 1px solid #ddd;
                padding: 10px;
                text-align: center;
            }

            .horarios-table th {
                background-color: #f4f4f4;
                color: #333;
            }

            .horarios-table tbody tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            .horarios-table tbody tr:hover {
                background-color: #e6e6e6;
            }

            /* Estilo para los botones */
            .btn-action {
                padding: 5px 10px;
                font-size: 14px;
                border: none;
                cursor: pointer;
                margin: 5px;
                border-radius: 5px;
            }

            .btn-action.edit {
                background-color: #3f3fd1;
                color: white;
            }

            .btn-action.anular {
                background-color: #008CBA;
                color: white;
            }

            .btn-action.activar {
                background-color: orange;
                color: white;
            }

            .btn-action.eliminar {
                background-color: #f44336;
                color: white;
            }

            .btn-action:hover {
                opacity: 0.8;
            }

            /* Modal custom styles */
            .modal-content {
                border-radius: 8px;
            }

            .modal-header {
                background-color: #007bff;
                color: white;
            }

            .modal-footer button {
                border-radius: 5px;
            }

        </style>
        <div class="card shadow-lg mb-5" id="card-servicios">
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
                                                data-dia="{{ $horario->dia_id }}"
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
                                                                    <select name="dia_id" id="dia_id" class="form-control" required>
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
                                                $('#editarHorarioModal').on('show.bs.modal', function (event) {
                                                    var button = $(event.relatedTarget); // El botón que abrió el modal
                                                    var horarioId = button.data('id'); // El ID del horario
                                                    var diaId = button.data('dia'); // El ID del día
                                                    var horaInicio = button.data('hora_inicio'); // La hora de inicio
                                                    var horaFin = button.data('hora_fin'); // La hora de fin
                                                    var horaInicio1 = button.data('hora_inicio1'); // La hora de inicio adicional
                                                    var horaFin1 = button.data('hora_fin1'); // La hora de fin adicional

                                                    // Actualizar la acción del formulario
                                                    var formAction = '{{ route("actualizar-horario", ":id") }}';
                                                    formAction = formAction.replace(':id', horarioId);
                                                    $('#form-editar-horario').attr('action', formAction);

                                                    // Llenar los campos del formulario con los datos obtenidos
                                                    $('#horario-id').val(horarioId);
                                                    $('#dia_id').val(diaId);
                                                    $('#hora_inicio').val(horaInicio);
                                                    $('#hora_fin').val(horaFin);
                                                    $('#hora_inicio1').val(horaInicio1 || '');
                                                    $('#hora_fin1').val(horaFin1 || '');
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
    </div>
 
     <!-- Servicios -->
     <div id="servicios" class="content-section">
        <style>
            h3 {
                font-size: 1.8rem;
                color: #333;
                margin-bottom: 1rem;
            }

            p {
                font-size: 1rem;
                color: #666;
            }

            /* Estilos para los servicios */
            #card-serviciosIndividual {
                margin-bottom: 2rem;
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 20px;
            }

            #card-serviciosIndividual h3 {
                font-size: 1.5rem;
                color: #2a2a2a;
                margin-bottom: 10px;
            }

            #card-serviciosIndividual p {
                color: #555;
                font-size: 1rem;
                margin: 5px 0;
            }

            #card-serviciosIndividual ul {
                list-style-type: none;
                padding-left: 0;
            }

            #card-serviciosIndividual li {
                font-size: 0.9rem;
                color: #777;
                margin-bottom: 5px;
            }

            

            /* Estilos de modales */
            .modal-content {
                border-radius: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .modal-header {
                background-color: #007bff;
                color: white;
                border-top-left-radius: 8px;
                border-top-right-radius: 8px;
                padding: 15px;
            }

            .modal-title {
                font-size: 1.5rem;
            }

            .modal-footer {
                padding: 15px;
            }

            .modal-footer .btn {
                padding: 10px 20px;
            }

            /* Estilos de formularios */
            .form-label {
                font-size: 1rem;
                color: #333;
                margin-bottom: 5px;
            }

            .form-control {
                border-radius: 5px;
                border: 1px solid #ccc;
                padding: 12px;
                margin-bottom: 15px;
                width: 100%;
                font-size: 1rem;
                color: #333;
                transition: border-color 0.3s ease;
            }

            .form-control:focus {
                border-color: #007bff;
                outline: none;
            }

            .select2-container--default .select2-selection--multiple {
                border-radius: 5px;
                border: 1px solid #ccc;
                padding: 12px;
                font-size: 1rem;
            }

            /* Estilos de mensajes de error */
            .invalid-feedback {
                color: #dc3545;
                font-size: 0.875rem;
                margin-top: 5px;
            }
            /* Estilo para el botón de guardar */
            

        </style>
        <div class="card shadow-lg mb-5" id="card-servicios">
            <h3 class="text-center mb-5 text-uppercase font-weight-bold">Servicios</h3>
            
            @if ($servicios->isEmpty())
                <p>No hay servicios creados.</p>
                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
                    Crear servicio
                </button>
            @else
            <div id="card-serviciosIndividual">
                @foreach ($servicios as $servicio)
                    <div class="row mb-3">
                        <!-- Columna para los datos -->
                        <div class="col-md-8 p-3 bg-light border rounded shadow-sm">
                            <h3 class="text-primary">{{ $servicio->nombre }}</h3>
                            @if ($servicio->estado == 'activo')
                                <p class="font-weight-bold">Estado: <span class="text-success">{{ $servicio->estado }}</span></p>
                            @elseif ($servicio->estado == 'inactivo')
                                <p class="font-weight-bold">Estado: <span class="text-danger">{{ $servicio->estado }}</span></p>
                            @endif
                            <p class="font-weight-bold">Precio: <span class="text-success">{{ $servicio->precio_base }}</span></p>
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
                            <ul class="list-group list-group-flush">
                                @foreach ($servicio->rubros as $rubro)
                                    <li class="list-group-item">{{ $rubro->nombre }}</li>
                                @endforeach
                            </ul>
                        </div>

                        
                         <!-- Columna para los botones -->
                        <div class="col-md-4 d-flex flex-column justify-content-start">
                            <button type="button" class="btn-action edit" data-bs-toggle="modal" data-bs-target="#editarServicioModal">Editar</button>
                            
                            @if ($servicio->estado == 'activo')
                                <button type="button" class="btn-action anular" data-bs-toggle="modal" data-bs-target="#anularServicioModal">Anular</button>
                            @else
                                <button type="button" class="btn-action active" data-bs-toggle="modal" data-bs-target="#activarServicioModal">Activar</button>                        
                            @endif
                            
                            <button type="button" class="btn-action eliminar" data-bs-toggle="modal" data-bs-target="#eliminarServicioModal">Eliminar</button>
                        </div>
                    </div>
                @endforeach
            </div>
                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
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
        </div>
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

