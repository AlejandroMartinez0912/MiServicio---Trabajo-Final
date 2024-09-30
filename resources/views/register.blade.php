@extends('layouts.plantilla')

@section('titulo')
    MiServicio | Registrarse
@endsection

@section('ruta')
@endsection

@section('contenido')

    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow" style="width: 25rem;">
            <div class="card-body">
                <h3 class="card-title text-center mb-4">Registrarse</h3>
                <form method="POST" action="{{ route('validar-registro') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="userInput" class="form-label">Nombre y Apellido</label>
                        <input type="text" class="form-control" id="userInput" name="name" required autocomplete="disable">
                    </div>

                    <div class="mb-3">
                        <label for="emailInput" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailInput" name="email" required autocomplete="disable">
                    </div>

                    <div class="mb-3">
                        <label for="passwordInput" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="passwordInput" name="password" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Registrarse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
