@extends ('layouts.administracion')

@section('titulo', 'MiServicio | Perfil Profesional')

@section('contenido')

<!-- Recibe de la ruta admin-ver-perfil -->

<div class="container mt-5">

    <div id="header" class="mb-4">
        <h3><strong>Gestion de profesion - {{ $profesion->nombre_fantasia }}</strong></h3>
        <!-- Volver a pagiina anterior-->
        <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">Volver</a>
    </div>

    <!-- Información del Usuario -->
    <div class="mb-4">
        <h4><strong> Profesional: {{ $profesion->user->persona->nombre }} {{ $profesion->user->persona->apellido }}</strong></h4>
    </div>

    <!-- Tabla de Información del Usuario -->
    <table class="table table-striped">

        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre Fantasia</th>
                <th scope="col">Apellido</th>
                <th scope="col">Mail</th>
                <th scope="col">Estado</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $profesion->id }}</td>
                <!-- nombre y apellido de usuario, que estan en la tabla persona-->
                <td>{{ $profesion->nombre_fantasia }}</td>

                <!-- nombre y apellido de usuario, que estan en la tabla persona-->
                <td>{{ $profesion->user->persona->nombre  }} {{ $profesion->user->persona->apellido }}</td>
                <!-- Mail-->
                <td>{{ $profesion->user->email }}</td>

                <!-- Estado -->
                @php
                    $estado = $profesion->estado;
                    if ($estado == 1) {
                        $estado = 'Activo';
                    } else {
                        $estado = 'Inactivo';
                    }
                @endphp
                <td>{{ $estado }}</td>
                <td>
                    @if ($profesion->estado == 1)
                                <!-- Modal para desactivar cuenta de Profesional -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#desactivarModalProfesion{{ $profesion->id }}">
                                    Desactivar Profesional
                                </button>
                                <div class="modal fade" id="desactivarModalProfesion{{ $profesion->id }}" tabindex="-1" aria-labelledby="desactivarModalProfesionLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="desactivarModalProfesionLabel">Confirmación</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas desactivar esta cuenta de profesional? Esta acción es irreversible.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('desactivar-Profesional', $profesion->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger">Desactivar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#activarModal{{ $profesion->id }}">Activar Profesional</button>

                                <!-- Modal para Activar Profesional -->
                                <div class="modal fade" id="activarModal{{ $profesion->id }}" tabindex="-1" aria-labelledby="activarModalLabel{{ $profesion->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="activarModalLabel{{ $profesion->id }}">Activar Profesional</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas activar este profesional?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <!-- Formulario de activación -->
                                                <form action="{{ route('activar-Profesional', $profesion->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Activar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                </td>
                
               
            </tr>
        </tbody>
    </table>

    <!-- Servicios -->

    <div class="mb-4">
        <h4><strong>Servicios</strong></h4>
        <!-- Cuadro de búsqueda para la tabla de Servicios -->
        <input type="text" id="searchServicios" placeholder="Buscar en Servicios..." onkeyup="filterTable('tableServicios', this.value)" class="form-control mb-3">
        <table table class="table table-striped" id="tableServicios">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Duracion</th>
                    <th scope="col">Calficacion</th>
                    <th scope="col">Reservas</th>
                    <th scope="col">Creación</th>
                    <th scope="col">Actualizacion</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->id }}</td>
                        <td>{{ $servicio->nombre }}</td>
                        @php
                            $servicio->precio_base = '$' . $servicio->precio_base;
                            $servicio->precio_base = str_replace('.', ',', $servicio->precio_base);
                        @endphp
                        <td>{{ $servicio->precio_base }}</td>
                        <td>{{ $servicio->descripcion }}</td>
                        <td>{{ \Carbon\Carbon::parse($servicio->duracion_estimada)->format('H:i') }}</td>
                        @if ($servicio->calificacion == 0.00)
                            <td>Sin calificar</td>
                        @else
                            <td>{{ $servicio->calificacion }}</td>
                        @endif
                        <td>{{ $servicio->cantidad_reservas }}</td>
                        <td>{{ \Carbon\Carbon::parse($servicio->created_at)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($servicio->updated_at)->format('d/m/Y') }}</td>
                        @php
                            if ($servicio->estado == 'activo') {
                                $servicio->estado = 'Activo';
                            } else {
                                $servicio->estado = 'Inactivo';
                            }
                        @endphp
                        <td>{{ $servicio->estado }}</td>
                        <td>
                            <!-- boton para actualizar datos del servicio-->
                            @if ($profesion->estado == 1)
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actualizarModal{{ $servicio->id }}">
                                    Actualizar Servicio
                                </button>
                            @endif

                            <!-- Modal para actualizar datos del servicio -->
                            <div class="modal fade" id="actualizarModal{{ $servicio->id }}" tabindex="-1" aria-labelledby="actualizarModalLabel{{ $servicio->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="actualizarModalLabel{{ $servicio->id }}">Actualizar Datos del Servicio</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="{{ route('admin-actualizar-servicio', $servicio->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre:</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $servicio->nombre }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción:</label>
                                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ $servicio->descripcion }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="precio_base" class="form-label">Precio:</label>
                                                    <input type="number" class="form-control" id="precio_base" name="precio_base" value="{{ $servicio->precio_base }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="duracion_estimada" class="form-label">Duración Estimada:</label>
                                                    <input type="time" class="form-control" id="duracion_estimada" name="duracion_estimada" value="{{ $servicio->duracion_estimada }}" required>
                                                </div>
                                                
                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>                                                
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Botones de desactivar servicio y activar servicio -->
                            @if ($servicio->estado == 'Activo')
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#desactivarModal{{ $servicio->id }}">Desactivar Servicio</button>
                                <!-- modal para desactivar servicio -->
                                <div class="modal fade" id="desactivarModal{{ $servicio->id }}" tabindex="-1" aria-labelledby="desactivarModalLabel{{ $servicio->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="desactivarModalLabel{{ $servicio->id }}">Desactivar Servicio</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas desactivar este servicio?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <!-- Formulario de desactivación -->
                                                <form action="{{ route('desactivar-servicio', $servicio->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger">Desactivar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif ($servicio->estado == 'Desactivado' && $datosProfesional->estado == 1)
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#activarModal{{ $servicio->id }}">Activar Servicio</button>

                                <!-- Modal para Activar Servicio -->
                                <div class="modal fade" id="activarModal{{ $servicio->id }}" tabindex="-1" aria-labelledby="activarModalLabel{{ $servicio->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="activarModalLabel{{ $servicio->id }}">Activar Servicio</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Estás seguro de que deseas activar este servicio?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <!-- Formulario de activación -->
                                                <form action="{{ route('activar-servicio', $servicio->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success">Activar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Citas del profesional-->
    <div class=mb-4>
        <h4><strong> Citas</strong></h4>
        <!.-- Cuadro de búsqueda para la tabla de Citas -->
        <input type="text" id="searchCitas" placeholder="Buscar en Citas..." onkeyup="filterTable('tableCitas', this.value)" class="form-control mb-3">
        <table class="table table-striped" id="tableCitas">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Servicio</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Hora</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($citas as $cita)
                    <tr>
                        <th scope="row">{{ $cita->idCita }}</th>
                        <td>{{ $cita->servicio->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($cita->horaInicio)->format('H:i') }}</td>
                        <td>{{ $cita->persona->nombre }} {{ $cita->persona->apellido }}</td>
                        <td>
                            @php
                                if ($cita->estado == 4) {
                                    $cita->estado = 'Pagada';
                                } elseif ($cita->estado == 3) {
                                    $cita->estado = 'Re-confirmada';
                                } elseif ($cita->estado == 2) {
                                    $cita->estado = 'Cancelada';
                                } elseif ($cita->estado == 1) {
                                    $cita->estado = 'Confirmada';
                                } elseif ($cita->estado == 0) {
                                    $cita->estado = 'Pendiente';
                                }
                              
                            @endphp
                            {{ $cita->estado }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

<script>
    function filterTable(tableId, searchValue) {
        const table = document.getElementById(tableId);
        const rows = table.getElementsByTagName('tr');
        searchValue = searchValue.toLowerCase();

        for (let i = 1; i < rows.length; i++) { // Comienza en 1 para omitir el encabezado
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(searchValue)) {
                    match = true;
                    break;
                }
            }

            rows[i].style.display = match ? '' : 'none'; // Mostrar u ocultar filas
        }
    }
</script>

@endsection