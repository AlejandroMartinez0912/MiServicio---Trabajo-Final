
@extends('layouts.plantilla')

@section('titulo')
Inicio de Sesión
@endsection
@section('ruta')
  @endsection

@section('contenido')
    <form method="POST" action="{{route('inicia-sesion')}}">
        @csrf
        <div class="mb-3">
            <label for="emailInput" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="emailInput" name="email" required>
        </div>
        <div class="mb-3">
            <label for="passwordInput" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="passwordInput" name="password" required>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="rememberCheck" name="remember">
            <label class="form-check-label" for="rememberCheck">Mantener sesión iniciada</label>
        </div>
        <div>
            <p>¿No tienes cuenta? <a href="{{route('registro')}}">Regístrate</a></p>
        </div>
        <button type="submit" class="btn btn-primary">Acceder</button>
        <h2></h2>
    </form>
@endsection
