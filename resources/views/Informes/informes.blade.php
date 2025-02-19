@extends('layouts.miservicioIn')

@section('titulo', 'MiServicio | Informes')

@section('contenido')

<style>
    .card {
        background: #222; /* Fondo del card */
        border: none;
        border-radius: 15px;
        color: #eaeaea; /* Texto blanco-gris */
    }

    .card-body {
        padding: 30px;
    }

    h2 {
        font-weight: bold;
        color: #fff;
    }

    .form-label {
        color: #bbb; /* Un gris más claro */
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .form-control {
        background: #333; /* Fondo gris oscuro */
        border: 1px solid #555; /* Borde gris tenue */
        color: #fff;
        border-radius: 8px;
        padding: 10px;
    }

    .form-control:focus {
        background: #444;
        border-color: #007bff;
        outline: none;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
    }

    button.btn-primary {
        background: #007bff;
        border: none;
        border-radius: 8px;
        padding: 10px;
        font-size: 1.1rem;
        transition: background 0.3s ease;
    }

    button.btn-primary:hover {
        background: #0056b3;
    }

    button.btn-secondary {
        background: #555;
        border: none;
        border-radius: 8px;
        padding: 10px;
        font-size: 1.1rem;
        transition: background 0.3s ease;
    }

    button.btn-secondary:hover {
        background: #444;
    }

    .profile-pic {
        background: #444; /* Fondo oscuro para la imagen */
        border-radius: 50%;
        width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-left: 30px;
        border: 2px solid #555;
    }

    .profile-pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .profile-pic:hover {
        border-color: #007bff;
        cursor: pointer;
    }

    .alert {
        border-radius: 10px;
        padding: 15px;
    }

    .alert-success {
        background: #28a745;
        color: #fff;
    }

    .alert-danger {
        background: #dc3545;
        color: #fff;
    }
</style>

<style>
    .card {
        background: #333;
        border: none;
        border-radius: 15px;
        color: #eaeaea;
        padding: 20px;
        margin-bottom: 20px;
    }

    h2 {
        font-weight: bold;
        color: #fff;
    }

    .form-label {
        color: #bbb;
        font-size: 0.9rem;
    }

    .form-control {
        background: #333;
        border: 1px solid #555;
        color: #fff;
        border-radius: 8px;
        padding: 10px;
    }

    .btn-primary {
        background: #007bff;
        border: none;
        border-radius: 8px;
        padding: 10px;
    }

    .table {
        color: #eaeaea;
    }

    .table th, .table td {
        border-color: #444;
    }
</style>

<!-- Agregar Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

<div class="container" style="background:#222; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3); color: #f8f9fa;">
    <h2>Informes de Citas</h2>

    <!-- Formulario de filtros -->
    <form method="GET" action="{{ route('informes') }}" id="filtroForm">
        <div class="row">
            <!-- Filtro por servicio -->
            <div class="col-md-3">
                <label for="idServicio">Servicio</label>
                <select name="idServicio" id="idServicio" class="form-control">
                    <option value="">Todos los servicios</option>
                    @foreach($servicios as $servicio)
                        <option value="{{ $servicio->id }}" {{ request('idServicio') == $servicio->id ? 'selected' : '' }}>
                            {{ $servicio->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filtro por estado -->
            <div class="col-md-3">
                <label for="estado">Estado</label>
                <select name="estado" id="estado" class="form-control">
                    <option value="">Todos los estados</option>
                    <option value="Pendiente" {{ request('estado') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Confirmada" {{ request('estado') == 'Confirmada' ? 'selected' : '' }}>Confirmada</option>
                    <option value="Cancelada" {{ request('estado') == 'Cancelada' ? 'selected' : '' }}>Cancelada</option>
                    <option value="Re-confirmada" {{ request('estado') == 'Re-confirmada' ? 'selected' : '' }}>Re-confirmada</option>
                    <option value="Pagada" {{ request('estado') == 'Pagada' ? 'selected' : '' }}>Pagada</option>
                </select>
            </div>

            <!-- Filtro por calificación -->
            <div class="col-md-3">
                <label for="calificacion">Calificación</label>
                <input type="number" name="calificacion" id="calificacion" class="form-control" 
                    min="1" max="5" value="{{ request('calificacion') }}" placeholder="Calificación mínima">
            </div>

            <!-- Filtro por fecha inicio -->
            <div class="col-md-3">
                <label for="fechaInicio">Fecha de Inicio</label>
                <input type="date" name="fechaInicio" id="fechaInicio" class="form-control" value="{{ request('fechaInicio') }}">
            </div>

            <!-- Filtro por fecha fin -->
            <div class="col-md-3 mt-2">
                <label for="fechaFin">Fecha de Fin</label>
                <input type="date" name="fechaFin" id="fechaFin" class="form-control" value="{{ request('fechaFin') }}">
            </div>

            <div class="col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                <a href="{{ route('informes') }}" class="btn btn-primary" style="background-color: #333399; color: white; border: none;">Limpiar Filtros</a>
            </div>
        </div>
    </form>

    <hr>

    <!-- Mostrar las citas filtradas -->
    <h2>Citas</h2>
    @if($citas->isEmpty())
        <p>No se encontraron citas que coincidan con los filtros seleccionados.</p>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Fecha de Cita</th>
                    <th>Estado</th>
                    <th>Calificación Profesional</th>
                    <th>Calificación Cliente</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citas as $cita)
                    <tr>
                        <td>{{ $cita->servicio->nombre }}</td>
                        <td>{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d-m-Y H:i') }}</td>
                        <td>{{ $cita->estado }}</td>
                        <td>{{ $cita->calificacionesProfesion->calificacion ?? 'No disponible' }}</td>
                        <td>{{ $cita->calificacionesCliente->calificacion ?? 'No disponible' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Botón para exportar a PDF -->
        <a href="{{ route('exportar.pdf') }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Exportar a PDF
        </a>
        <a href="{{ route('informes.exportar-excel', ['citas' => $citas->toJson()]) }}" class="btn btn-success" style="background: green">
            <i class="fas fa-file-excel"></i> Exportar a Excel
        </a>
        

        
    @endif
</div>

<!-- Validaciones de Fecha -->
<script>
    document.getElementById("filtroForm").addEventListener("submit", function(event) {
        let fechaInicio = document.getElementById("fechaInicio").value;
        let fechaFin = document.getElementById("fechaFin").value;
        let fechaActual = new Date().toISOString().split("T")[0];

        if (fechaInicio && fechaInicio > fechaActual) {
            alert("La fecha de inicio no puede ser mayor a la fecha actual.");
            event.preventDefault();
        }

        if (fechaFin && fechaFin > fechaActual) {
            alert("La fecha de fin no puede ser mayor a la fecha actual.");
            event.preventDefault();
        }

        if (fechaInicio && fechaFin && fechaInicio > fechaFin) {
            alert("La fecha de inicio no puede ser mayor a la fecha de fin.");
            event.preventDefault();
        }
    });
</script>

<!-- Script para exportar a PDF -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.22/jspdf.plugin.autotable.min.js"></script>
<script>
    document.querySelector('#exportPdf').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.setFontSize(18);
        doc.text("Informes de Citas", 14, 20);

        const headers = ["Servicio", "Fecha de Cita", "Estado", "Calificación Profesional", "Calificación Cliente"];
        const data = [];

        @foreach($citas as $cita)
            data.push([
                "{{ $cita->servicio->nombre }}",
                "{{ \Carbon\Carbon::parse($cita->fechaCita)->format('d-m-Y H:i') }}",
                "{{ $cita->estado }}",
                "{{ $cita->calificacionesProfesion->calificacion ?? 'No disponible' }}",
                "{{ $cita->calificacionesCliente->calificacion ?? 'No disponible' }}"
            ]);
        @endforeach

        doc.autoTable({ head: [headers], body: data, startY: 30 });
        doc.save('informes_citas.pdf');
    });
</script>

@endsection
