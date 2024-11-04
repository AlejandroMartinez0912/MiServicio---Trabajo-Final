@extends('layouts.plantillain')

@section('titulo', 'Gestión de negocio')

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
        <div class="nav-button active-tab" onclick="showSection('agenda')"><i class='bx bxs-calendar'></i> Agenda</div>
        <div class="nav-button" onclick="showSection('clientes')"><i class='bx bxs-user-check'></i> Clientes</div>
        <div class="nav-button" onclick="showSection('servicios')"><i class='bx bx-donate-blood'></i> Servicios</div>
        <div class="nav-button" onclick="showSection('informes')"><i class='bx bxs-detail'></i> Informes</div>
        <div class="nav-button" onclick="showSection('caja')"><i class='bx bx-dollar'></i> Caja</div>
        <div class="nav-button" onclick="showSection('editar')"><i class='bx bxs-business'></i>Editar</div>
        <div class="nav-button" onclick="showSection('ajustes')"><i class='bx bx-slider'></i> Ajustes</div>
        <div class="nav-button" onclick="{{ route('gestionar-empresas') }}">Volver</div>
    </div>

    <!-- Secciones de contenido -->

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

    <!-- Servicios -->
    <div id="servicios" class="content-section d-none">
        <style>
            /* Estilos personalizados para la sección de servicios */
            .content-section {
                background-color: gray; /* Color de fondo claro */
                border-radius: 15px;
                padding: 20px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            }
        
            .list-group-item {
                background-color: #3f3fd1; /* Color del fondo de los ítems */
                color: #f8f9fa;
                border-radius: 10px;
                transition: all 0.3s ease-in-out;
            }
        
            .list-group-item:hover {
                transform: scale(1.02);
                box-shadow: 0 0 10px rgba(0, 123, 255, 0.5);
            }
        
            .alert {
                border-radius: 10px;
            }
        
            .btn-primary {
                background-color: #0d6efd; /* Color del botón */
            }
        
            .btn-primary:hover {
                background-color: #0a58ca; /* Color al pasar el mouse */
            }
        
            .btn-secondary {
                background-color: #6c757d; /* Color gris */
            }
        
            .btn-secondary:hover {
                background-color: #5a6268; /* Color gris más oscuro al pasar el mouse */
            }
            .modalidad-btn {
                flex: 1;
                margin: 0 5px;
                padding: 10px;
                border: 1px solid #007bff;
                background-color: #fff;
                color: #007bff;
                border-radius: 5px;
                cursor: pointer;
                text-align: center;
                transition: background-color 0.3s, color 0.3s;
            }

            .modalidad-btn:hover {
                background-color: #007bff;
                color: white;
            }

            .modalidad-btn.selected {
                background-color: #007bff;
                color: white;
                border-color: #0056b3;
            }
            .modal-footer .btn {
                min-width: 150px; 
                padding: 10px 20px; 
                font-size: 1rem; 
            }
        </style>
            <div class="container">
                <h2 class="text-center mb-4">Servicios de {{ $empresa->nombre }}</h2>
                <!-- Comprobar si hay servicios activos (estado: 1) -->
                @php
                $serviciosActivos = $servicios->where('estado', 1);
                @endphp
                <!-- Comprobar si hay servicios -->
                @if($serviciosActivos->isEmpty())
                    <div class="alert alert-info text-center">
                        No tiene servicios creados. <a href="#" data-bs-toggle="modal" data-bs-target="#crearServicioModal">Crear uno aquí</a>.
                    </div>
                @else
                    <div class="list-group">
                        @foreach($servicios as $servicio)
                            <div class="card mb-3 shadow-sm border-0">
                                <div class="card-body d-flex align-items-center">
                                    <!-- Icono decorativo para cada servicio -->
                                    <div class="me-3 text-primary">
                                        <i class="bi bi-briefcase-fill" style="font-size: 2rem;"></i>
                                    </div>
                    
                                    <div class="flex-grow-1">
                                        <!-- Nombre del servicio -->
                                        <h3 class="card-title mb-1 text-white">{{ $servicio->nombre }}</h3>
                                        <!-- Precio y duración en una fila -->
                                        <div class="d-flex justify-content-start">
                                            <div class="me-4">
                                                <p class="mb-0"><strong>Precio:</strong>
                                                    @if ($servicio->precio_fijo !== null)
                                                        ${{ number_format($servicio->precio_fijo, 2) }} - Fijo
                                                    @elseif ($servicio->precio_hora !== null)
                                                        ${{ number_format($servicio->precio_hora, 2) }} - Por hora
                                                    @else
                                                        No disponible
                                                    @endif
                                                </p>
                                            </div>
                                            <div>
                                                <p class="mb-0"><strong>Modalidad:</strong> {{($servicio->modalidad) }}</p>
                                            </div>
                                        </div>
                                    </div>
                    
                                    <!-- Botones de acciones (editar o eliminar, con estilo más moderno) -->
                                    <div class="d-flex">
                                        <button class="btn btn-primary btn-sm me-2 d-flex align-items-center" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editarServicioModal" 
                                            onclick="editarServicio({{ $servicio->id }}, '{{ $servicio->nombre }}', '{{ $servicio->precio_fijo }}', '{{ $servicio->precio_hora }}', '{{ $servicio->duracion }}', '{{ $servicio->modalidad }}', '{{ $servicio->descripcion }}')">
                                            <i class="bx bx-edit-alt me-1"></i>
                                            Modificar
                                        </button>
                                        <!-- Botón de Eliminar -->
                                        <button class="btn btn-danger btn-sm d-flex align-items-center" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#eliminarServicioModal" 
                                        onclick="setServicioId({{ $empresa->id }}, {{ $servicio->id }})">
                                        <i class="bx bx-trash me-1"></i> Eliminar
                                        </button>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Botón para crear un nuevo servicio --> 
                    <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
                        Crear Nuevo Servicio
                    </button>
                @endif
            </div>    
            <!-- Modal para crear un nuevo servicio -->
            <div class="modal fade" id="crearServicioModal" tabindex="-1" aria-labelledby="crearServicioModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="crearServicioModalLabel">Nuevo Servicio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('guardar-servicio', $empresa->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre del servicio</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Presupuesto ($)</label>
                                    <select class="form-select" id="tipoPresupuesto" name="tipo_presupuesto" required onchange="togglePresupuestoInput()">
                                        <option value="fijo">Fijo</option>
                                        <option value="hora">Por hora</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3" id="presupuestoFijoInput" style="display: block;">
                                    <label for="presupuesto_fijo" class="form-label">Presupuesto fijo ($)</label>
                                    <input type="text" name="presupuesto_fijo" id="presupuesto_fijo" class="form-control" placeholder="0,00">
                                </div>
                                
                                <div class="mb-3" id="presupuestoHoraInput" style="display: none;">
                                    <label for="presupuesto_hora" class="form-label">Presupuesto por hora ($)</label>
                                    <input type="text" name="presupuesto_hora" id="presupuesto_hora" class="form-control" placeholder="0,00">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Duración</label>
                                    <div class="d-flex">
                                        <input type="number" name="horas" id="horas" class="form-control" placeholder="Horas" min="0" required>
                                        <span class="mx-2">:</span>
                                        <input type="number" name="minutos" id="minutos" class="form-control" placeholder="Minutos" min="0" max="59" required>
                                    </div>
                                </div>
                                
                                <!-- Campo oculto para la duración combinada -->
                                <input type="hidden" name="duracion" id="duracion">
                            
                                <div class="mb-3">
                                    <label class="form-label">Modalidad</label>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="modalidad-btn" onclick="selectModalidad('Presencial')">Presencial</button>
                                        <button type="button" class="modalidad-btn" onclick="selectModalidad('Online')">Online</button>
                                        <button type="button" class="modalidad-btn" onclick="selectModalidad('A domicilio')">A domicilio</button>
                                    </div>
                                    <input type="hidden" name="modalidad" id="modalidad" required>
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label">Descripción del servicio</label>
                                    <textarea name="descripcion" id="descripcion" class="form-control" rows="3" placeholder="Escriba una breve descripción del servicio" required></textarea>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Crear Servicio</button>
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- Modal para editar un servicio -->
            <div class="modal fade" id="editarServicioModal" tabindex="-1" aria-labelledby="editarServicioModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editarServicioModalLabel">Modificar Servicio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editarServicioForm" action="" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="servicio_id" id="servicio_id">
                                
                                <!-- Campo Nombre -->
                                <div class="mb-3">
                                    <label for="edit_nombre" class="form-label">Nombre del servicio</label>
                                    <input type="text" name="nombre" id="edit_nombre" class="form-control" required>
                                </div>
                                
                                <!-- Selección de tipo de presupuesto -->
                                <div class="mb-3">
                                    <label class="form-label">Tipo de Presupuesto</label>
                                    <select name="tipo_presupuesto" id="edit_tipo_presupuesto" class="form-select" onchange="togglePrecioFields()" required>
                                        <option value="fijo">Precio Fijo</option>
                                        <option value="hora">Precio por Hora</option>
                                    </select>
                                </div>

                                <!-- Campo Precio Fijo -->
                                <div class="mb-3" id="precio_fijo_field">
                                    <label for="edit_precio_fijo" class="form-label">Presupuesto Fijo ($)</label>
                                    <input type="number" name="precio_fijo" id="edit_precio_fijo" class="form-control" placeholder="0.00" min="0" step="0.01">
                                </div>

                                <!-- Campo Precio por Hora -->
                                <div class="mb-3" id="precio_hora_field" style="display: none;">
                                    <label for="edit_precio_hora" class="form-label">Presupuesto por Hora ($)</label>
                                    <input type="number" name="precio_hora" id="edit_precio_hora" class="form-control" placeholder="0.00" min="0" step="0.01">
                                </div>
                                
                                <!-- Campos de Duración -->
                                <div class="mb-3">
                                    <label class="form-label">Duración</label>
                                    <div class="d-flex">
                                        <input type="number" name="horas" id="edit_horas" class="form-control" placeholder="Horas" min="0" required>
                                        <span class="mx-2">:</span>
                                        <input type="number" name="minutos" id="edit_minutos" class="form-control" placeholder="Minutos" min="0" max="59" required>
                                    </div>
                                </div>
                                
                                <!-- Modalidad -->
                                <div class="mb-3">
                                    <label class="form-label">Modalidad</label>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="modalidad-btn" onclick="selectEditModalidad('Presencial')">Presencial</button>
                                        <button type="button" class="modalidad-btn" onclick="selectEditModalidad('Online')">Online</button>
                                        <button type="button" class="modalidad-btn" onclick="selectEditModalidad('A domicilio')">A domicilio</button>
                                    </div>
                                    <input type="hidden" name="modalidad" id="edit_modalidad" required>
                                </div>
                                
                                <!-- Campo Descripción -->
                                <div class="mb-3">
                                    <label for="edit_descripcion" class="form-label">Descripción del servicio</label>
                                    <textarea name="descripcion" id="edit_descripcion" class="form-control" rows="3"></textarea>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para Confirmar Eliminación -->
            <div class="modal fade" id="eliminarServicioModal" tabindex="-1" aria-labelledby="eliminarServicioModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eliminarServicioModalLabel">Eliminar Servicio</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p class="text-danger">¿Estás seguro de que deseas eliminar este servicio? Esta acción no se puede deshacer.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
                            <form id="eliminarServicioForm" action="" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Script para marcar la selección del botón de modalidad -->
            <script>
                function selectModalidad(modalidad) {
                    // Limpiar la selección actual
                    const buttons = document.querySelectorAll('.modalidad-btn');
                    buttons.forEach(button => {
                        button.classList.remove('selected');
                    });

                    // Marcar el botón seleccionado
                    const selectedButton = Array.from(buttons).find(button => button.textContent === modalidad);
                    selectedButton.classList.add('selected');

                    // Actualizar el valor del input oculto
                    document.getElementById('modalidad').value = modalidad;
                }
            </script>
            <!-- Script para formatear la duración en formato "HH:MM:SS" -->
            <script>
                document.querySelector('form').addEventListener('submit', function(event) {
                    const horas = document.getElementById('horas').value || 0;
                    const minutos = document.getElementById('minutos').value || 0;
            
                    // Formatea la duración en formato "HH:MM:SS"
                    const duracion = `${String(horas).padStart(2, '0')}:${String(minutos).padStart(2, '0')}:00`;
                    document.getElementById('duracion').value = duracion;
                });

            </script>
            <!--Script para editar el servicio-->
            <script>
                function editarServicio(servicioId, nombre, tipoPresupuesto, precioFijo, precioHora, duracion, modalidad, descripcion) {
                    // Establece la URL de acción del formulario usando los parámetros de empresa y servicio
                    const empresaId = "{{ $empresa->id }}";
                    document.getElementById('editarServicioForm').action = `/empresa/gestion/${empresaId}/servicio/${servicioId}`;

                    // Rellena los valores en los campos del formulario
                    document.getElementById('servicio_id').value = servicioId;
                    document.getElementById('edit_nombre').value = nombre;
                    document.getElementById('edit_descripcion').value = descripcion;

                    // Establece tipo de presupuesto y ajusta campos visibles
                    document.getElementById('edit_tipo_presupuesto').value = tipoPresupuesto;
                    togglePrecioFields();
                    document.getElementById('edit_precio_fijo').value = precioFijo || '';
                    document.getElementById('edit_precio_hora').value = precioHora || '';

                    // Asigna la duración (separando en horas y minutos)
                    const [horas, minutos] = duracion.split(':');
                    document.getElementById('edit_horas').value = parseInt(horas, 10);
                    document.getElementById('edit_minutos').value = parseInt(minutos, 10);

                    // Selecciona la modalidad usando la función auxiliar
                    selectEditModalidad(modalidad);
                }

                function selectEditModalidad(modalidad) {
                    document.getElementById('edit_modalidad').value = modalidad;

                    // Ajusta la clase CSS para resaltar el botón seleccionado
                    const modalidadButtons = document.querySelectorAll('.modalidad-btn');
                    modalidadButtons.forEach(button => {
                        button.classList.toggle('active', button.textContent.trim() === modalidad);
                    });
                }

                function togglePrecioFields() {
                    const tipoPresupuesto = document.getElementById('edit_tipo_presupuesto').value;
                    document.getElementById('precio_fijo_field').style.display = tipoPresupuesto === 'fijo' ? 'block' : 'none';
                    document.getElementById('precio_hora_field').style.display = tipoPresupuesto === 'hora' ? 'block' : 'none';
                }
            </script>
            <!-- Script para eliminar un servicio -->
            <script>
                function setServicioId(empresaId, servicioId) {
                    const form = document.getElementById('eliminarServicioForm');
                    form.action = `/empresa/${empresaId}/servicio/${servicioId}`;
                }
            </script>
            <!-- Script para marcar la selección del botón de modalidad -->
            <script>
                function marcarModalidadSeleccionada(modalidad, inputId) {
                    // Limpiar la selección actual
                    const buttons = document.querySelectorAll('.modalidad-btn');
                    buttons.forEach(button => {
                        button.classList.remove('selected');
                    });

                    // Marcar el botón seleccionado
                    const selectedButton = Array.from(buttons).find(button => button.textContent.trim() === modalidad);
                    if (selectedButton) {
                        selectedButton.classList.add('selected');
                    }

                    // Actualizar el valor del input oculto
                    document.getElementById(inputId).value = modalidad;
                }

                // Configurar evento para cuando se abre el modal
                document.getElementById('editarServicioModal').addEventListener('show.bs.modal', function () {
                    // Obtener el valor actual de modalidad del input oculto
                    const modalidadActual = document.getElementById("edit_modalidad").value;

                    // Marcar el botón correspondiente
                    if (modalidadActual) {
                        marcarModalidadSeleccionada(modalidadActual, 'edit_modalidad');
                    }
                });
            </script>
            <!--Script para mostrar o ocultar el campo de presupuesto -->
            <script>
                function togglePresupuestoInput() {
                    const tipoPresupuesto = document.getElementById('tipoPresupuesto').value;
                    document.getElementById('presupuestoFijoInput').style.display = tipoPresupuesto === 'fijo' ? 'block' : 'none';
                    document.getElementById('presupuestoHoraInput').style.display = tipoPresupuesto === 'hora' ? 'block' : 'none';
                }
            </script>

     
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

    <!-- Editar -->
    <div id="editar" class="content-section d-none">
        <style>
            /* Estilos personalizados */
            .card {
                background-color: #3f3fd1;
                color: #f8f9fa;
                border-radius: 15px;
                transition: all 0.3s ease-in-out;
            }
        
            .card:hover {
                transform: scale(1.05);
                box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
            }
        
            .form-control {
                border-radius: 10px;
            }
        
            .btn {
                border-radius: 50px;
                border: none;
                padding: 10px 20px;
                font-size: 1.2rem;
                transition: background-color 0.3s ease-in-out;
                width: 48%; /* Asegura que ambos botones tengan el mismo tamaño */
            }
        
            .btn-primary {
                background-color: #0d6efd;
            }
        
            .btn-primary:hover {
                background-color: #0a58ca;
            }
        
            .btn-secondary {
                background-color: #6c757d; /* Color gris */
            }
        
            .btn-secondary:hover {
                background-color: #5a6268; /* Color gris más oscuro */
            }
        
            .welcome-message, h2, h3 {
                font-family: 'Poppins', sans-serif;
                font-weight: bold;
            }
        
            p, label {
                font-family: 'Roboto', sans-serif;
            }
        
            /* Estilos personalizados para Select2 */
            .select2-container {
                width: 100% !important;
            }
        
            .select2-selection--multiple {
                min-height: 60px;
                padding: 10px;
                border-radius: 10px;
                border: 1px solid #ced4da;
            }
        
            /* Estilo del rubro seleccionado */
            .select2-selection__choice {
                background-color: #0d6efd !important; /* Color azul claro */
                color: #fff !important; /* Texto blanco */
                border-radius: 25px;
                padding: 5px 10px;
                margin: 3px;
                font-size: 0.9rem;
            }
        
            /* Botón de eliminar rubro */
            .select2-selection__choice__remove {
                color: #f8d7da !important;
                margin-right: 8px;
                cursor: pointer;
            }
        
            /* Hover sobre rubro seleccionado */
            .select2-selection__choice:hover {
                background-color: #0d6efd !important; /* Azul más oscuro */
            }
        
            /* Estilo para la imagen de perfil */
            .profile-pic {
                width: 100px; /* Ajusta el tamaño según sea necesario */
                height: 100px; /* Ajusta el tamaño según sea necesario */
                border-radius: 50%; /* Crea el efecto de círculo */
                border: 2px dashed #f8f9fa; /* Borde de la imagen */
                display: flex;
                align-items: center; /* Centra verticalmente el contenido */
                justify-content: center; /* Centra horizontalmente el contenido */
                margin: 0 auto; /* Centra el elemento en el contenedor */
                cursor: pointer;
                position: relative;
            }
        
            .profile-pic img {
                border-radius: 50%;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
        
            /* Estilo para el input oculto */
            input[type="file"] {
                display: none; /* Oculta el input */
            }
        
            .upload-icon {
                font-size: 24px; /* Tamaño del icono */
                color: #f8f9fa; /* Color del icono */
                text-align: center; /* Centra el icono en su contenedor */
                display: flex; /* Usa flexbox para centrar el icono */
                align-items: center; /* Centra verticalmente el icono */
                justify-content: center; /* Centra horizontalmente el icono */
            }
        
            .dias-semana {
                display: flex;
                justify-content: space-between;
                margin-bottom: 30px; /* Mayor separación entre los días */
            }
        
            .dia {
                flex: 1;
                text-align: center;
                margin-bottom: 15px;
            }
        
            .form-control.hora {
                width: 70px; /* Tamaño más pequeño para los inputs de hora */
                padding: 3px; /* Menor padding */
            }
        
            .mb-2 {
                margin-bottom: 15px; /* Mayor separación entre inputs */
            }
        
            .button-transparent {
                background: transparent;
                border: none;
                color: white;
                font-size: 0.9rem;
                padding: 5px; /* Tamaño reducido */
            }
        
            .turno-row {
                display: flex;
                align-items: center;
                gap: 10px; /* Separación entre inputs de inicio y fin */
            }
        </style>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow-lg p-4 mb-5">
                        <h2 class="text-center mb-4">
                            <i class='bx bxs-business'></i> Negocio
                        </h2>
        
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
        
                        <div class="card-body">
                            <form id="empresaForm" action="{{ route('actualizar-empresa', $empresa->id)  }}#editar" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <h3 class="text-center mb-3">Información del Negocio</h3>
                                    <div class="col-md-6 text-center">
                                        <label class="form-label">Logo</label>
                                        <div class="profile-pic" onclick="document.getElementById('logo').click()">
                                            <input type="file" name="logo" class="form-control" id="logo" accept="image/*">
                                            <span class="upload-icon"><i class='bx bxs-upload'></i></span>
                                            @if($empresa->logo)
                                                <img src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo de la empresa">
                                            @endif
                                        </div>
                                    </div>
                                
        
                                <h3 class="text-center mb-3">Rubro/s</h3>
                                <div class="mb-3">
                                    <label for="rubros" class="form-label">Selecciona uno o más rubros</label>
                                    <select name="rubros[]" class="form-control select2" id="rubros" multiple required>
                                        @foreach($rubros as $rubro)
                                            <option value="{{ $rubro->id }}" 
                                                {{ in_array($rubro->id, $empresa->rubros->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{ $rubro->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
        
                                <h3 class="text-center mb-3">Ubicación</h3>
                                <div class="mb-3">
                                    <label for="ubicacion" class="form-label">Dirección de la empresa</label>
                                    <input type="text" name="ubicacion" class="form-control" id="ubicacion" 
                                        value="{{ old('ubicacion', $empresa->ubicacion) }}" 
                                        placeholder="Dirección de la empresa" required>
                                </div>

                                <h3 class="text-center mb-3">Horarios de Atención</h3>
                                <div class="dias-semana">
                                    @foreach(['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo'] as $dia)
                                        <div class="dia">
                                            <label class="form-label">{{ ucfirst($dia) }}</label>
                                            
                                            <!-- Checkbox para activar/desactivar horarios de este día -->
                                            <div class="form-check form-switch d-flex justify-content-center mb-2">
                                                <input type="checkbox" class="form-check-input" id="confirmar_{{ $dia }}" 
                                                    name="dias_confirmados[{{ $dia }}]" 
                                                    {{ in_array($dia, ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo']) ? 'checked' : '' }}
                                                    onchange="toggleHorarios('{{ $dia }}')">
                                                <label class="form-check-label" for="confirmar_{{ $dia }}"></label>
                                            </div>

                                            <!-- Selects de Horario -->
                                            <div class="turno-group" id="turnos_{{ $dia }}">
                                                <div class="row mb-2">
                                                    <div class="col-md-12">
                                                        <select name="horarios[{{ $dia }}][hora_inicio][]" 
                                                                class="form-control hora {{ !in_array($dia, ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo']) ? 'disabled' : '' }}" 
                                                                id="hora_inicio_{{ $dia }}_1" required>
                                                            <option value="08:00" selected>08:00</option>
                                                            @for($i = 0; $i < 24; $i++)
                                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</option>
                                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:30">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:30</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <select name="horarios[{{ $dia }}][hora_fin][]" 
                                                                class="form-control hora {{ !in_array($dia, ['lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo']) ? 'disabled' : '' }}" 
                                                                id="hora_fin_{{ $dia }}_1" required>
                                                            <option value="17:00" selected>17:00</option>
                                                            @for($i = 0; $i < 24; $i++)
                                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:00</option>
                                                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:30">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}:30</option>
                                                            @endfor
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="d-flex justify-content-center mt-2">
                                                <button type="button" id="button-add-{{ $dia }}" class="button-transparent mx-2" onclick="addTurno('{{ $dia }}')">
                                                    <i class='bx bx-plus-medical'></i>
                                                </button>
                                                <button type="button" id="button-remove-{{ $dia }}" class="button-transparent d-none mx-2" onclick="removeTurno('{{ $dia }}')">
                                                    <i class='bx bx-minus'></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

        
                                <div class="d-flex justify-content-between mt-4">
                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                    <a href="{{ route('gestionar-empresas') }}" class="btn btn-secondary">Cancelar</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script>
            $(document).ready(function() {
                // Inicializa Select2
                $('#rubros').select2({
                    placeholder: "Seleccione uno o más rubros",
                    allowClear: true,
                    width: '100%'
                });
        
                // Evento para confirmar y enviar el formulario
                $('#confirmBtn').on('click', function() {
                    $('#empresaForm').submit();
                });
            });
        </script>
        <!-- Script para horarios-->
        <script>
            function toggleHorarios(dia) {
                const checkbox = document.getElementById(`confirmar_${dia}`);
                const horarios = document.querySelectorAll(`#turnos_${dia} .form-control`);
                
                horarios.forEach(horario => {
                    horario.disabled = !checkbox.checked;
                });
            }
        </script>
        
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

