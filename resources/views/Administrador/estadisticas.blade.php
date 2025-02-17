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
        
        <form method="GET" action="{{ route('estadisticas') }}">
            <label for="fecha_inicio">Desde:</label>
            <input type="date" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
        
            <label for="fecha_fin">Hasta:</label>
            <input type="date" name="fecha_fin" value="{{ request('fecha_fin') }}">
        
            <label for="rubro">Rubro:</label>
            <select name="rubro">
                <option value="">Todos</option>
                @foreach($rubros as $rubro)
                    <option value="{{ $rubro }}" {{ request('rubro') == $rubro ? 'selected' : '' }}>
                        {{ $rubro }}
                    </option>
                @endforeach
            </select>
        
            <button type="submit" class="btn btn-primary">Filtrar</button>
        </form>
        <canvas id="graficoServicios"></canvas>

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
        <!-- Botón para exportar a PDF con filtros aplicados -->
        <a href="{{ route('informe1-pdf', request()->query()) }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Exportar a PDF
        </a>
    </div>

    <div class="section" id="informe-2">
        <h2>Optimización de Precios según Demanda y Calificaciones</h2>
        <!-- Gráfico de precios -->
        <h3>Comparación de Precios</h3>
        <canvas id="precioChart"></canvas>
    
        <!-- Tabla de datos -->
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
        <a href="{{ route('informe2-pdf', request()->query()) }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Exportar a PDF
        </a>
        
    </div>
    
    <!-- Agregar Chart.js desde CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var ctx = document.getElementById('precioChart').getContext('2d');
    
            // Datos desde Laravel
            var servicios = @json($informe2);
    
            var nombres = servicios.map(s => s.nombre);
            var preciosBase = servicios.map(s => s.precio_base);
            var preciosSugeridos = servicios.map(s => s.precio_sugerido);
    
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: nombres,
                    datasets: [
                        {
                            label: 'Precio Actual',
                            data: preciosBase,
                            backgroundColor: 'rgba(54, 162, 235, 0.6)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1
                        },
                        {
                            label: 'Precio Sugerido',
                            data: preciosSugeridos,
                            backgroundColor: 'rgba(255, 99, 132, 0.6)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { enabled: true }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
    
    <div class="section" id="informe-3">
        <h2>Servicios Destacados</h2>
        <div>
            <!-- Gráfico de barras para los mejores servicios -->
            <canvas id="graficoMejoresServicios"></canvas>
        </div>
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
        <a href="{{ route('informe3-pdf', request()->query()) }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Exportar a PDF
        </a>
    </div>
    
    <div class="section" id="informe-4">
        <h2>Servicios de Baja Calidad</h2>
        <div>
            <!-- Gráfico de barras para los servicios de baja calidad -->
            <canvas id="graficoBajaCalidad"></canvas>
        </div>
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
        <a href="{{ route('informe4-pdf', request()->query()) }}" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Exportar a PDF
        </a>
    </div>
    
    <script>
        // Gráfico de Servicios Destacados
        const ctx1 = document.getElementById('graficoMejoresServicios').getContext('2d');
        const graficoMejoresServicios = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: @json($informe3->pluck('nombre')), // Nombres de los servicios
                datasets: [{
                    label: 'Cantidad de Reservas',
                    data: @json($informe3->pluck('cantidad_reservas')), // Cantidad de reservas
                    backgroundColor: 'rgba(54, 162, 235, 0.2)', // Color de las barras
                    borderColor: 'rgba(54, 162, 235, 1)', // Borde de las barras
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        
        // Gráfico de Servicios de Baja Calidad
        const ctx2 = document.getElementById('graficoBajaCalidad').getContext('2d');
        const graficoBajaCalidad = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: @json($informe4->pluck('nombre')), // Nombres de los servicios
                datasets: [{
                    label: 'Cantidad de Reservas',
                    data: @json($informe4->pluck('cantidad_reservas')), // Cantidad de reservas
                    backgroundColor: 'rgba(255, 99, 132, 0.2)', // Color de las barras
                    borderColor: 'rgba(255, 99, 132, 1)', // Borde de las barras
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    

   

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
