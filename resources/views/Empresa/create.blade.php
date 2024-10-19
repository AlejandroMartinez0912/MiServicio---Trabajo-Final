@extends('layouts.plantillain')

@section('titulo', 'Crear Empresa')

@section('contenido')

<style>
    /* Estilos personalizados */
    .card {
        background-color: #3f3fd1;
        color: #f8f9fa;
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
    }

    .form-control {
        border-radius: 10px;
    }

    .btn {
        border-radius: 50px;
        border: none;
        padding: 10px 20px;
        font-size: 1.2rem;
        transition: background-color 0.3s ease-in-out;
        width: 48%; /* Asegura que ambos botones tengan el mismo tamaño */
    }

    .btn-primary {
        background-color: #0d6efd;
    }

    .btn-primary:hover {
        background-color: #0a58ca;
    }

    .btn-secondary {
        background-color: #6c757d; /* Color gris */
    }

    .btn-secondary:hover {
        background-color: #5a6268; /* Color gris más oscuro */
    }

    .welcome-message, h2, h3 {
        font-family: 'Poppins', sans-serif;
        font-weight: bold;
    }

    p, label {
        font-family: 'Roboto', sans-serif;
    }

    /* Estilos personalizados para Select2 */
    .select2-container {
        width: 100% !important;
    }

    .select2-selection--multiple {
        min-height: 60px;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #ced4da;
    }

    /* Estilo del rubro seleccionado */
    .select2-selection__choice {
        background-color: #0d6efd !important; /* Color azul claro */
        color: #fff !important; /* Texto blanco */
        border-radius: 25px;
        padding: 5px 10px;
        margin: 3px;
        font-size: 0.9rem;
    }

    /* Botón de eliminar rubro */
    .select2-selection__choice__remove {
        color: #f8d7da !important;
        margin-right: 8px;
        cursor: pointer;
    }

    /* Hover sobre rubro seleccionado */
    .select2-selection__choice:hover {
        background-color: #0d6efd !important; /* Azul más oscuro */
    }

    /* Estilo para la imagen de perfil */
    .profile-pic {
        width: 100px; /* Ajusta el tamaño según sea necesario */
        height: 100px; /* Ajusta el tamaño según sea necesario */
        border-radius: 50%; /* Crea el efecto de círculo */
        border: 2px dashed #f8f9fa; /* Borde de la imagen */
        display: flex;
        align-items: center; /* Centra verticalmente el contenido */
        justify-content: center; /* Centra horizontalmente el contenido */
        margin: 0 auto; /* Centra el elemento en el contenedor */
        cursor: pointer;
        position: relative;
    }

    .profile-pic img {
        border-radius: 50%;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Estilo para el input oculto */
    input[type="file"] {
        display: none; /* Oculta el input */
    }

    .upload-icon {
        font-size: 24px; /* Tamaño del icono */
        color: #f8f9fa; /* Color del icono */
        text-align: center; /* Centra el icono en su contenedor */
        display: flex; /* Usa flexbox para centrar el icono */
        align-items: center; /* Centra verticalmente el icono */
        justify-content: center; /* Centra horizontalmente el icono */
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg p-4 mb-5">
                <h2 class="text-center mb-4">
                    <i class='bx bxs-business'></i> Crear Empresa
                </h2>

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
                    <form id="empresaForm" action="{{ route('guardar-empresa') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h3 class="text-center mb-3">Información de la Empresa</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre de la empresa</label>
                                    <input type="text" name="nombre" class="form-control" id="nombre" 
                                        value="{{ old('nombre') }}" 
                                        placeholder="Nombre de la empresa" required>
                                </div>

                                <div class="mb-3">
                                    <label for="slogan" class="form-label">Slogan</label>
                                    <input type="text" name="slogan" class="form-control" id="slogan" 
                                        value="{{ old('slogan') }}" 
                                        placeholder="Slogan de la empresa">
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <label class="form-label">Logo</label>
                                <div class="profile-pic" onclick="document.getElementById('logo').click()">
                                    <input type="file" name="logo" class="form-control" id="logo" accept="image/*">
                                    <span class="upload-icon"><i class='bx bxs-upload'></i></span>
                                </div>
                            </div>
                        </div>

                        <h3 class="text-center mb-3">Rubro/s</h3>
                        <div class="mb-3">
                            <label for="rubros" class="form-label">Selecciona uno o más rubros</label>
                            <select name="rubros[]" class="form-control select2" id="rubros" multiple required>
                                @foreach($rubros as $rubro)
                                    <option value="{{ $rubro->id }}">{{ $rubro->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <h3 class="text-center mb-3">Ubicación</h3>
                        <div class="mb-3">
                            <label for="ubicacion" class="form-label">Dirección de la empresa</label>
                            <input type="text" name="ubicacion" class="form-control" id="ubicacion" 
                                value="{{ old('ubicacion') }}" 
                                placeholder="Dirección de la empresa" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">Crear Empresa</button>
                            <a href="{{ route('gestionar-empresas') }}" class="btn btn-secondary">Volver</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Confirmación -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirmación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas crear esta empresa? Por favor, verifica la información antes de continuar.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="confirmBtn">Confirmar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#rubros').select2({
            placeholder: "Seleccione uno o más rubros",
            allowClear: true,
            width: '100%'
        });

        $('#confirmBtn').on('click', function() {
            $('#empresaForm').submit();
        });
    });
</script>

@endsection
