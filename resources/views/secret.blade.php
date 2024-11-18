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

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 28rem;">
        <h2 class="text-center mb-4">¡Bienvenido de nuevo, {{ Auth::user()->persona->nombre }}!</h2>
        <p class="text-center mb-3">Estamos encantados de tenerte de vuelta. Aquí tienes algunas acciones rápidas que puedes realizar:</p>

        <!-- Mostrar mensajes de error si existen -->
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
            <h3 class="text-center mb-4">Acciones rápidas</h3>
            
            <!-- Acciones rápidas después de iniciar sesión -->
            <div class="d-grid gap-2">
                <a href="{{ route('perfil') }}" class="btn btn-primary">Editar Perfil</a>
                <a href="{{ route('gestion-servicios') }}" class="btn btn-primary">Gestionar Mis Servicios</a>
                <a href="{{ route('index-cita') }}" class="btn btn-primary">Buscar Nuevos Servicios</a>
                <a href="{{ route('home') }}" class="btn btn-primary">Ver Mis Turnos</a>
            </div>

            <div class="quick-actions text-center mt-4">
                <p>¿Necesitas ayuda? Visita nuestra <a href="#">sección de soporte</a>.</p>
            </div>
        </div>
    </div>
</div>

@endsection

