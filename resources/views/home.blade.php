@extends('layouts.plantilla')

@section('titulo')
MiServicio
@endsection

@section('ruta')
  <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
@endsection

@section('contenido')
  <h2>Bienvenido a MiServicio</h2>
  <h4>Quienes somos</h4>
  <h6>MiServicio es una plataforma para contratar servicios de manera online.</h6>
@endsection