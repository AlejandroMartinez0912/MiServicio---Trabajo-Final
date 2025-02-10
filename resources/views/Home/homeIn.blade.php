@extends('layouts.miservicioIn')

@section('titulo', 'MiServicio | Inicio')

@section('contenido')

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <!-- Logo de la marca -->
        <a class="navbar-brand" href="#" style="font-family: 'Roboto', sans-serif; font-weight: 700; letter-spacing: 2px;">Buscar Servicios</a>

        <!-- Dropdown de Categorías -->
        <div class="dropdown ms-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; color: white;">
                Categorías
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach($rubros as $rubro)
                    <li>
                        <a class="dropdown-item" href="{{ route('search', array_merge(request()->all(), ['rubro_id' => $rubro->id])) }}">
                            {{ $rubro->nombre }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        <!-- Dropdown de Ordenamiento -->
        <div class="dropdown ms-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #ff00cc; color: white;">
                Filtrar por
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="{{ route('search', array_merge(request()->all(), ['order' => 'mayor_precio'])) }}">Mayor precio</a></li>
                <li><a class="dropdown-item" href="{{ route('search', array_merge(request()->all(), ['order' => 'menor_precio'])) }}">Menor precio</a></li>
                <li><a class="dropdown-item" href="{{ route('search', array_merge(request()->all(), ['order' => 'calificacion'])) }}">Calificación</a></li>
            </ul>
        </div>



        <!-- Barra de búsqueda -->
        <form class="d-flex ms-auto me-3" role="search" method="GET" action="{{ route('search') }}" style="max-width: 300px;">
            <input class="form-control me-2" type="search" name="search" placeholder="Buscar servicios..." aria-label="Buscar" id="searchInput" style="background-color: white; color: black; border: none; border-radius: 5px;" value="{{ request('search') }}">
            <button class="btn" type="submit" style="background-color: #ff00cc; color: white; border: none;"title="Buscar">
                <i class="bx bx-search"></i>
            </button>
        </form>

        <div class="d-flex align-items-center">
            <!-- Botón de limpiar filtros -->
            <a href="{{ route('search') }}" 
               class="btn btn-warning ms-3" 
               style="background-color: #333399; color: white; border: none;" 
               title="Limpiar filtros">
                <i class='bx bx-eraser' style="cursor: pointer;"></i>
            </a>
        </div>
        
        
        
    </div>
</nav>

<style>
    .navbar-brand {
        color: white;
    }

    .nav-link.active {
        color: #ff00cc;
        font-weight: bold;
        border-bottom: 2px solid #333399;
    }

    .form-control:focus {
        outline: none;
        box-shadow: none;
    }

    .btn:hover {
        background-color: #333399;
        color: white;
    }
    
</style>

<div class="container mt-5">
    <div class="row justify-content-start g-4"> <!-- Clase 'g-4' para espaciado uniforme entre tarjetas -->
        @foreach ($servicios as $servicio)
            @if ($servicio->estado == 'activo')

                <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center"> <!-- Ajuste de columnas responsivas -->
                    <div class="card">
                        <div class="title">
                            <span>{{ $servicio->nombre }}</span>
                        </div>
                        <div class="size">
                            <p>{{ $servicio->descripcion }}</p>
                            <p>
                                <strong>Calificación:</strong>
                                @if ($servicio->calificacion == 0)
                                    No calificado
                                @else
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $servicio->calificacion)
                                            <i class='bx bxs-star text-warning'></i>
                                        @else
                                            <i class='bx bx-star text-muted'></i>
                                        @endif
                                    @endfor
                                @endif
                            </p>
                            <p>
                                @php
                                    $duracionEstimada = \Carbon\Carbon::parse($servicio->duracion_estimada);
                                    $duracionEnMinutos = $duracionEstimada->hour * 60 + $duracionEstimada->minute;
                                @endphp
                                <strong>Duración:</strong> {{ floor($duracionEnMinutos / 60) }}h {{ $duracionEnMinutos % 60 }}m
                            </p>
                            <p>
                                @php
                                    $especialista = $servicio->datosProfesion->user->persona;
                                    $especialistaNombre = $especialista->nombre;
                                    $especialistaApellido = $especialista->apellido;
                                @endphp
                                <strong>Especialista:</strong> {{$especialistaNombre}} {{$especialistaApellido}}
                            </p>
                        </div>

                        <div class="action">
                            <div class="price">
                                <span>${{ number_format($servicio->precio_base, 2) }}</span>
                            </div>
                        </div>
                        <a href="{{ route('agendar-cita', ['idServicio' => $servicio->id]) }}" class="cart-button">
                            <span>Agendar cita</span>
                        </a>
                                           
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>

