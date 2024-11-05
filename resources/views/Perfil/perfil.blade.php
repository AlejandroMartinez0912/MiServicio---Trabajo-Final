@extends('layouts.plantillain')

@section('titulo', 'Editar Perfil')

@section('contenido')

<style>
    .card {
        background-color: #3f3fd1;
        color: whitesmoke;
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
        padding: 20px;
    }

    .card-body {
        display: flex;
        align-items: center;
    }

    .form-container {
        flex: 1;
        margin-right: 20px;
    }

    .form-control {
        border-radius: 10px;
        width: 100%;
        max-width: 400px;
    }

    .form-control[readonly] {
        background-color: #e9ecef; /* Fondo gris claro para campos de solo lectura */
        color: #495057;
    }

    .profile-pic {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: grey;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        margin-left: 20px;
    }

    .btn-primary {
        background-color: #0d6efd;
        border-radius: 50px;
        border: none;
        padding: 10px 20px;
        font-size: 1.2rem;
        transition: background-color 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #0a58ca;
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
        text-align: center;
    }

    p, label {
        font-family: 'Roboto', sans-serif;
    }

    .form-group {
        text-align: left;
        margin-bottom: 1rem;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg mb-5">
                <div class="card-body d-flex align-items-center">
                    <div class="form-container">
                        <h2 class="mb-4 text-center">
                            <i class='bx bx-user'></i> Editar Perfil</h2>

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

                        <form id="editProfileForm" method="POST" action="{{ route('perfil-update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Campos solo visualización -->
                            <div class="form-group">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $persona->nombre }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $persona->apellido }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="documento" class="form-label">Documento</label>
                                <input type="text" class="form-control" id="documento" name="documento" value="{{ $persona->documento }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ $persona->fecha_nacimiento }}" readonly>
                            </div>

                            <!-- Campos editables -->
                            <div class="form-group">
                                <label for="domicilio" class="form-label">Domicilio</label>
                                <input type="text" class="form-control" id="domicilio" name="domicilio" value="{{ $persona->domicilio }}" required maxlength="100">
                            </div>

                            <div class="form-group">
                                <label for="telefono" class="form-label">Número de Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" value="{{ $persona->telefono }}" required maxlength="15">
                            </div>
                        </form>
                    </div>

                    <div class="profile-pic" data-bs-toggle="modal" data-bs-target="#uploadModal">
                        @if ($persona->foto)
                            <img src="{{ asset('storage/' . $persona->foto) }}" alt="Foto de Perfil">
                        @else
                            <i class='bx bx-user' style="color: white; font-size: 50px;"></i>
                        @endif
                    </div>
                </div>
                <div class="d-grid gap-2 mt-3">
                    <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#confirmModal">Guardar Cambios</button>
                    <a href="{{ route('privada') }}" class="btn btn-secondary btn-lg">Volver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de carga de imagen -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Cambiar Foto de Perfil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('perfil-update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="foto" class="form-label">Selecciona una nueva foto de perfil</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Cambiar Foto</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas guardar los cambios en tu perfil?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmButton">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('confirmButton').addEventListener('click', function () {
        document.getElementById('editProfileForm').submit();
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: '{{ session('success') }}',
                confirmButtonText: 'Aceptar'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonText: 'Aceptar'
            });
        @endif
    });
</script>

@endsection
