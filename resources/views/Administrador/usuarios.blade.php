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

    <h3>Gestión de Usuarios</h3>

    <h2>Clientes</h2>
    <input type="text" id="searchClientes" placeholder="Buscar en Clientes..." onkeyup="filterTable('tableClientes', this.value)">

    <table id="tableClientes">
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
                        <td>{{ $usuario->persona?->nombre }} {{ $usuario->persona?->apellido }}
                            <!-- link para ver perfil-->
                        </td>
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
                            <a href="{{ route('admin-ver-perfil', ['id' => $usuario->id]) }}"">Ver Perfil</a>

                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>

    <h2>Profesionales</h2>
    <input type="text" id="searchProfesionales" placeholder="Buscar en Profesionales..." onkeyup="filterTable('tableProfesionales', this.value)">

    <table id="tableProfesionales">
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
                        <td>{{ $profesion->user->persona->nombre  }} {{ $profesion->user->persona->apellido }}</td>
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
                            <!-- link para ver perfil profesion -->
                            <a href="{{ route('admin-ver-perfil-profesion', ['idProfesion' => $profesion->id]) }}"">Ver Perfil</a>
                            
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
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
