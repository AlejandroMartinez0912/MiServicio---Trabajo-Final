@extends('layouts.plantillain')

@section('titulo')
MiServicio
@endsection

@section('contenido')

<style>
    .card {
        background-color: #343a40; /* Azul personalizado */
        color: whitesmoke; /* Blanco suave */
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05); /* Efecto hover en las tarjetas */
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
    }

    .btn-primary {
        background-color: #0d6efd; /* Azul Bootstrap */
        border-radius: 50px; /* Bordes redondeados */
        border: none;
        padding: 10px 20px;
        font-size: 1.2rem;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #0a58ca; /* Azul más oscuro */
    }

    .welcome-message {
        font-family: 'Poppins', sans-serif;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .quick-actions {
        font-family: 'Roboto', sans-serif;
        font-size: 1.1rem;
        margin-top: 20px;
    }

    .quick-actions a {
        color: #0d6efd;
        text-decoration: none;
    }

    .quick-actions a:hover {
        color: #0a58ca;
        text-decoration: underline;
    }

    /* Animación sutil en el botón */
    .btn-primary:focus {
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.5);
    }

    h2, h3 {
        font-family: 'Poppins', sans-serif;
        font-weight: bold;
    }

    p, label {
        font-family: 'Roboto', sans-serif;
    }
</style>

<!-- Barra de navegación -->
<nav class="navbar navbar-expand-lg navbar-dark"">
    <div class="container-fluid">
        <!-- Logo de la marca -->
        <a class="navbar-brand" href="#" style="font-family: 'Roboto', sans-serif; font-weight: 700; letter-spacing: 2px;">Buscar Servicios</a>

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
        </div>
    </div>
</nav>

<!-- Listado de Servicios -->


@endsection

