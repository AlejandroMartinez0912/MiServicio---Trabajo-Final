@extends ('layouts.administracion')

@section('titulo', 'MiServicio | Servicios')

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

    .btn-primary {
        background-color: #3498db;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    .btn-group {
        margin-bottom: 15px;
    }

    .btn-group .btn {
        margin-right: 5px;
    }
</style>

<div class="container">
    <h3>{{ $servicio->nombre }}</h3>

    <div class="btn-group">
        <a href="{{ url()->previous() }}" class="btn btn-primary btn-sm">Volver</a>
    </div>

    <div class="table-responsive">
        <!-- tabla de servicios -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">ID Profesional</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Rubros</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Duracion</th>
                    <th scope="col">Reservas</th>
                    <th scope="col">Creación</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $servicio->id }}</td>
                    <td>{{ $servicio->datos_profesion_id }}</td>
                    <td>{{ $servicio->precio_base }}</td>
                    <td>{{ $servicio->rubros->implode('nombre', ', ') }}</td>
                    <td>{{ $servicio->descripcion }}</td>
                    <td>{{ $servicio->duracion_estimada }}</td>
                    <td>{{ $servicio->cantidad_reservas }}</td>
                    <td>{{ $servicio->created_at }}</td>
                    @php
                        if ($servicio->estado == 'activo') {
                            $servicio->estado = 'Activo';
                        } else {
                            $servicio->estado = 'Inactivo';
                        }
                    @endphp
                    <td>{{ $servicio->estado }}</td>
                    <td>
                        
                        <!-- Botones de desactivar servicio y activar servicio -->
                        @if ($servicio->estado == 'Activo')
                            <!-- Editar servicio-->
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editarServicioModal{{ $servicio->id }}">
                                Editar Servicio
                            </button>
            
                            <!-- Modal para editar un servicio existente -->
                            <div class="modal fade" id="editarServicioModal{{ $servicio->id }}" tabindex="-1" aria-labelledby="editarServicioModalLabel{{ $servicio->id }}" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="editarServicioModalLabel{{ $servicio->id }}">Editar Servicio</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('admin-actualizar-servicio', $servicio->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <!-- Nombre -->
                                                <div class="mb-3">
                                                    <label for="nombre" class="form-label">Nombre del Servicio</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre', $servicio->nombre) }}" placeholder="Ingrese el nombre del servicio" required>
                                                </div>
            
                                                <!-- Rubros -->
                                                <div class="form-group">
                                                    <label for="rubros">Selecciona los Rubros</label>
                                                    <select id="rubros" name="rubros[]" class="form-control select2" multiple="multiple" style="width: 100%;" required>
                                                        @foreach($rubros as $rubro)
                                                            <option value="{{ $rubro->id }}" 
                                                                @if(in_array($rubro->id, $servicio->rubros->pluck('id')->toArray())) 
                                                                    selected
                                                                @endif
                                                            >{{ $rubro->nombre }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
            
                                                <!-- Descripción -->
                                                <div class="mb-3">
                                                    <label for="descripcion" class="form-label">Descripción</label>
                                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción del servicio">{{ old('descripcion', $servicio->descripcion) }}</textarea>
                                                </div>
            
                                                <!-- Precio Base -->
                                                <div class="mb-3">
                                                    <label for="precio_base" class="form-label">Precio Base</label>
                                                    <input type="number" class="form-control" id="precio_base" name="precio_base" step="0.01" value="{{ old('precio_base', $servicio->precio_base) }}" placeholder="Ingrese el precio base" required>
                                                </div>
            
                                                <!-- Duración Estimada -->
                                                <div class="mb-3">
                                                    <label for="duracion_estimada" class="form-label">Duración Estimada</label>
                                                    <input type="time" class="form-control" id="duracion_estimada" name="duracion_estimada" value="{{ old('duracion_estimada', $servicio->duracion_estimada) }}" required>
                                                </div>
            
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>


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
                </tr>
    </div>


</div>
@endsection