@extends('layouts.plantillain')

@section('titulo', 'Editar Perfil')

@section('contenido')

<style>
    .card {
        background-color: #3f3fd1; /* Color de fondo de la tarjeta */
        color: whitesmoke; /* Color del texto */
        border-radius: 15px; /* Bordes redondeados */
        transition: all 0.3s ease-in-out; /* Transición suave */
        padding: 20px; /* Espaciado interno */
    }

    .card-body {
        display: flex; /* Hacer que el cuerpo de la tarjeta use flexbox */
        align-items: center; /* Alinear elementos verticalmente */
    }

    .form-container {
        flex: 1; /* Ocupa el espacio restante */
        margin-right: 20px; /* Espacio entre el formulario y la imagen */
    }

    .form-control {
        border-radius: 10px; /* Bordes redondeados para los inputs */
        width: 100%; /* Asegura que los campos ocupen el ancho completo de su contenedor */
        max-width: 400px; /* Limitar el ancho máximo de los inputs */
    }

    .profile-pic {
        width: 100px; /* Ancho de la imagen de perfil */
        height: 100px; /* Alto de la imagen de perfil */
        border-radius: 50%; /* Hacer que sea circular */
        background-color: grey; /* Color de fondo cuando no hay imagen */
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer; /* Cambiar el cursor para indicar que es clickable */
        margin-left: 20px; /* Espacio a la izquierda de la imagen */
    }

    .profile-pic img {
        border-radius: 50%; /* Asegurar que la imagen también sea circular */
        width: 100%; /* Asegura que la imagen se ajuste al contenedor */
        height: auto; /* Mantiene la proporción de la imagen */
    }

    .btn-primary {
        background-color: #0d6efd; /* Azul Bootstrap */
        border-radius: 50px; /* Bordes redondeados */
        border: none; /* Sin bordes */
        padding: 10px 20px; /* Espaciado interno */
        font-size: 1.2rem; /* Tamaño de fuente */
        transition: background-color 0.3s ease-in-out; /* Transición de color */
    }

    .btn-primary:hover {
        background-color: #0a58ca; /* Azul más oscuro al pasar el ratón */
    }

    .welcome-message {
        font-family: 'Poppins', sans-serif;
        font-size: 1.5rem; /* Tamaño del mensaje de bienvenida */
        font-weight: bold; /* Negrita */
        margin-bottom: 20px; /* Espaciado inferior */
    }

    h2, h3 {
        font-family: 'Poppins', sans-serif; /* Fuente para los títulos */
        font-weight: bold; /* Negrita */
        text-align: center; /* Centrar el texto */
    }

    p, label {
        font-family: 'Roboto', sans-serif; /* Fuente para párrafos y etiquetas */
    }

    .form-group {
        text-align: left; /* Alinear a la izquierda para los campos del formulario */
        margin-bottom: 1rem; /* Espaciado inferior */
    }
    .btn-custom-gray {
    background-color: grey; 
    color: white;
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

                        <form id="editProfileForm" method="POST" action="{{ route('perfil-update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $persona->nombre }}" required maxlength="50">
                            </div>

                            <div class="form-group">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="{{ $persona->apellido }}" required maxlength="50">
                            </div>

                            <div class="form-group">
                                <label for="domicilio" class="form-label">Domicilio</label>
                                <input type="text" class="form-control" id="domicilio" name="domicilio" value="{{ $persona->domicilio }}" required maxlength="100">
                            </div>

                            <div class="form-group">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ $persona->fecha_nacimiento }}" required>
                            </div>

                            <div class="form-group">
                                <label for="documento" class="form-label">Documento</label>
                                <input type="number" class="form-control" id="documento" name="documento" value="{{ $persona->documento }}" required maxlength="20">
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
                            <i class='bx bx-user' style="color: white; font-size: 50px;"></i> <!-- Ícono de usuario si no hay foto -->
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
<!--  Script de alertas-->
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
