@extends('layouts.miservicioIn')

@section('titulo', 'MiServicio | Gestión de Citas')
<!-- Estilos adicionales para mejorar la apariencia -->

@section('contenido')
<style>
    #citas {
        background: linear-gradient(135deg, #2a2a2a, #1c1c1c);
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.6);
        padding: 20px;
    }

    #citas h3 {
        color: #e0e0e0;
        text-align: center;
        border-bottom: 2px solid #555;
        padding-bottom: 10px;
    }

    #citas .table {
        background-color: #333;
        border: 1px solid #555;
        border-radius: 8px;
        overflow: hidden;
    }

    #citas .thead-dark th {
        background-color: #444;
        color: white;
        text-align: center;
    }

    #citas .table-hover tbody tr:hover {
        background-color: #555;
    }

    #citas .badge {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 12px;
    }

    #citas .badge-warning {
        background: #ffb347;
        color: #212529;
    }

    #citas .badge-success {
        background: #4caf50;
        color: #ffffff;
    }

    #citas .badge-danger {
        background: #e57373;
        color: #ffffff;
    }

    #citas .btn-action {
        font-size: 0.85rem;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 5px;
        transition: all 0.3s;
        background-color: #444;
        color: white;
        border: none;
    }

    #citas .btn-action.edit {
        background-color: #007bff;
    }

    #citas .btn-action.edit:hover {
        background-color: #0056b3;
    }

    #citas .btn-action.anular {
        background-color: #dc3545;
    }

    #citas .btn-action.anular:hover {
        background-color: #a71d2a;
    }
</style>

<!-- Sección: Mis Citas -->
<div id="citas">
    <h3 class="text-uppercase font-weight-bold text-white mb-4">Mis Citas</h3>
    <div class="row">
        <div class="col-md-12">
                <div class="card-body">
                    @if ($citas->isEmpty())

                        <p class="text-center">No tienes citas agendadas.</p>
                    @else
                        <table class="table horarios-table table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-white">Servicio</th>
                                    <th>Especialista</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($citas as $cita)
                                        <tr class= "text-white">
                                            <td>{{ $cita->servicio->nombre }}</td>
                                            @php
                                                $idEspecialista = $cita->servicio->datos_profesion_id;
                                                $especialista = $datosProfesion->where('id', $idEspecialista)->first();
                                            @endphp
                                            <td> {{ $especialista->nombre_fantasia }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($cita->horaInicio)->format('H:i') }}</td>
                                            <td>
                                                @if ($cita->estado == 0)
                                                    <span class="badge badge-warning">Pendiente</span>
                                                @elseif ($cita->estado == 1)
                                                    <span class="badge badge-success">Confirmada</span>
                                                @elseif ($cita->estado == 2)
                                                    <span class="badge badge-danger">Cancelada</span>
                                                @elseif ($cita->estado == 3)
                                                    <span class="badge badge-success"><strong>Re-confirmada</strong></span>
                                                @elseif ($cita->estado == 4)
                                                    <span class="badge badge-success" style="background-color: #007bff"><strong>Pagada</strong></span>
                                                @endif
                                                
                    
                                            </td>
                                            <td>
                                                @if ($cita->estado == 0)
                                                    <button class="btn btn-sm btn-action edit">Editar</button>
                                                    <button class="btn btn-sm btn-action anular">Cancelar</button>
                                                @endif
                                                @if ($cita->estado == 1)
                                                    <button class="btn btn-sm btn-action edit">Editar</button>
                                                    <button class="btn btn-sm btn-action anular">Cancelar</button>
                                                @endif
                                                @if ($cita->estado == 3)
                                                    <form action="{{ route('ver-pago') }}" method="GET" style="display:inline;">
                                                        <input type="hidden" name="idCita" value="{{ $cita->idCita }}">
                                                        <button class="btn btn-sm btn-action pagar" type="submit">Pagar</button>
                                                    </form>
                                                @endif
                                               
                                            </td>                                        
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
    </div>
    <!-- Si existe una variable $successMessage, mostrarla -->
    @if(isset($successMessage) && $successMessage)
        <div class="alert alert-success">
            {{ $successMessage }}
        </div>
    @endif

