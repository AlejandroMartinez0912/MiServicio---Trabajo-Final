@extends('layouts.miservicioIn')

@section('titulo', 'MiServicio | Inicio')

@section('contenido')

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <!-- Logo de la marca -->
        <a class="navbar-brand" href="#" style="font-family: 'Roboto', sans-serif; font-weight: 700; letter-spacing: 2px;">Buscar Servicios</a>

        <!-- Botón de filtro (dropdown) -->
        <div class="dropdown ms-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: transparent; color: white;">
                Categorías
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <!-- Iterar sobre los rubros para mostrarlos como opciones -->
                @foreach($rubros as $rubro)
                    <li><a class="dropdown-item" href="#">{{ $rubro->nombre }}</a></li>
                @endforeach
            </ul>
        </div>

        <!-- Barra de búsqueda -->
        <form class="d-flex ms-auto me-3" role="search" onsubmit="handleSearch(event)" style="max-width: 300px;">
            <input class="form-control me-2" type="search" placeholder="Buscar servicios..." aria-label="Buscar" id="searchInput" style="background-color: white; color: black; border: none; border-radius: 5px;">
            <button class="btn" type="submit" style="background-color: #ff00cc; color: white; border: none;"><i class="bx bx-search"></i></button>
        </form>

        <!-- Botón de filtro (dropdown) -->
        <div class="dropdown ms-3">
            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false" style="background-color: #ff00cc; color: white;">
                Filtrar por
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="#">Precio</a></li>
                <li><a class="dropdown-item" href="#">Ubicación</a></li>
                <li><a class="dropdown-item" href="#">Calificación</a></li>
            </ul>
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

<script>
    // Función para manejar el evento de búsqueda
    function handleSearch(event) {
        event.preventDefault(); // Evita que el formulario recargue la página
        const query = document.getElementById('searchInput').value.trim();
        if (query) {
            alert(`Buscando: ${query}`);
            // Implementar la lógica de búsqueda aquí
        } else {
            alert('Por favor, ingresa un término de búsqueda.');
        }
    }

    // Función para mostrar solo la sección activa
    function showSection(sectionId) {
        const sections = document.querySelectorAll('.section');
        sections.forEach(section => section.style.display = 'none');

        const activeSection = document.getElementById(sectionId);
        if (activeSection) {
            activeSection.style.display = 'block';
        }

        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => link.classList.remove('active'));

        const activeLink = document.querySelector(`.nav-link[onclick="showSection('${sectionId}')"]`);
        if (activeLink) {
            activeLink.classList.add('active');
        }

        localStorage.setItem('activeSection', sectionId);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const savedSection = localStorage.getItem('activeSection') || 'datos';
        showSection(savedSection);
    });
</script>

<div class="container mt-5">
    <div class="row justify-content-start g-4"> <!-- Clase 'g-4' para espaciado uniforme entre tarjetas -->
        @foreach ($servicios as $servicio)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex justify-content-center"> <!-- Ajuste de columnas responsivas -->
                <div class="card">
                    <div class="title">
                        <span>{{ $servicio->nombre }}</span>
                    </div>
                    <div class="size">
                        <p>{{ $servicio->descripcion }}</p>
                        <p><strong>Precio:</strong> ${{ number_format($servicio->precio_base, 2) }}</p>
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
@endsection
