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
            <button class="btn" type="submit" style="background-color: #ff00cc; color: white; border: none;">
                <i class="bx bx-search"></i>
            </button>
        </form>

        <div class="d-flex align-items-center">
            <!-- Botón de limpiar filtros -->
            <a href="{{ route('search') }}" class="btn btn-warning ms-3" style="background-color: #333399; color: white; border: none;">
                Limpiar filtros
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
