
@extends('layouts.plantilla')

@section('titulo')
    MiServicio | Inicio
@endsection

@section('ruta')
    <a href="{{route('logout')}}"><button type="button" class="btn btn-outline-primary me-2">Salir</button></a>
@endsection

@section('contenido')
    <article class="container">
        <h2>Tu pagina principal</h2>
    </article>
@endsection

