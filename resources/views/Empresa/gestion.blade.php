@extends('layouts.plantillain')

@section('titulo', 'Panel de gestión de empresa')

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
        <div class="container">
            <h2>Servicios de {{ $empresa->nombre }}</h2>
        
            <!-- Comprobar si hay servicios -->
            @if($servicios->isEmpty())
                <p>No tiene servicios creados. <a href="#" data-bs-toggle="modal" data-bs-target="#crearServicioModal">Crear uno aquí</a>.</p>
            @else
                <div class="list-group">
                    @foreach($servicios as $servicio)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h5>{{ $servicio->nombre }}</h5>
                                <p>{{ $servicio->descripcion }}</p>
                                <p><strong>Precio:</strong> ${{ number_format($servicio->precio, 2) }}</p>
                                <p><strong>Duración:</strong> {{ $servicio->duracion ?? 'N/A' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        
            <!-- Botón para crear un nuevo servicio -->
            <button type="button" class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#crearServicioModal">
                Crear Nuevo Servicio
            </button>
        </div>
        
        <!-- Modal para crear un nuevo servicio -->
        <div class="modal fade" id="crearServicioModal" tabindex="-1" aria-labelledby="crearServicioModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="crearServicioModalLabel">Crear Nuevo Servicio</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('guardar-servicio', $empresa->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="nombre">Nombre del servicio</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="precio">Precio</label>
                                <input type="number" name="precio" id="precio" class="form-control" required min="0" step="0.01">
                            </div>
                            <div class="form-group">
                                <label for="duracion">Duración</label>
                                <input type="time" name="duracion" id="duracion" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="modalidad">Modalidad</label>
                                <input type="text" name="modalidad" id="modalidad" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Guardar Servicio</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
                            <i class='bx bxs-business'></i> Empresa
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
                            <form id="empresaForm" action="{{ route('actualizar-empresa', $empresa->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <h3 class="text-center mb-3">Información de la Empresa</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="nombre" class="form-label">Nombre de la empresa</label>
                                            <input type="text" name="nombre" class="form-control" id="nombre" 
                                                value="{{ old('nombre', $empresa->nombre) }}" 
                                                placeholder="Nombre de la empresa" required>
                                        </div>
        
                                        <div class="mb-3">
                                            <label for="slogan" class="form-label">Slogan</label>
                                            <input type="text" name="slogan" class="form-control" id="slogan" 
                                                value="{{ old('slogan', $empresa->slogan) }}" 
                                                placeholder="Slogan de la empresa">
                                        </div>
                                    </div>
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
