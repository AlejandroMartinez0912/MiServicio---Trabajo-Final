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

    .btn {
        border-radius: 50px; /* Bordes redondeados */
        border: none; /* Sin bordes */
        padding: 10px 20px;
        font-size: 1.2rem;
        transition: background-color 0.3s ease-in-out;
        width: 100%; /* Ancho completo para los botones */
    }

    .btn-primary {
        background-color: #0d6efd; /* Azul Bootstrap */
    }

    .btn-primary:hover {
        background-color: #0a58ca; /* Azul oscuro */
    }

    .btn-secondary {
        background-color: #6c757d; /* Gris */
    }

    .btn-secondary:hover {
        background-color: #5a6268; /* Gris oscuro */
    }

    .form-control {
        border-radius: 10px; /* Bordes redondeados para los inputs */
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
                    <p>¿No tienes cuenta? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Regístrate</a></p>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Acceder</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de registro mejorado -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Tamaño del modal ampliado -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-center w-100" id="registerModalLabel">Regístrate en <span class="text-primary">MiServicio</span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registrationForm" method="POST" action="{{ route('validar-registro') }}">
                    @csrf
                    <div class="row g-3"> <!-- Distribución en dos columnas -->
                        <div class="col-md-6">
                            <label for="emailRegister" class="form-label">Correo electrónico</label>
                            <input type="email" class="form-control" id="emailRegister" name="email" required placeholder="Ingresa tu correo">
                        </div>

                        <div class="col-md-6">
                            <label for="passwordRegister" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="passwordRegister" name="password" required placeholder="Crea una contraseña">
                        </div>

                        <div class="col-md-6">
                            <label for="nombreRegister" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombreRegister" name="nombre" required placeholder="Ingresa tu nombre">
                        </div>

                        <div class="col-md-6">
                            <label for="apellidoRegister" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellidoRegister" name="apellido" required placeholder="Ingresa tu apellido">
                        </div>

                        <div class="col-md-6">
                            <label for="documentoRegister" class="form-label">Documento</label>
                            <input type="number" class="form-control" id="documentoRegister" name="documento" required placeholder="Ingresa tu documento">
                        </div>

                        <div class="col-md-6">
                            <label for="telefonoRegister" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefonoRegister" name="telefono" required placeholder="Ingresa tu teléfono">
                        </div>

                        <div class="col-md-6">
                            <label for="domicilioRegister" class="form-label">Domicilio</label>
                            <input type="text" class="form-control" id="domicilioRegister" name="domicilio" required placeholder="Ingresa tu domicilio">
                        </div>

                        <div class="col-md-6">
                            <label for="fechaNacimientoRegister" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fechaNacimientoRegister" name="fecha_nacimiento" required>
                        </div>
                    </div>
                    
                    <div class="modal-footer mt-4">
                        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection
