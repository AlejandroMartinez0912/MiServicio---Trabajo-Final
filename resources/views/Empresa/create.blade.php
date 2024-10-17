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
        background-color: #158192 !important; /* Color azul claro */
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
        background-color: #138496 !important; /* Azul más oscuro */
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
                    <form action="{{ route('guardar-empresa') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre de la empresa</label>
                            <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="slogan" class="form-label">Slogan</label>
                            <input type="text" name="slogan" class="form-control" id="slogan" value="{{ old('slogan') }}">
                        </div>

                        <div class="mb-3">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" name="ubicacion" class="form-control" id="ubicacion" value="{{ old('ubicacion') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="rubros" class="form-label">Seleccionar Rubros</label>
                            <select name="rubros[]" class="form-control select2" id="rubros" multiple required>
                                @foreach($rubros as $rubro)
                                    <option value="{{ $rubro->id }}">{{ $rubro->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">Guardar Empresa</button>
                        </div>
                    </form>
                </div>
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
        }).on('select2:select', function(e) {
            console.log('Rubro seleccionado:', e.params.data.text);
        });
    });
</script>

@endsection
