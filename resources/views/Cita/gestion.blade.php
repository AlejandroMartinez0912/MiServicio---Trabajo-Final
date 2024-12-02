@extends('layouts.plantillain')

@section('titulo', 'Gestión de Citas')
<!-- Estilos adicionales para mejorar la apariencia -->
<style>
    * Ajuste de la barra de navegación */
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
/* Contenedor principal */
.services-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 20px;
    padding: 20px;
    max-width: 100%;
    background-color: #f8f9fa; /* Fondo suave */
}

/* Estilos de card */
.plan {
    border-radius: 16px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    padding: 10px;
    background-color: white;
    color: #697e91;
    min-width: 250px;
    box-sizing: border-box;
    max-width: 300px;
}

.plan strong {
    font-weight: 600;
    color: #333;
}

.plan .inner {
    align-items: center;
    padding: 20px;
    padding-top: 40px;
    background-color: grey;
    border-radius: 12px;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.plan .pricing {
    top: 0;
    right: 0;
    background-color: black;
    border-radius: 99em 0 0 99em;
    display: flex;
    align-items: center;
    padding: 0.625em 0.75em;
    font-size: 1.25rem;
    font-weight: 600;
    color: white;
}

.plan .pricing small {
    color: grey;
    font-size: 0.75em;
    margin-left: 0.25em;
}

.plan .title {
    font-weight: 600;
    font-size: 1.25rem;
    color: white;
    text-align: center;
}

.plan .info {
    color: #ddd;
    text-align: center;
    margin-top: 8px;
}

.plan .features {
    display: flex;
    flex-direction: column;
    margin-top: 16px;
}

.plan .features li {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: white;
}

.plan .features li + * {
    margin-top: 0.75rem;
}

.plan .features .icon {
    background-color: black;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
}

.plan .features + * {
    margin-top: 1.25rem;
}

.plan .action {
    margin-top: auto;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: end;
}

.plan .button {
    background-color: #333;
    border-radius: 6px;
    color: white;
    font-weight: 500;
    font-size: 1.125rem;
    text-align: center;
    border: 0;
    outline: 0;
    width: 100%;
    padding: 0.625em 0.75em;
    text-decoration: none;
}

.plan .button:hover,
.plan .button:focus {
    background-color: black;
}
/* Contenedor para organizar las tarjetas en filas */
.plan-container {
  display: flex;
  flex-wrap: wrap; /* Asegura que las tarjetas pasen a la siguiente fila si no caben */
  justify-content: center;
  gap: 20px;
  background-color: #f8f9fa;
  padding: 20px;
  border-radius: 5px;
}

</style>
@section('contenido')
<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark"">
    <div class="container-fluid">
        <!-- Descr de la marca -->
        <a class="navbar-brand" href="#" style="font-family: 'Roboto', sans-serif; font-weight: 700; letter-spacing: 2px;">Gestiona tus Citas</a>
        <!-- Menú de navegación -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link text-light p-2" href="#buscar-servicios" style="transition: all 0.3s ease; font-size: 1.1rem;">Buscar Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light p-2" href="#mis-citas" style="transition: all 0.3s ease; font-size: 1.1rem;">Mis Citas</a>
                </li>
                
            </ul>
        </div>
    </div>
</nav>


<!-- Sección: Buscar Servicios -->
<div id="buscar-servicios" class="section" style="display:none;">
    <div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
        <div>
            <!-- Título de la sección -->
            <h3 class="text-center mb-4">Buscar Servicios</h2>
            <!-- Barra de búsqueda con ícono -->
            <div class="row mb-4">
                <div class="col-md-6 offset-md-3">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bx bx-search"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Buscar por nombre de servicio..." aria-label="Buscar servicio">
                        <span class="input-group-text">
                            <i class='bx bx-filter'></i>
                        </span>
                    </div>
                </div>
    
             </div>
        </div>
        <!-- Listado de Servicios -->
        <div class="plan-container">
            @foreach ($servicios as $servicio)
            <div class="plan">
                <div class="inner">
                    <span class="pricing">
                        <span>
                            ${{ number_format($servicio->precio_base, 2) }} <small></small>
                        </span>
                    </span>
                    <p class="title">{{ $servicio->nombre }}</p>
                    <p class="info">{{ $servicio->descripcion }}</p>
                    <ul class="features">
                        <li>
                     
                            <span>
                                <strong>Calificación:
                                        @if ($servicio->calificacion == 0)
                                                No calificado
                                        @else
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $servicio->calificacion)
                                                    <i class='bx bxs-star text-warning'></i> <!-- Estrella llena -->
                                                @else
                                                    <i class='bx bx-star text-muted'></i> <!-- Estrella vacía -->
                                                @endif
                                            @endfor
                                    @endif
                                </strong>
                            </span>
                        </li>
                        <li>
                            @php
                                $duracionEstimada = \Carbon\Carbon::parse($servicio->duracion_estimada);
                                $duracionEnMinutos = $duracionEstimada->hour * 60 + $duracionEstimada->minute;
                            @endphp
                            <span><strong>Duración: {{ floor($duracionEnMinutos / 60) }}h {{ $duracionEnMinutos % 60 }}m</strong></span>
                        </li>
                    </ul>
                    <div class="action">
                        <a class="button" href="{{ route('agendar-cita', ['idServicio' => $servicio->id]) }}">
                            Agendar cita
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

</div>


<!-- Sección: Mis Citas -->
<div id="mis-citas" class="section mt-5">
    <div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
        <h3>Mis Citas</h3>
        <div class="row">
            <div class="col-md-12">
                    <div class="card-body">
                        @if ($citas->isEmpty())

                            <p class="text-center">No tienes citas agendadas.</p>
                        @else
                            <table class="table horarios-table table-hover table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Servicio</th>
                                        <th>Especialista</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($citas as $cita)
                                            <tr>
                                                <td>{{ $cita->servicio->nombre }}</td>
                                                @php
                                                    $idEspecialista = $cita->servicio->datos_profesion_id;
                                                    $especialista = $datosProfesion->where('id', $idEspecialista)->first();
                                                @endphp
                                                <td> {{ $especialista->nombre_fantasia }}</td>
                                                <td>{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d/m/Y') }}</td>
                                                <td>{{ \Carbon\Carbon::parse($cita->horaInicio)->format('H:i') }}</td>
                                                <td>
                                                    @if ($cita->estado == 0)
                                                        <span class="badge badge-warning">Pendiente</span>
                                                    @elseif ($cita->estado == 1)
                                                        <span class="badge badge-success">Confirmada</span>
                                                    @elseif ($cita->estado == 2)
                                                        <span class="badge badge-danger">Cancelada</span>
                                                    @elseif ($cita->estado == 3)
                                                        <span class="badge badge-success"><strong>Re-confirmada</strong></span>
                                                    @endif
                        
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-action edit">Editar</button>
                                                    <button class="btn btn-sm btn-action anular">Cancelar</button>
                                                </td>                                        
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
        </div>
    </div>
    
     
</div>

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
            showSection('buscar-servicios');
        });

</script>
@endsection
