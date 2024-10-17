@extends('layouts.plantillain')

@section('titulo', 'Gestionar Empresas')

@section('contenido')

<style>
    .card {
        background-color: #3f3fd1; /* Azul personalizado */
        color: #f8f9fa;
        border-radius: 15px;
        transition: all 0.3s ease-in-out;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.6);
    }

    .btn-primary, .btn-danger {
        border-radius: 50px;
        border: none;
        padding: 10px 20px;
        font-size: 1.2rem;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #0a58ca;
    }

    .btn-danger:hover {
        background-color: #d9534f;
    }

    h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: bold;
    }

    p, label {
        font-family: 'Roboto', sans-serif;
    }

    .create-btn {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    .empty-state {
        font-size: 1.2rem;
        text-align: center;
        margin-top: 20px;
    }

    .empty-state a {
        color: #0d6efd;
        text-decoration: none;
        font-weight: bold;
    }

    .empty-state a:hover {
        text-decoration: underline;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4">Gestionar Mis Empresas</h2>

            <!-- Botón para crear nueva empresa -->
            <div class="create-btn">
                <a href="{{ route('crear-empresa') }}" class="btn btn-primary btn-lg">Crear Nueva Empresa</a>
            </div>

            <!-- Mensaje de éxito -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Listado de empresas -->
            @forelse($empresas as $empresa)
                <div class="card mb-4 shadow-lg p-4">
                    <h3>{{ $empresa->nombre }}</h3>
                    <p><strong>Slogan:</strong> {{ $empresa->slogan ?? 'N/A' }}</p>
                    <p><strong>Ubicación:</strong> {{ $empresa->ubicacion }}</p>
                    <p><strong>Rubros:</strong>
                        @if ($empresa->rubros->count())
                            {{ implode(', ', $empresa->rubros->pluck('nombre')->toArray()) }}
                        @else
                            No hay rubros asociados.
                        @endif
                    </p>

                    <div class="d-flex justify-content-end gap-2">
                        <!-- Botón de editar -->
                        <a href="{{ route('editar-empresa', $empresa->id) }}" class="btn btn-primary">Editar</a>
                        <!-- Botón de eliminar -->
                        <form action="{{ route('eliminar-empresa', $empresa->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta empresa?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            @empty
                <!-- Si no hay empresas, mostrar mensaje con enlace para crear una nueva -->
                <div class="empty-state">
                    No tienes empresas creadas. <a href="{{ route('crear-empresa') }}">Crea una aquí</a>.
                </div>
            @endforelse
        </div>
    </div>
</div>

@endsection
