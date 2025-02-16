@extends('layouts.administracion')

@section('contenido')

<style>
    input[type="text"], select {
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
    <h3>Gestión de Auditorías</h3>
    <h2>Auditorías</h2>

    <!-- Formulario de filtros -->
    <form method="GET" action="{{ route('admin-auditoria') }}" id="filtroForm">
        <div class="row">
            <!-- Filtro por ID de auditoría -->
            <div class="col-md-2">
                <label for="idAuditoria">ID Auditoría</label>
                <input type="number" name="idAuditoria" id="idAuditoria" class="form-control" value="{{ request('idAuditoria') }}">
            </div>

            <!-- Filtro por ID de usuario -->
            <div class="col-md-2">
                <label for="userId">ID Usuario</label>
                <input type="number" name="userId" id="userId" class="form-control" value="{{ request('userId') }}">
            </div>

            <!-- Filtro por acción -->
            <div class="col-md-2">
                <label for="accion">Acción</label>
                <select name="accion" id="accion" class="form-control">
                    <option value="">Todas</option>
                    <option value="Crear" {{ request('accion') == 'Crear' ? 'selected' : '' }}>Crear</option>
                    <option value="Eliminar" {{ request('accion') == 'Eliminar' ? 'selected' : '' }}>Eliminar</option>
                    <option value="Actualizar" {{ request('accion') == 'Actualizar' ? 'selected' : '' }}>Actualizar</option>
                    <option value="Anular" {{ request('accion') == 'Anular' ? 'selected' : '' }}>Anular</option>
                    <option value="Activar" {{ request('accion') == 'Activar' ? 'selected' : '' }}>Activar</option>
                </select>
            </div>

            <!-- Filtro por módulo -->
            <div class="col-md-2">
                <label for="modulo">Módulo</label>
                <select name="modulo" id="modulo" class="form-control">
                    <option value="">Todos</option>
                    <option value="Usuarios" {{ request('modulo') == 'Usuarios' ? 'selected' : '' }}>Usuarios</option>
                    <option value="Citas" {{ request('modulo') == 'Citas' ? 'selected' : '' }}>Citas</option>
                    <option value="Servicios" {{ request('modulo') == 'Servicios' ? 'selected' : '' }}>Servicios</option>
                    <option value="Profesión" {{ request('modulo') == 'Profesión' ? 'selected' : '' }}>Profesión</option>
                    <option value="Pagos" {{ request('modulo') == 'Pagos' ? 'selected' : '' }}>Pagos</option>
                </select>
            </div>

            <!-- Filtro por fecha inicio -->
            <div class="col-md-2">
                <label for="fechaInicio">Fecha de Inicio</label>
                <input type="date" name="fechaInicio" id="fechaInicio" class="form-control" value="{{ request('fechaInicio') }}">
            </div>

            <!-- Filtro por fecha fin -->
            <div class="col-md-2">
                <label for="fechaFin">Fecha de Fin</label>
                <input type="date" name="fechaFin" id="fechaFin" class="form-control" value="{{ request('fechaFin') }}">
            </div>

            <!-- Botones de acción -->
            <div class="col-md-12 text-center mt-3">
                <button type="submit" class="btn btn-primary">Aplicar Filtros</button>
                <a href="{{ route('admin-auditoria') }}" class="btn btn-secondary">Limpiar Filtros</a>
            </div>
        </div>
    </form>

    <!-- Tabla de auditorías -->
    <table id="tableAuditorias">
        <thead>
            <tr>
                <th>Id Auditoría</th>
                <th>User ID</th>
                <th>Acción</th>
                <th>Módulo</th>
                <th>Detalles</th>
                <th>IP</th>
                <th>Fecha y hora</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($auditorias as $auditoria)
                <tr>
                    <td>{{ $auditoria->id }}</td>
                    <td>{{ $auditoria->user_id }}</td>
                    <td>{{ $auditoria->accion }}</td>
                    <td>{{ $auditoria->modulo }}</td>
                    <td>{{ $auditoria->detalles }}</td>
                    <td>{{ $auditoria->ip }}</td>
                    <td>{{ $auditoria->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Botón para exportar a PDF con filtros aplicados -->
    <a href="{{ route('exportar-auditoria-pdf', request()->query()) }}" class="btn btn-danger">
        <i class="fas fa-file-pdf"></i> Exportar a PDF
    </a>

</div>

@endsection
