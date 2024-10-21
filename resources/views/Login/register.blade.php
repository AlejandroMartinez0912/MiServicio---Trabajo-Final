@extends('layouts.plantilla')

@section('titulo')
    Registrarse
@endsection

@section('ruta')
@endsection

@section('contenido')

<style>
    body {
        background-color: #f8f9fa; /* Fondo claro para mejor contraste */
    }

    .card {
        background-color: #3f3fd1; /* Color de fondo de la tarjeta */
        color: whitesmoke; /* Color del texto */
        border-radius: 15px; /* Bordes redondeados */
        transition: all 0.3s ease-in-out; /* Transición suave */
        margin-top: 60px; /* Espacio desde la parte superior */
        margin-bottom: 60px; /* Espacio desde la parte inferior */
        padding: 20px; /* Espacio interno */
    }

    .card:hover {
        transform: scale(1.05); /* Animación de hover */
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
    }

    .btn-primary {
        background-color: #0d6efd; /* Azul Bootstrap */
        border-radius: 50px; /* Bordes redondeados */
        border: none; /* Sin bordes */
        padding: 10px 20px; /* Espacio interno */
        font-size: 1.2rem; /* Tamaño de fuente */
        transition: background-color 0.3s ease-in-out; /* Transición de color */
    }

    .btn-primary:hover {
        background-color: #0a58ca; /* Azul más oscuro al pasar el ratón */
    }

    .form-control {
        border-radius: 10px; /* Bordes redondeados para los inputs */
        width: 100%; /* Asegura que los campos ocupen el ancho completo de su contenedor */
        max-width: 400px; /* Limitar el ancho máximo de los inputs */
    }

    h2, h3 {
        font-family: 'Poppins', sans-serif;
        font-weight: bold;
        text-align: center; /* Centrar el texto */
    }

    p, label {
        font-family: 'Roboto', sans-serif;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .form-group {
        flex: 1; /* Los campos ocupan el mismo espacio */
        margin-right: 10px; /* Espacio entre campos */
    }

    .form-group:last-child {
        margin-right: 0; /* Sin margen en el último campo */
    }

    /* Espaciado para los mensajes de error */
    .alert {
        margin-bottom: 1rem;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <h2 class="mb-4">Únete a <span class="text-primary">MiServicio</span></h2>
                <p class="text-center mb-3">Regístrate para ser parte de nuestra comunidad.</p>
                <div class="card-body">

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

                    <form method="POST" action="{{ route('validar-registro') }}">
                        @csrf

                        <div class="form-row">
                            <div class="form-group">
                                <label for="emailInput" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="emailInput" name="email" value="{{ old('email') }}" required placeholder="Ingresa tu correo">
                            </div>

                            <div class="form-group">
                                <label for="passwordInput" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="passwordInput" name="password" required placeholder="Crea una contraseña">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="nombreInput" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombreInput" name="nombre" value="{{ old('nombre') }}" required placeholder="Ingresa tu nombre">
                            </div>

                            <div class="form-group">
                                <label for="apellidoInput" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellidoInput" name="apellido" value="{{ old('apellido') }}" required placeholder="Ingresa tu apellido">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="documentoInput" class="form-label">Documento</label>
                                <input type="number" class="form-control" id="documentoInput" name="documento" value="{{ old('documento') }}" required placeholder="Ingresa tu documento">
                            </div>

                            <div class="form-group">
                                <label for="telefonoInput" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefonoInput" name="telefono" value="{{ old('telefono') }}" required placeholder="Ingresa tu teléfono">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="domicilioInput" class="form-label">Domicilio</label>
                            <input type="text" class="form-control" id="domicilioInput" name="domicilio" value="{{ old('domicilio') }}" required placeholder="Ingresa tu domicilio">
                        </div>

                        <div class="form-group">
                            <label for="fechaNacimientoInput" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fechaNacimientoInput" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </div>

                        <div class="mt-3 text-center">
                            <p>¿Ya tienes una cuenta? <a href="{{ route('home') }}">Inicia sesión</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
