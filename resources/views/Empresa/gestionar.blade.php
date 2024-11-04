@extends('layouts.plantillain')

@section('titulo', 'Gestionar Empresas')

@section('contenido')

<style>
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

    .btn-primary, .btn-danger {
        border-radius: 50px;
        border: none;
        padding: 10px 20px;
        font-size: 1.2rem;
    }

    .btn-danger:hover {
        background-color: #d9534f;
    }

    .btn-new {
        border-radius: 50px;
        padding: 10px 20px;
        font-size: 1.2rem;
        background-color: #0d6efd;
        color: white;
        transition: background-color 0.3s ease;
    }

    .btn-new:hover {
        background-color: #0a58ca;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="text-center mb-4" style="color: whitesmoke">Gestionar Mis Empresas</h2>

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
                    
                    <!-- Mostrar rubros -->
                    <p><strong>Rubros:</strong>
                        @if($empresa->rubros->isNotEmpty())
                            {{ $empresa->rubros->pluck('nombre')->join(', ') }}
                        @else
                            N/A
                        @endif
                    </p>

                    <div class="d-flex justify-content-end gap-2">
                        <!-- Botón de ver empresa-->
                        <a href="{{ route('gestion-empresa', $empresa->id) }}" class="btn btn-primary">Ver empresa</a>

                        <!-- Botón de eliminar (abre modal) -->
                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar{{ $empresa->id }}">
                            Eliminar
                        </button>
                    </div>
                </div>

                <!-- Modal de confirmación de eliminación -->
                <div class="modal fade" id="modalEliminar{{ $empresa->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $empresa->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalLabel{{ $empresa->id }}">Confirmar Eliminación</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Estás seguro de que deseas eliminar la empresa "{{ $empresa->nombre }}"?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form action="{{ route('eliminar-empresa', $empresa->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="alert alert-info text-center">
                    No tienes empresas creadas. <a href="{{ route('crear-empresa') }}">Crea una aquí</a>.
                </div>
            @endforelse

            <!-- Botón para agregar nueva empresa si hay empresas existentes -->
            @if ($empresas->isNotEmpty())
                <div class="text-center mt-4">
                    <a href="{{ route('crear-empresa') }}" class="btn btn-new">Agregar Nueva Empresa</a>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
