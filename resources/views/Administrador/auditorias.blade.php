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
    <h3>Gestión de Auditorias</h3>
    <h2>Auditorias</h2>

    <!-- Botones para filtrar por columnas específicas -->
    <div class="btn-group">
        <button class="btn btn-primary" onclick="filterByColumn('tableAuditorias', 0, 'Id Auditoria')">Filtrar por ID</button>
        <button class="btn btn-primary" onclick="filterByColumn('tableAuditorias', 1, 'User ID')">Filtrar por User ID</button>
        <button class="btn btn-primary" onclick="filterByColumn('tableAuditorias', 2, 'Acción')">Filtrar por Acción</button>
        <button class="btn btn-primary" onclick="filterByColumn('tableAuditorias', 3, 'Modulo')">Filtrar por Módulo</button>
        <button class="btn btn-primary" onclick="filterByDate('tableAuditorias', 6)">Filtrar por Fecha</button>
        <button class="btn btn-primary" onclick="clearFilters('tableAuditorias')">Limpiar Filtros</button>
    </div>

    <!-- Campo de búsqueda general -->
    <input type="text" id="searchAuditorias" placeholder="Buscar en Auditorias..." onkeyup="filterTable('tableAuditorias', this.value)">

    <!-- Tabla de auditorías -->
    <table id="tableAuditorias">
        <thead>
            <tr>
                <th>Id Auditoria</th>
                <th>User ID</th>
                <th>Acción</th>
                <th>Modulo</th>
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
</div>

<!-- Script para la lógica de filtrado -->
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

            rows[i].style.display = match ? '' : 'none';
        }
    }

    function filterByColumn(tableId, columnIndex, columnName) {
        const filterValue = prompt(`Ingrese el valor para filtrar por ${columnName}:`);
        if (filterValue === null) return; // Cancelar acción si el usuario presiona "Cancelar"

        const table = document.getElementById(tableId);
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) { // Empieza desde 1 para saltar el encabezado
            const cell = rows[i].getElementsByTagName('td')[columnIndex];
            const match = cell.textContent.toLowerCase().includes(filterValue.toLowerCase());

            rows[i].style.display = match ? '' : 'none';
        }
    }

    function filterByDate(tableId, columnIndex) {
        const startDate = prompt("Ingrese la fecha inicial (YYYY-MM-DD):");
        const endDate = prompt("Ingrese la fecha final (YYYY-MM-DD):");
        if (!startDate || !endDate) return; // Salir si el usuario cancela

        const table = document.getElementById(tableId);
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            const cell = rows[i].getElementsByTagName('td')[columnIndex];
            const cellDate = new Date(cell.textContent.trim());
            const start = new Date(startDate);
            const end = new Date(endDate);

            const match = cellDate >= start && cellDate <= end;
            rows[i].style.display = match ? '' : 'none';
        }
    }

    function clearFilters(tableId) {
        const table = document.getElementById(tableId);
        const rows = table.getElementsByTagName('tr');

        for (let i = 1; i < rows.length; i++) {
            rows[i].style.display = ''; // Mostrar todas las filas
        }

        // Limpiar campo de búsqueda si está en uso
        const searchField = document.getElementById('searchAuditorias');
        if (searchField) searchField.value = '';
    }
</script>
@endsection
