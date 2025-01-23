@extends('layouts.administracion')

@section('contenido')
    <h3>Gestión de Usuarios</h3>

    <h2>Clientes</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre y Apellido</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
                @if ($usuario->id != 9)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <!-- nombre y apellido de usuario, que están en la tabla persona -->
                        <td>{{ $usuario->persona?->nombre }} {{ $usuario->persona?->apellido }}</td>
                        <!-- Mail -->
                        <td>{{ $usuario->email }}</td>

                        <!-- Estado -->
                        @php
                            $estado = $usuario->estado;
                            if ($estado == 1) {
                                $estado = 'Activo';
                            } else {
                                $estado = 'Inactivo';
                            }
                        @endphp
                        <td>{{ $estado }}</td>

                        <!-- Acciones -->
                        <td>
                            @if ($usuario->estado==1)
                                <!-- Botón para abrir el modal -->
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#desactivarModal{{ $usuario->id }}">
                                    Desactivar Cuenta
                                </button>

                                <!-- Modal de desactivación -->
                                <div class="modal fade" id="desactivarModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="desactivarModalLabel" aria-hidden="true">
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
                                                <form action="{{ route('usuarios-desactivar', $usuario->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-danger">Desactivar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#activarModal{{ $usuario->id }}">
                                    Activar Cuenta
                                </button>
                                <!-- Modal para Activar Cuenta -->
                                <div class="modal fade" id="activarModal{{ $usuario->id }}" tabindex="-1" aria-labelledby="activarModalLabel{{ $usuario->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="activarModalLabel{{ $usuario->id }}">Confirmar Activación de Cuenta</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>¿Estás seguro de que deseas activar la cuenta de <strong>{{ $usuario->name }}</strong>?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <!-- Formulario de activación -->
                                                <form action="{{ route('usuarios-activar', $usuario->id) }}" method="POST">
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
                @endif
            @endforeach
        </tbody>
    </table>

    <h2>Profesionales</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre Fantasia</th>
                <th>Nombre y Apellido</th>
                <th>Email</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($profesiones as $profesion)
                @if ($profesion->id != 9)
                    <tr>
                        <td>{{ $profesion->id }}</td>
                        <!-- nombre y apellido de usuario, que estan en la tabla persona-->
                        <td>{{ $profesion->nombre_fantasia }}</td>

                        <!-- nombre y apellido de usuario, que estan en la tabla persona-->
                        <td>{{ $usuario->persona?->nombre  }} {{ $usuario->persona?->apellido }}</td>
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
                        
                        <!-- Acciones -->
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
                @endif
            @endforeach
        </tbody>
    </table>

<!-- Script-->
<script>
    $(document).ready(function() {
        $('#desactivarModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Botón que abrió el modal
            var recipient = button.data('bs-target'); // ID del modal
            var modal = $(this);
            modal.find('.modal-body').text('¿Estás seguro de que deseas desactivar esta cuenta?');
        });
    });
</script>
@endsection
