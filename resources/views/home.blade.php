@extends('layouts.miservicio')

@section('titulo', 'MiServicio')

<style>
    span {
        color: #ff00cc;
    }
</style>
@section('contenido')
   <div class="container-fluid d-flex align-items-center justify-content-center min-vh-100">
        <div class="row justify-content-center w-100 text-center">
            <!-- Título de la página -->
            <div class="col-12 mb-4" style="background: linear-gradient(90deg, #ff00cc, #333399); padding: 40px 20px; border-radius: 10px;">
                <h1 class="text-light display-4">Bienvenido a <strong>MiServicio</strong></h1>
                <p class="text-light lead">Tu plataforma para encontrar profesionales calificados en diversas áreas</p>
            </div>
            


            <!-- Sección de beneficios o características -->
            <div class="col-12 mt-5">
                <h2 class="text-light mb-4">¿Por qué elegir MiServicio?</h2>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-dark shadow-lg">
                            <div class="card-body">
                                <i class="bx bxs-briefcase-alt-2 icon display-3 mb-3"></i>
                                <h5 class="card-title">Profesionales Verificados</h5>
                                <p class="card-text">Nuestros expertos están altamente calificados y verificados para asegurar la calidad de su trabajo.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-dark shadow-lg">
                            <div class="card-body">
                                <i class="bx bx-credit-card icon display-3 mb-3"></i>
                                <h5 class="card-title">Pago Seguro</h5>
                                <p class="card-text">Aprovecha la integración con Mercado Pago para realizar pagos rápidos y seguros.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 mb-3">
                        <div class="card text-white bg-dark shadow-lg">
                            <div class="card-body">
                                <i class="bx bx-calendar icon display-3 mb-3"></i>
                                <h5 class="card-title">Agenda Flexible</h5>
                                <p class="card-text">Gestiona tu agenda de manera fácil y flexible para una experiencia más cómoda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Testimonios (opcional) -->
            <div class="col-12 mt-5">
                <h2 class="text-light mb-4">Lo que dicen nuestros usuarios</h2>
                <div id="carouselTestimonios" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <p class="text-light">"MiServicio me ayudó a encontrar un electricista de confianza rápidamente. ¡Totalmente recomendado!"</p>
                            <footer class="blockquote-footer text-light">Ana Pérez, Cliente</footer>
                        </div>
                        <div class="carousel-item">
                            <p class="text-light">"Los profesionales son muy buenos. Tuve una experiencia excelente con el plomero que contraté."</p>
                            <footer class="blockquote-footer text-light">Carlos Díaz, Cliente</footer>
                        </div>
                        <div class="carousel-item">
                            <p class="text-light">"La plataforma es fácil de usar y segura. Definitivamente volveré a usarla."</p>
                            <footer class="blockquote-footer text-light">Laura Gómez, Cliente</footer>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselTestimonios" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselTestimonios" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
