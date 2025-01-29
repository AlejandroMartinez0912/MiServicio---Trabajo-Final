@extends('layouts.administracion')

@section('contenido')

    <style>
        input[type="text"] {
            margin-bottom: 15px;
            padding: 8px;
            width: 100%;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: black;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            color: #333;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            text-align: left;
        }

        table thead {
            background-color: #333;
            color: white;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
        }

        .btn-success {
            background-color: #2ecc71;
            color: white;
        }

        .btn-success:hover {
            background-color: #27ae60;
        }

        .btn-close {
            background-color: transparent;
            border: none;
            font-size: 18px;
            cursor: pointer;
        }

        .modal-content {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .modal-body {
            margin-bottom: 20px;
        }

        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-footer .btn {
            margin: 0;
        }

    </style>
    <div class="container">

        <h3>Gestión de Servicios</h3>

        <h2>Servicios</h2>
        <input type="text" id="searchServicios" placeholder="Buscar en Servicios..." onkeyup="filterTable('tableServicios', this.value)">
        <table id="tableServicios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Profesion</th>
                    <th>Profesional</th>
                    <th>Precio</th>
                    <th>Calificacion</th>
                    <th>Duracion</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($servicios as $servicio)
                    <tr>
                        <td>{{ $servicio->id }}</td>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ $servicio->datosProfesion->nombre_fantasia }}
                            <a href="{{ route('admin-ver-perfil-profesion', ['idProfesion' => $servicio->datosProfesion->id]) }}"">Ver Perfil</a>

                        </td>
                        <td>{{ $servicio->datosProfesion->user->persona->nombre }} {{ $servicio->datosProfesion->user->persona->apellido }}
                            <a href="{{ route('admin-ver-perfil', ['id' => $servicio->datosProfesion->user->id]) }}"">Ver Perfil</a>
                        </td>
                        <td>{{ $servicio->precio_base }}</td>
                        @php
                            if ($servicio->calificacion == 0.00) {
                                $servicio->calificacion = 'Sin calificar';
                            }
                        @endphp
                        <td>{{ $servicio->calificacion ? $servicio->calificacion : 'Sin calificar' }}</td>
                        <td>{{ \Carbon\Carbon::parse($servicio->duracion_estimada)->format('H:i') }}</td>
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
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#actualizarModal{{ $servicio->id }}">
                                Actualizar Servicio
                            </button>

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
                                                @method('POST')
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
                            @else
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
<!-- script para busqueda-->
<script>
    function filterTable(tableId, searchValue) {
        const table = document.getElementById(tableId);
        const rows = table.getElementsByTagName('tr');
        searchValue = searchValue.toLowerCase();

        for (let i = 1; i < rows.length; i++) { // Empieza desde 1 para saltar el encabezado
            const cells = rows[i].getElementsByTagName('td');
            let match = false;

            for (let cell of cells) {
                if (cell.textContent.toLowerCase().includes(searchValue)) {
                    match = true;
                    break;
                }
            }

            rows[i].style.display = match ? '' : 'none'; // Muestra u oculta la fila
        }
    }

</script>
@endsection