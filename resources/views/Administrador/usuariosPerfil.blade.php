@extends ('layouts.administracion')

@section('titulo', 'MiServicio | Perfil')

@section('contenido')

<!-- Recibe de la ruta admin-ver-perfil -->

<div class="container mt-5">

    <div id="header" class="mb-4">
        <h3>Gestión de Usuarios</h3>
        <a href="{{ route('admin-usuarios') }}" class="btn btn-primary btn-sm">Volver a Usuarios</a>
    </div>

    <!-- Información del Usuario -->
    <div class="mb-4">
        <h4><strong>{{ $persona->nombre }} {{ $persona->apellido }}</strong></h4>
    </div>

    <!-- Tabla de Información del Usuario -->
    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <td><strong></strong></td>
                <td><strong>Datos</strong></td>
                <td><strong>Acciones</strong></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td>{{ $user->email }}</td>
            </tr>
            <tr>
                <td><strong>Fecha de Nacimiento:</strong></td>
                <td>{{ \Carbon\Carbon::parse($persona->fecha_nacimiento)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Teléfono:</strong></td>
                <td>{{ $persona->telefono }}</td>
            </tr>
            <tr>
                <td><strong>Dirección:</strong></td>
                <td>{{ $persona->domicilio }}</td>
            </tr>
            <tr>
                <td><strong>Fecha de Registro:</strong></td>
                <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Fecha de Actualización:</strong></td>
                <td>{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Estado:</strong></td>
                @php
                    $estado = $user->estado;
                    if ($estado == 1) {
                        $estado = 'Activo';
                    } else {
                        $estado = 'Inactivo';
                    }
                @endphp
                <td>{{ $estado }}</td>
                <td>
                    @if ($estado==1)
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#desactivarModal{{ $persona->id }}">
                            Desactivar Cuenta
                        </button>

                        <!-- Modal de desactivación -->
                        <div class="modal fade" id="desactivarModal{{ $id }}" tabindex="-1" aria-labelledby="desactivarModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="desactivarModalLabel">Confirmación</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas desactivar esta cuenta? Esta acción es irreversible.
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('usuarios-desactivar', $id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-danger">Desactivar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($estado == 0)
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#activarModal{{ $persona->id }}">
                            Activar Cuenta
                        </button>
                        <!-- Modal para Activar Cuenta -->
                        <div class="modal fade" id="activarModal{{ $persona->id }}" tabindex="-1" aria-labelledby="activarModalLabel{{ $persona->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="activarModalLabel{{ $persona->id }}">Confirmar Activación de Cuenta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>¿Estás seguro de que deseas activar la cuenta de <strong>{{ $persona->nombre }}</strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <!-- Formulario de activación -->
                                        <form action="{{ route('usuarios-activar', $persona->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success">Activar Cuenta</button>
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

    <!-- Tabla de Citas -->
    <div class="mt-4">
        <h4><strong>Citas de {{ $persona->nombre }}</strong></h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Servicio</th>
                    <th>Estado</th>
                    <th>Calificación de servicio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($citas as $cita)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($cita->horaInicio)->format('H:i') }}</td>
                        <td>{{ $cita->servicio->nombre }}</td>
                        @php
                            $estadoCita = $cita->estado;
                            if ($estadoCita == 1) {
                                $estadoCita = 'Confirmada';
                            } elseif ($estadoCita == 2) {
                                $estadoCita = 'Cancelada';
                            } elseif ($estadoCita == 3) {
                                $estadoCita = 'Reconfirmada';
                            } elseif ($estadoCita == 4) {
                                $estadoCita = 'Pagada';
                            } else {
                                $estadoCita = 'Pendiente';
                            }
                        @endphp
                        <td>{{ $estadoCita }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
