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
                            <a href="{{ route('admin-ver-servicio', ['id' => $servicio->id]) }}" class="btn btn-success btn-sm">Ver</a>    
                            
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