@extends('layouts.plantillain')

@section('titulo', 'MiServicio | Editar Perfil')

@section('contenido')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg p-4 mb-5 bg-light rounded">
                    <div class="card-header bg-primary text-white text-center rounded">
                        <h4>Editar Perfil</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
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
                                <button type="submit" class="btn btn-success btn-lg">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
