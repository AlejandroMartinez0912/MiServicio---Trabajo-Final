@extends('layouts.plantillain')

@section('titulo', 'Gestion de cita')

@section('contenido')

<div class="container mt-4">
    <h2>Gestión de Citas</h2>
    <!-- Barra de navegación con pestañas -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="crear-cita-tab" data-bs-toggle="tab" href="#crear-cita" role="tab" aria-controls="buscar-servicio" aria-selected="false">Buscar Servicios</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="ver-citas-tab" data-bs-toggle="tab" href="#ver-citas" role="tab" aria-controls="mis-citas" aria-selected="true">Mis Citas</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="historial-citas-tab" data-bs-toggle="tab" href="#historial-citas" role="tab" aria-controls="historial-citas" aria-selected="false">Historial de Citas</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="mi-perfil-tab" data-bs-toggle="tab" href="#mi-perfil" role="tab" aria-controls="mi-perfil" aria-selected="false">Mi Perfil</a>
        </li>
    </ul>


    <!-- Contenido de las pestañas -->
    <div class="tab-content" id="myTabContent">


        <!-- Buscar Servicios -->
        <div class="tab-pane fade show active" id="crear-cita" role="tabpanel" aria-labelledby="buscar-servicio-tab">
            <h3>Buscar Servicios</h3>
             <!-- Campo de búsqueda -->
            <div class="mb-3">
                <label for="buscarServicio" class="form-label">Buscar Servicio</label>
                <input type="text" id="buscarServicio" class="form-control" placeholder="Buscar un servicio...">
            </div>

            <!-- Lista de servicios filtrada -->
            <ul id="serviciosList" class="list-group">
                @foreach($servicios as $servicio)
                    <li class="list-group-item d-flex justify-content-between align-items-center" data-servicio-id="{{ $servicio->id }}">
                        <span>{{ $servicio->nombre }}</span> <!-- Nombre del servicio -->
                        
                        <!-- Botón para ver el servicio -->
                        <button class="btn btn-info btn-sm" data-bs-toggle="collapse" data-bs-target="#servicioDetails{{ $servicio->id }}" aria-expanded="false" aria-controls="servicioDetails{{ $servicio->id }}">
                            Ver Servicio
                        </button>
                    </li>
            
                    <!-- Cuadro de detalles del servicio -->
                    <div class="collapse" id="servicioDetails{{ $servicio->id }}">
                        <div class="card card-body mt-3">
                            <h5>{{ $servicio->nombre }}</h5>
                            <p>Precio: ${{ $servicio->precio_base }}</p>
                            <p>Duración: {{ $servicio->duracion }}</p>
                            <p>Calificación: {{ $servicio->calificacion }}</p>
                            <p>{{ $servicio->descripcion }}</p>

                            <p class="font-weight-bold">Rubros:</p>
                            <ul class="list-group list-group-flush">
                                @foreach ($servicio->rubros as $rubro)
                                    <li class="list-group-item">{{ $rubro->nombre }}</li>
                                @endforeach
                            </ul>
                            
                            <!-- Botón para agendar cita -->
                            <button class="btn btn-primary" onclick="agendarCita({{ $servicio->id }})">Agendar Cita</button>
                        </div>
                    </div>
                @endforeach
            </ul>
            <!-- Scripts de busqueda-->
            <script>
                // Función para filtrar servicios
                $(document).ready(function(){
                    $('#buscarServicio').on('input', function() {
                        var query = $(this).val().toLowerCase(); // Obtiene el texto ingresado
            
                        $('#serviciosList li').each(function() {
                            var servicioNombre = $(this).text().toLowerCase();
            
                            // Mostrar o ocultar el servicio según el texto
                            if (servicioNombre.indexOf(query) !== -1) {
                                $(this).show(); // Mostrar el servicio si coincide
                            } else {
                                $(this).hide(); // Ocultar el servicio si no coincide
                            }
                        });
                    });
                });
            </script>
        </div>

        <!-- Ver Citas -->
        <div class="tab-pane fade" id="ver-citas" role="tabpanel" aria-labelledby="mis-citas-tab">
            <h3>Mis Citas</h3>
            
        </div>

        <!-- Historial de Citas -->
        <div class="tab-pane fade" id="historial-citas" role="tabpanel" aria-labelledby="historial-citas-tab">
            <h3>Historial de Citas</h3>
            
        </div>
    </div>
</div>

@endsection

