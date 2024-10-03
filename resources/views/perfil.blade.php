@extends('layouts.plantillain')

@section('titulo', 'MiServicio | Editar Perfil')

@section('contenido')

<style>
    .card {
        background-color: #3f3fd1; /* Azul personalizado */
        color: #f8f9fa; /* Blanco suave */
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05); /* Efecto hover en las tarjetas */
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
    }

    .form-control {
        border-radius: 10px; /* Bordes redondeados para los inputs */
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
        background-color: #0a58ca; /* Azul más oscuro */
    }

    .welcome-message {
        font-family: 'Poppins', sans-serif;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 20px;
    }

    h2, h3 {
        font-family: 'Poppins', sans-serif;
        font-weight: bold;
    }

    p, label {
        font-family: 'Roboto', sans-serif;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg p-4 mb-5">
                <h2 class="text-center mb-4">Editar Perfil</h2>

                <!-- Mostrar mensajes de éxito o error si existen -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
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
                    <form method="POST" action="{{ route('perfil-update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="text-center mb-4">
                            <label for="foto" class="form-label">Cambiar foto de perfil</label>
                            <input type="file" class="form-control" id="foto" name="foto">
                        </div>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $persona->nombre }}" required maxlength="50">
                        </div>

                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $persona->apellido }}" required maxlength="50">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label for="domicilio" class="form-label">Domicilio</label>
                            <input type="text" class="form-control" id="domicilio" name="domicilio" value="{{ $persona->domicilio }}" required maxlength="100">
                        </div>

                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ $persona->fecha_nacimiento }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="documento" class="form-label">Documento</label>
                            <input type="number" class="form-control" id="documento" name="documento" value="{{ $persona->documento }}" required maxlength="20">
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Número de Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" value="{{ $persona->telefono }}" required maxlength="15">
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Guardar Cambios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
