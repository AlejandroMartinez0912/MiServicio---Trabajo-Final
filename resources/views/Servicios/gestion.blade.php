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
    </div>
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

