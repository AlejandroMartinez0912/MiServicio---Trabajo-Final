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

                        <p class="text-center" style="color: white">No tienes citas agendadas.</p>
                    @else
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label for="filter" class="text-white">Ordenar por:</label>
                                <select id="filter" class="form-select">
                                    <option value="fechaAsc">Fecha Ascendente</option>
                                    <option value="fechaDesc">Fecha Descendente</option>
                                    <option value="horaAsc">Hora Ascendente</option>
                                    <option value="horaDesc">Hora Descendente</option>
                                    <option value="estado">Estado</option>
                                </select>
                            </div>
                        </div>
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
                                                    <span class="badge badge-success" style="background-color: #007bff"><strong>Pagado</strong></span>
                                                @elseif ($cita->estado == 4 && $cita->calificacion_profesion == 1)
                                                    <span class="badge badge-success" style="background-color: #007bff"><strong>Pagado y calificado</strong></span>
                                                @endif
                    
                                            </td>
                                            <td>
                           
                                                @if ($cita->estado == 1 || $cita->estado == 0)
                                                    <!-- boton para abrir modal para editar cita -->              
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalEditarCita{{$cita->idCita}}">
                                                        Editar Cita
                                                    </button>                      
                                                    <!-- modal para editar cita -->
                                                    <div class="modal fade" id="modalEditarCita{{$cita->idCita}}" tabindex="-1" aria-labelledby="modalLabel{{$cita->id}}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modalLabel{{$cita->idCita}}">Editar Cita</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('actualizar-cita', $cita->idCita) }}" method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                    
                                                                        <div class="mb-3">
                                                                            <label for="fecha" class="form-label">Fecha</label>
                                                                            <input type="date" class="form-control" name="fecha" value="{{ \Carbon\Carbon::parse($cita->fechaCita)->format('Y-m-d') }}" required>
                                                                        </div>
                                                    
                                                                        <div class="mb-3">
                                                                            <label for="horaInicio" class="form-label">Hora Inicio</label>
                                                                            <input type="time" class="form-control" name="horaInicio" value="{{ $cita->horaInicio }}" required>
                                                                        </div>
                                                    
                                                                        <div class="mb-3">
                                                                            <label for="servicio_id" class="form-label">Servicio</label>
                                                                            <select class="form-select" name="servicio_id" required>
                                                                                @php
                                                                                    $idProfesion = $cita->idProfesion;
                                                                                    // Obtener los servicios que tienen el mismo idProfesion que el servicio de la cita
                                                                                    $servicios = App\Models\Servicio::where('datos_profesion_id', $idProfesion)->get();
                                                                                @endphp
                                                                                @foreach($servicios as $servicio)
                                                                                    <option value="{{ $servicio->id }}" {{ $cita->idServicio == $servicio->id ? 'selected' : '' }}>
                                                                                        {{ $servicio->nombre }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                        
                                                    
                                                                        <button type="submit" class="btn btn-success">Guardar Cambios</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Botón para abrir el modal de cancelación -->
                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalCancelarCita{{$cita->idCita}}">
                                                        Cancelar Cita
                                                    </button>  

                                                    <!-- Modal para cancelar cita -->
                                                    <div class="modal fade" id="modalCancelarCita{{$cita->idCita}}" tabindex="-1" aria-labelledby="modalLabelCancelar{{$cita->idCita}}" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="modalLabelCancelar{{$cita->idCita}}">Cancelar Cita</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p>¿Estás seguro de que deseas cancelar esta cita?</p>
                                                                    <form action="{{ route('cancelar-cita') }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="citaId" value="{{ $cita->idCita }}">
                                                                        <button type="submit" class="btn btn-danger">Confirmar Cancelación</button>
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    
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

<!-- script para ordenar -->
<script>
    document.getElementById('filter').addEventListener('change', function() {
        const filterValue = this.value;
        const table = document.querySelector('.horarios-table tbody');
        const rows = Array.from(table.rows);

        let sortedRows;

        if (filterValue === 'fechaAsc') {
            sortedRows = rows.sort((a, b) => {
                const dateA = new Date(a.cells[2].textContent.split('/').reverse().join('-'));
                const dateB = new Date(b.cells[2].textContent.split('/').reverse().join('-'));
                return dateA - dateB;
            });
        } else if (filterValue === 'fechaDesc') {
            sortedRows = rows.sort((a, b) => {
                const dateA = new Date(a.cells[2].textContent.split('/').reverse().join('-'));
                const dateB = new Date(b.cells[2].textContent.split('/').reverse().join('-'));
                return dateB - dateA;
            });
        } else if (filterValue === 'horaAsc') {
            sortedRows = rows.sort((a, b) => {
                const timeA = a.cells[3].textContent;
                const timeB = b.cells[3].textContent;
                return timeA.localeCompare(timeB);
            });
        } else if (filterValue === 'horaDesc') {
            sortedRows = rows.sort((a, b) => {
                const timeA = a.cells[3].textContent;
                const timeB = b.cells[3].textContent;
                return timeB.localeCompare(timeA);
            });
        } else if (filterValue === 'especialista') {
            sortedRows = rows.sort((a, b) => {
                const especialistaA = a.cells[5].textContent.trim().toLowerCase();
                const especialistaB = b.cells[5].textContent.trim().toLowerCase();
                return especialistaA.localeCompare(especialistaB);
            });
        } else if (filterValue === 'servicio') {
            sortedRows = rows.sort((a, b) => {
                const servicioA = a.cells[6].textContent.trim().toLowerCase();
                const servicioB = b.cells[6].textContent.trim().toLowerCase();
                return servicioA.localeCompare(servicioB);
            });
        } else if (filterValue === 'estado') {
            sortedRows = rows.sort((a, b) => {
                const statusA = a.cells[4].textContent.trim();
                const statusB = b.cells[4].textContent.trim();
                return statusA.localeCompare(statusB);
            });
        }

        // Re-append the rows after sorting
        table.innerHTML = '';
        table.append(...sortedRows);
    });
</script>


@endsection
