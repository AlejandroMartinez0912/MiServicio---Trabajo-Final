@extends('layouts.plantilla')

@section('titulo')
    MiServicio
@endsection

@section('ruta')
    
@endsection

@section('contenido')

<style>
    .card {
        background-color: #343a40; /* Gris oscuro */
        color: #f8f9fa; /* Blanco suave */
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05); /* Animación de hover */
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
    }

    .btn-primary {
        background-color: #0d6efd; /* Azul Bootstrap */
        border-radius: 50px; /* Bordes redondeados */
        border: none; /* Sin bordes */
        padding: 10px 20px;
        font-size: 1.2rem;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #0a58ca; /* Azul oscuro */
    }

    .form-control {
        border-radius: 10px; /* Bordes redondeados para los inputs */
    }

    .form-check-input {
        border-radius: 5px; /* Bordes redondeados para el checkbox */
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

    a {
        color: #0d6efd;
        text-decoration: none;
    }

    a:hover {
        color: #0a58ca;
        text-decoration: underline;
    }
</style>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow-lg" style="width: 28rem;">
        <h2 class="text-center mb-4">Bienvenido a <span class="text-primary">MiServicio</span></h2>
        <p class="text-center mb-3">Inicia sesión para formar parte de nuestra comunidad.</p>
        <div class="card-body">
            <h3 class="card-title text-center mb-4">Iniciar Sesión</h3>
            
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
            
            <form method="POST" action="{{ route('inicia-sesion') }}">
                @csrf
                <div class="mb-3">
                    <label for="emailInput" class="form-label">Correo electrónico</label>
                    <input type="email" class="form-control" id="emailInput" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="mb-3">
                    <label for="passwordInput" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="passwordInput" name="password" required>
                </div>

                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberCheck" name="remember">
                    <label class="form-check-label" for="rememberCheck">Mantener sesión iniciada</label>
                </div>

                <div class="mb-3 text-center">
                    <p>¿No tienes cuenta? <a href="{{ route('registro') }}">Regístrate</a></p>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Acceder</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