<style>
    .card {
    --bg-card: #27272a;
    --primary: #6d28d9;
    --primary-800: #4c1d95;
    --primary-shadow: #2e1065;
    --light: #d9d9d9;
    --zinc-800: #18181b;
    --bg-linear: linear-gradient(0deg, var(--primary) 50%, var(--light) 125%);

    display: flex;
    flex-direction: column;
    gap: 0.75rem;

    padding: 1rem;
    width: 14rem;
    background-color: var(--bg-card);

    border-radius: 1rem;
    }

    .title {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--light);
    text-transform: capitalize;
    }

    .size {
    font-size: 0.875rem;
    color: var(--light);
    }

    .action {
    display: flex;
    align-items: center;
    gap: 1rem;
    }

    .price {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--light);
    }

    .cart-button {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;

    padding: 0.5rem;
    background-image: var(--bg-linear);
    color: var(--light);
    font-weight: 500;

    border: 2px solid hsla(262, 83%, 58%, 0.5);
    border-radius: 0.5rem;

    transition: all 0.3s ease-in-out;
    }

    .cart-button:hover {
    background-color: var(--primary-800);
    border-color: var(--primary-shadow);
    }

    .cart-button .cart-icon {
    width: 1rem;
    }

</style>

<!-- Modal de Calificación -->
<div class="modal" id="calificacionModal" style="display: none;">
    <div class="modal-content">
        <h3>Calificar Servicio</h3>
        <!-- Formulario para calificar -->
        <form id="calificacionForm" method="POST" action="" data-id-cita="">
            @csrf <!-- Token CSRF de Laravel para seguridad -->
            <input type="hidden" id="citaId" name="idCita"> <!-- Campo oculto para idCita -->
            <div>
                <label for="calificacion">Calificación:</label>
                <select name="calificacion" id="calificacion">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div>
                <label for="comentario">Comentario:</label>
                <textarea name="comentario" id="comentario" rows="4"></textarea>
            </div>
            <div>
                <button type="submit">Guardar Calificación</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Función para obtener calificaciones pendientes
        function obtenerCalificacionesPendientes() {
            $.ajax({
                url: '/calificaciones/pendientes', // Ruta al método del controlador
                type: 'GET',
                success: function (response) {
                    if (response.success && response.data.length > 0) {
                        // Tomar la primera cita pendiente
                        var cita = response.data[0];

                        // Asignar valores dinámicamente al formulario y modal
                        $('#citaId').val(cita.idCita);
                        $('#calificacionForm').attr('action', '/calificaciones/' + cita.idCita + '/guardar');
                        $('#calificacionModal').css('display', 'flex'); // Mostrar el modal
                    } else {
                        // No hay citas pendientes, simplemente no hacer nada
                        $('#calificacionModal').css('display', 'none'); // Asegurarse de que el modal esté oculto
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener las calificaciones pendientes:', error);
                    $('#calificacionModal').css('display', 'none'); // Ocultar el modal en caso de error
                }
            });
        }

        // Llamar a la función al cargar la página o según sea necesario
        obtenerCalificacionesPendientes();

        // Manejar el envío del formulario
        $('#calificacionForm').on('submit', function (e) {
            e.preventDefault(); // Prevenir la acción predeterminada del formulario

            var formData = $(this).serialize(); // Serializar datos del formulario
            var actionUrl = $(this).attr('action'); // Obtener la URL de acción dinámica

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Calificación guardada exitosamente
                    $('#calificacionModal').css('display', 'none'); // Cerrar el modal
                    obtenerCalificacionesPendientes(); // Recargar la lista de pendientes
                },
                error: function (xhr, status, error) {
                    console.error('Error al guardar la calificación:', error);
                    alert('Ocurrió un error al guardar la calificación. Por favor, inténtelo de nuevo.');
                }
            });
        });
    });
</script>


<style>
    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #333;
        padding: 30px;
        border-radius: 8px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        text-align: center;
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .modal h3 {
        font-size: 26px;
        color: #fff;
        margin-bottom: 20px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .modal form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .modal label {
        font-size: 16px;
        color: #fff;
        margin-bottom: 8px;
        text-align: left;
        font-weight: 500;
    }

    .modal select,
    .modal textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        width: 100%;
        box-sizing: border-box;
        background-color: #222;
        color: #fff;
    }

    .modal textarea {
        resize: vertical;
    }

    .modal button {
        padding: 12px 25px;
        background-color: #ff00cc;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-transform: uppercase;
    }

    .modal button:hover {
        background-color: #333399;
    }

    /* Estilo del fondo oscuro de la pantalla */
    .modal {
        display: flex;
    }

    /* Botón de cerrar el modal */
    .close-btn {
        background-color: transparent;
        border: none;
        color: #fff;
        font-size: 25px;
        cursor: pointer;
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .close-btn:hover {
        color: #ff00cc;
    }

    /* Animación de entrada para el modal */
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
</style>

@endsection