</div>

<!-- Modal de Calificación -->
<div class="modal" id="calificacionModal" style="display: none;">
    <div class="modal-content">
        <h3>Calificar Servicio</h3>
        <!-- Formulario para calificar -->
        <form id="calificacionForm" method="POST" action="" data-id-cita="">
            @csrf <!-- Token CSRF de Laravel para seguridad -->
            <input type="hidden" id="citaId" name="idCita"> <!-- Campo oculto para idCita -->
            <div>
                <label for="calificacion">Calificación:</label>
                <select name="calificacion" id="calificacion">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select>
            </div>
            <div>
                <label for="comentario">Comentario:</label>
                <textarea name="comentario" id="comentario" rows="4"></textarea>
            </div>
            <div>
                <button type="submit">Guardar Calificación</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Función para obtener calificaciones pendientes
        function obtenerCalificacionesPendientes() {
            $.ajax({
                url: '/calificaciones/pendientes', // Ruta al método del controlador
                type: 'GET',
                success: function (response) {
                    if (response.success && response.data.length > 0) {
                        // Tomar la primera cita pendiente
                        var cita = response.data[0];

                        // Asignar valores dinámicamente al formulario y modal
                        $('#citaId').val(cita.idCita);
                        $('#calificacionForm').attr('action', '/calificaciones/' + cita.idCita + '/guardar');
                        $('#calificacionModal').css('display', 'flex'); // Mostrar el modal
                    } else {
                        // No hay citas pendientes, simplemente no hacer nada
                        $('#calificacionModal').css('display', 'none'); // Asegurarse de que el modal esté oculto
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error al obtener las calificaciones pendientes:', error);
                    $('#calificacionModal').css('display', 'none'); // Ocultar el modal en caso de error
                }
            });
        }

        // Llamar a la función al cargar la página o según sea necesario
        obtenerCalificacionesPendientes();

        // Manejar el envío del formulario
        $('#calificacionForm').on('submit', function (e) {
            e.preventDefault(); // Prevenir la acción predeterminada del formulario

            var formData = $(this).serialize(); // Serializar datos del formulario
            var actionUrl = $(this).attr('action'); // Obtener la URL de acción dinámica

            $.ajax({
                url: actionUrl,
                type: 'POST',
                data: formData,
                success: function (response) {
                    // Calificación guardada exitosamente
                    $('#calificacionModal').css('display', 'none'); // Cerrar el modal
                    obtenerCalificacionesPendientes(); // Recargar la lista de pendientes
                },
                error: function (xhr, status, error) {
                    console.error('Error al guardar la calificación:', error);
                    alert('Ocurrió un error al guardar la calificación. Por favor, inténtelo de nuevo.');
                }
            });
        });
    });
</script>


<style>
    /* Modal */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background-color: #333;
        padding: 30px;
        border-radius: 8px;
        width: 400px;
        max-width: 90%;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        text-align: center;
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .modal h3 {
        font-size: 26px;
        color: #fff;
        margin-bottom: 20px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .modal form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .modal label {
        font-size: 16px;
        color: #fff;
        margin-bottom: 8px;
        text-align: left;
        font-weight: 500;
    }

    .modal select,
    .modal textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
        width: 100%;
        box-sizing: border-box;
        background-color: #222;
        color: #fff;
    }

    .modal textarea {
        resize: vertical;
    }

    .modal button {
        padding: 12px 25px;
        background-color: #ff00cc;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        text-transform: uppercase;
    }

    .modal button:hover {
        background-color: #333399;
    }

    /* Estilo del fondo oscuro de la pantalla */
    .modal {
        display: flex;
    }

    /* Botón de cerrar el modal */
    .close-btn {
        background-color: transparent;
        border: none;
        color: #fff;
        font-size: 25px;
        cursor: pointer;
        position: absolute;
        top: 15px;
        right: 15px;
    }

    .close-btn:hover {
        color: #ff00cc;
    }

    /* Animación de entrada para el modal */
    .modal-content {
        animation: fadeIn 0.4s ease-in-out;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }
        100% {
            opacity: 1;
            transform: scale(1);
        }
    }
</style>

@endsection
