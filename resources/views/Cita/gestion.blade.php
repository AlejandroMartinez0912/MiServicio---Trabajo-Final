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

@endsection
