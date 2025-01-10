@extends('layouts.miservicioIn')

@section('titulo', 'MiServicio | Pagar')

@section('contenido')

    <div class="container mt-5">
        <h1 class="text-center text-light mb-4">Detalles del Pago</h1>

        <div class="card shadow-lg p-4" style="background-color: #333; border-radius: 10px;">
            <div class="card-body text-light">
                <!-- Descripción del Servicio -->
                <div class="mb-3">
                    <h4 class="text-white">{{ $cita->servicio->nombre }}</h4>
                    <p><strong>Costo del servicio:</strong> ${{ number_format($cita->servicio->precio_base, 2) }}</p>
                    <p><strong>Fecha de la cita:</strong> {{ \Carbon\Carbon::parse($cita->fechaCita)->format('d-m-Y') }}</p>
                </div>

                <!-- Datos del Especialista -->
                <div class="mb-3">
                    <h5 class="text-white">Especialista:</h5>
                    <p>{{ $cita->datosProfesion->user->persona->nombre }} {{ $cita->datosProfesion->user->persona->apellido }}</p>
                </div>

                <!-- Datos del Cliente -->
                <div class="mb-4">
                    <h5 class="text-white">Cliente:</h5>
                    <p>{{ $cita->persona->nombre }} {{ $cita->persona->apellido }}</p>
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-between">
                    <!-- Formulario de pago -->
                    <form action="{{ route('mercado-pago') }}" method="GET" style="display:inline;">
                        <input type="hidden" name="idCita" value="{{ $cita->idCita }}">
                        <button class="btn btn-mercadopago" type="submit">
                            <img src="{{ asset('Images/mercadopago.png') }}" alt="Mercado Pago" style="width: 20px; margin-right: 8px;"> Pagar con Mercado Pago
                        </button>                    
                    </form>                    
                </div>
            </div>
        </div>
    </div>
    <style>
        .btn-mercadopago {
            background-color: white;
            color:#0063b1;
            font-weight: bold;
            padding: 12px 20px;
            border-radius: 30px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .btn-mercadopago:hover {
            background-color: #005087;
            cursor: pointer;
        }

        .btn-mercadopago:focus {
            outline: none;
        }
    </style>

@endsection
