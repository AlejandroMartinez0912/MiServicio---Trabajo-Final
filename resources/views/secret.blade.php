@extends('layouts.plantilla')

@section('titulo')
    MiServicio | Panel
@endsection

@section('ruta')
<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
        Mi Cuenta
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
        <li><a class="dropdown-item" href="{{ route('home') }}" style="color: black;">Perfil</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="{{ route('home') }}" style="color: black;">Nueva empresa</a></li>
        <li><a class="dropdown-item" href="{{ route('home') }}" style="color: black;">Mis empresas</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="{{ route('home') }}" style="color: black;">Buscar servicio</a></li>
        <li><a class="dropdown-item" href="{{ route('home') }}" style="color: black;">Mis turnos</a></li>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">Salir</a></li>
    </ul>
</div>

@endsection

@section('contenido')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4 mb-4">Bienvenido a MiServicio</h1>
                <p class="lead mb-5">
                    Nos alegra que estés de vuelta. Aquí puedes gestionar tus servicios, actualizar tu perfil y descubrir nuevas ofertas.
                </p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3">Panel de Usuario</h4>
                        <p class="card-text text-center">
                            En este panel puedes gestionar todas tus actividades, desde la contratación de servicios hasta la actualización de tu perfil.
                        </p>
                        <p class="text-center">
                            Aprovecha las nuevas ofertas y especialistas disponibles en la plataforma. Estamos aquí para ayudarte a encontrar la solución perfecta para tus necesidades.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Mis Servicios</h5>
                        <p class="card-text">Consulta y gestiona los servicios que has contratado de manera sencilla.</p>
                        //Ruta
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Perfil</h5>
                        <p class="card-text">Actualiza tu información personal y preferencias.</p>
                        //Ruta                    
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Nuevas Ofertas</h5>
                        <p class="card-text">Descubre las nuevas ofertas y servicios disponibles.</p>
                        //Ruta
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
