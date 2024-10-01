@extends('layouts.plantilla')

@section('titulo')
    MiServicio
@endsection

@section('ruta')
    <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
@endsection


@section('contenido')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <p class="lead mb-5">
                    MiServicio es una plataforma innovadora que conecta a clientes con especialistas en diversas áreas, permitiéndote contratar servicios de manera sencilla y rápida desde la comodidad de tu hogar.
                </p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-3">¿Quiénes somos?</h4>
                        <p class="card-text text-center">
                            Somos una plataforma comprometida en ofrecer soluciones rápidas y eficaces para todos tus problemas domésticos o profesionales. Con MiServicio, podrás contratar expertos en áreas como plomería, electricidad, carpintería y mucho más.
                        </p>
                        <p class="text-center">
                            Nuestra misión es brindar una experiencia de calidad tanto para los clientes como para los especialistas que se unen a nuestra plataforma, asegurando confianza, seguridad y eficiencia en cada servicio ofrecido.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Fácil de usar</h5>
                        <p class="card-text">Encuentra especialistas rápidamente y gestiona tus servicios en solo unos clics.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Confianza y Seguridad</h5>
                        <p class="card-text">Todos nuestros especialistas están verificados para ofrecerte la mejor calidad y seguridad.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Soporte 24/7</h5>
                        <p class="card-text">Estamos aquí para ayudarte en cualquier momento, con atención al cliente de calidad.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
