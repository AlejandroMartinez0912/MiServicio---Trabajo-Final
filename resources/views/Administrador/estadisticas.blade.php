@extends('layouts.administracion')

@section('contenido')
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: black;
        margin: 0;
        padding: 20px;
        color: #333;
    }

    .container {
        background-color: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px; /* Espaciado entre contenedores */
    }

    h2, h3 {
        color: #333;
        border-bottom: 2px solid #ddd;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-size: 24px; /* Aumentar tamaño de los títulos */
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
        padding: 12px; /* Más espacio en las celdas */
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

    .section {
        margin-bottom: 40px; /* Separación entre las secciones */
    }

    #graficoServicios {
        max-width: 100%; /* Ajustar el gráfico al ancho */
        height: 300px; /* Definir un tamaño fijo para el gráfico */
        margin-top: 20px;
    }

</style>

<div class="container">

    <h2><strong>Estadísticas</strong></h2>

    <div class="section" id="informe-1">
        <h2>Cantidad de Servicios Contratados por Rubros</h2>
        <table>
            <thead>
                <tr>
                    <th>Rubro</th>
                    <th>Total de Servicios Contratados</th>
                </tr>
            </thead>
            <tbody>
                @foreach($informe1 as $dato)
                    <tr>
                        <td>{{ $dato->rubro }}</td>
                        <td>{{ $dato->total_reservas }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <canvas id="graficoServicios"></canvas>
    </div>

    <div class="section" id="informe-2">
        <h2>Optimización de Precios según Demanda y Calificaciones</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Calificación</th>
                    <th>Reservas</th>
                    <th>Precio Actual</th>
                    <th>Precio Sugerido</th>
                </tr>
            </thead>
            <tbody>
                @foreach($informe2 as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        @php
                            $calificacion = $servicio->calificacion === 0.00 ? 'No calificado' : number_format($servicio->calificacion, 2);
                        @endphp
                        <td>{{ $calificacion }}</td>
                        <td>{{ $servicio->cantidad_reservas }}</td>
                        <td>${{ number_format($servicio->precio_base, 2) }}</td>
                        <td>
                            <strong 
                                @if($servicio->precio_sugerido > $servicio->precio_base) class="text-success"
                                @elseif($servicio->precio_sugerido < $servicio->precio_base) class="text-danger"
                                @endif
                            >
                                ${{ number_format($servicio->precio_sugerido, 2) }}
                            </strong>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section" id="informe-3">
        <h2>Servicios Destacados</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Calificación</th>
                    <th>Cantidad de Reservas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($informe3 as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ number_format($servicio->calificacion, 2) }}</td>
                        <td>{{ $servicio->cantidad_reservas }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section" id="informe-4">
        <h2>Servicios de Baja Calidad</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Servicio</th>
                    <th>Calificación</th>
                    <th>Cantidad de Reservas</th>
                </tr>
            </thead>
            <tbody>
                @foreach($informe4 as $servicio)
                    <tr>
                        <td>{{ $servicio->nombre }}</td>
                        <td>{{ number_format($servicio->calificacion, 2) }}</td>
                        <td>{{ $servicio->cantidad_reservas }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</div>

<!-- Grafico -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const datos = @json($informe1);
    
    const labels = datos.map(item => item.rubro);
    const valores = datos.map(item => item.total_reservas);

    new Chart(document.getElementById('graficoServicios'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Servicios Contratados por Rubro',
                data: valores,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        }
    });
</script>





@endsection
