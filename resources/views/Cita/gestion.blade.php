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
            <a class="nav-link" id="trabajo-tab" data-bs-toggle="tab" href="#trabajo" role="tab" aria-controls="horarios" aria-selected="false">horarios trabajo</a>
        </li>
    </ul>


    <!-- Contenido de las pestañas -->
    <div class="tab-content" id="myTabContent">

        <!-- Buscar Servicios -->
        <div class="tab-pane fade show active" id="crear-cita" role="tabpanel" aria-labelledby="buscar-servicio-tab">
            <div class="card shadow-lg mb-5" id="card-citas"> 
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
                                <p>Duración: {{ $servicio->duracion_estimada }}</p>
                                @if ($servicio->calificacion == 0.0 )
                                    <p>Calificación: No calificado</p>
                                @else
                                    <p>Calificación: {{ $servicio->calificacion }}</p>
                                @endif
                                <p class="font-weight-bold">Rubros:</p>
                                <ul class="list-group list-group-flush">
                                    @foreach ($servicio->rubros as $rubro)
                                        <li class="list-group-item">{{ $rubro->nombre }}</li>
                                    @endforeach
                                </ul>
                                <!-- Botón para agendar cita -->
                                <!-- Botón para abrir el modal -->
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgendarCita{{ $servicio->id }}" 
                                    onclick="pasarIdServicio({{ $servicio->id }})">
                                    Agendar Cita
                                </button>
                                <!-- Modal para Agendar Cita -->
                                <div class="modal fade" id="modalAgendarCita{{ $servicio->id }}" tabindex="-1" aria-labelledby="modalAgendarCitaLabel{{ $servicio->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalAgendarCitaLabel{{ $servicio->id }}">Agendar Cita</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('guardar-cita') }}" method="POST">
                                                @csrf <!-- Token de seguridad -->
                                                <div class="modal-body">
                                                    <!-- Campo oculto para el ID del servicio -->
                                                    <input type="hidden" id="modal-servicio-id" name="servicio_id">
                                                    <!-- Fecha -->
                                                    <div class="mb-3">
                                                        <label for="fecha" class="form-label">Fecha</label>
                                                        <input type="date" id="fecha" name="fecha" class="form-control" required>
                                                    </div>
                                
                                                    <!-- Hora -->
                                                    <div class="mb-3">
                                                        <label for="hora" class="form-label">Hora</label>
                                                        <input type="time" id="hora" name="hora" class="form-control" required>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-primary">Confirmar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                
                                <script>
                                    function pasarIdServicio(servicioId) {
                                        // Asigna el ID del servicio al campo oculto en el modal
                                        document.getElementById('modal-servicio-id').value = servicioId;
                                    }
                                </script>
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
        </div>

        <!-- Ver Citas -->
        <div class="tab-pane fade" id="ver-citas" role="tabpanel" aria-labelledby="mis-citas-tab">
            <div class="card shadow-lg mb-5" id="card-citas"> 
                <h3>Mis Citas</h3>
                <!-- Cuadro con todas las citas asociadas al id persona-->
                @if($citas->isEmpty())
                    <p>No tienes citas agendadas.</p>
                @else
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Servicio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                                <th>Estado</th>
                                <th>Comentarios</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($citas as $cita)
                                <tr>
                                    <td>{{ $cita->servicio->nombre }}</td> <!-- Mostrar nombre del servicio -->
                                    <td>{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d/m/Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cita->horaCita)->format('H:i') }}</td>
                                    <td>{{ ucfirst($cita->estadoCita) }}</td> <!-- Mostrar el estado de la cita -->
                                    <td>{{ $cita->comentariosCliente ?? 'No hay comentarios' }}</td> <!-- Mostrar comentarios si existen -->
                                    <td>
                                        <a href="{{ route('editar-cita', ['id' => $cita->idCita]) }}" class="btn btn-primary">Editar</a>
                                        <!-- Botón de eliminar -->
                                        <form action="{{ route('eliminar-cita', ['id' => $cita->idCita]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
            
        </div>


        <!-- Historial de Citas -->
        <div class="tab-pane fade" id="historial-citas" role="tabpanel" aria-labelledby="historial-citas-tab">
            <h3>Historial de Citas</h3>
            
        </div>

        <!-- Trabajo -->
        <div class="tab-pane fade" id="trabajo" role="tabpanel" aria-labelledby="trabajo-tab">
            <h3>Trabajo</h3>
            <!-- Obtener horarios asociados al servicio a traves de datos profesion-->
                      
        </div>
    </div>
</div>

@endsection

