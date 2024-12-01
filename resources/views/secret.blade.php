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

    </div>
</nav>


@endsection

