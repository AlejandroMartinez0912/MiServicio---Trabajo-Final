@extends('layouts.plantillain')

@section('titulo', 'Agendar Cita')
<style>
    /* Estilo para los elementos h5 */
    h4 {
            font-family:sans-serif; /* Fuente gruesa y moderna */
            font-weight: 900; /* Máxima negrita */
            color: #333333; /* Gris oscuro para un contraste elegante */
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Sombra para mayor profundidad */
    }

    #servicio-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        width: 600px;
    }


    #profesional-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        width: 600px;

    }

    #horario-container {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        width: 600px;

    }
    /* Estilo para los botones deshabilitados */
    .btn[disabled] {
        background-color: #e0e0e0;
        color: #b0b0b0;
        pointer-events: none; /* Evita que se pueda hacer clic */
    }

</style>

@section('contenido')
    <div>
        <div class="container mt-5">
            <!-- Servicio elegido -->
            <div class="container mt-5" id="servicio-container">
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class="bx bx-wrench"></i>Servicio elegido</h5>
                    <a href="{{ route('index-cita') }}" class="btn btn-link text-decoration-none">
                        <i class="fas fa-edit"></i> Modificar
                    </a>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <!-- Imagen del servicio -->
                    <img src="" alt="Servicio" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                    
                    <div class="d-flex justify-content-between w-100">
                        <!-- Nombre del servicio con estilo personalizado -->
                        <div class="me-3">
                            <h6 class="mb-0" style="font-family: 'Roboto', sans-serif; font-weight: bold; font-size: 1.2rem;">
                                {{ $servicio->nombre }}
                            </h6>
                        </div>
                        
                        @php
                            // Convertir tiempo de formato HH:MM a minutos
                            $duracionEstimada = \Carbon\Carbon::parse($servicio->duracion_estimada);
                            $duracionEnMinutos = $duracionEstimada->hour * 60 + $duracionEstimada->minute;
                        @endphp

                        <!-- Duración formateada en horas y minutos -->
                        <div class="me-3">
                            <small>
                                {{ floor($duracionEnMinutos / 60) }}h {{ $duracionEnMinutos % 60 }}m
                            </small>
                        </div>

                        <!-- Precio estimado -->
                        <div>
                            <small class="text-success" style="font-weight: bold;">
                                ${{ number_format($servicio->precio_base, 2) }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Profesional elegido -->
            <div class="container mt-5" id="profesional-container">
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <h4><i class='bx bxs-briefcase-alt-2' ></i> Profesional encargado</h5>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <img src="" alt="Profesional" class="rounded-circle me-3" style="width: 50px; height: 50px;">
                    <div>
                        <h6 class="mb-0" style="font-family: 'Roboto', sans-serif; font-weight: bold; font-size: 1.2rem;">
                            {{ $persona->nombre }} {{ $persona->apellido }}</h6>
                        <p class="card-text" style="font-size: 0.9rem; color: #6c757d;"> Ubicación: {{ $datosProfesion->ubicacion }}</p>
                        <p class="card-text" style="font-size: 0.9rem; color: #6c757d;">Telefo: {{ $datosProfesion->telefono }}</p>
                        @if ($datosProfesion->calificacion == 0)
                            <p class="card-text" style="font-size: 0.9rem; color: #6c757d;">Calificacion: No calificado</p>
                        @else
                            <p class="card-text" style="font-size: 0.9rem; color: #6c757d;"> Calificacion: {{ $datosProfesion->calificacion }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Elegir fecha y horario -->
        <div class="container mt-5" id="horario-container">
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-3"><i class='bx bxs-calendar'></i> Elegir fecha y horario</h4>
            </div>
            <div class="d-flex align-items-center justify-content-between" id="semana-container" data-inicio-semana="{{ $inicioSemana->toDateString() }}">
                <!-- Botón previo -->
                <button id="btn-prev" class="btn btn-dark">
                    <i class='bx bx-left-arrow-alt'></i>                
                </button>
            
                <!-- Selección de días -->
                <div id="diasDisponibles" class="d-flex overflow-auto px-3">
                    @foreach ($diasDisponibles as $dia)
                        @php
                            $estaDisponible = in_array($dia['diaSemana'], $diasTrabajo);
                            $btnClass = $estaDisponible ? 'btn-outline-success' : 'btn-outline-secondary'; 
                            $disabledAttr = $estaDisponible ? '' : 'disabled'; 
                        @endphp
                        <button 
                            class="btn mx-2 px-3 py-2 {{ $btnClass }}" 
                            data-fecha="{{ $dia['fecha'] }}" 
                            {{ $disabledAttr }}>
                            <small class="d-block">{{ $dia['mes'] }}</small>
                            <span class="d-block">{{ $dia['dia'] }}</span>
                        </button>
                    @endforeach
                </div>


                <!-- Botón siguiente -->
                <button id="btn-next" class="btn btn-dark">
                    <i class='bx bx-right-arrow-alt'></i>                
                </button>
            </div>
            
            <!-- Selección de hora (oculta inicialmente) -->
            <div id="hora-container" class="mt-3 d-none">
                <label for="horaInicio">Seleccionar hora:</label>
                <input type="time" id="horaInicio" class="form-control" required>
            </div>

            <!-- Formulario para enviar la cita -->
            <form id="citaForm" method="POST" action="{{ route('guardar-cita') }}">
                @csrf
                <input type="hidden" name="fecha" id="fechaCita" required>
                <input type="hidden" name="horaInicio" id="horaInicioInput" required>
                <input type="hidden" name="servicio_id" value="{{ $servicio->id }}">
                <button type="submit" class="btn btn-primary mt-3">Confirmar cita</button>
            </form>
            
            <script>
                document.addEventListener("DOMContentLoaded", function() {
                    const semanaContainer = document.getElementById('semana-container');
                    const btnPrev = document.getElementById('btn-prev');
                    const btnNext = document.getElementById('btn-next');
                    const diasDisponiblesContainer = document.getElementById('diasDisponibles');
                    const horaInicioInput = document.getElementById('horaInicio');
                    const fechaCitaInput = document.getElementById('fechaCita');
                    const horaInicioHiddenInput = document.getElementById('horaInicioInput');
                    
                    // Obtener la fecha de inicio de la semana desde el atributo 'data-inicio-semana'
                    let inicioSemana = moment(semanaContainer.getAttribute('data-inicio-semana'));

                    // Función para actualizar los días disponibles en la vista
                    function actualizarDiasDisponibles() {
                        diasDisponiblesContainer.innerHTML = ''; // Limpiar días anteriores

                        for (let i = 0; i < 7; i++) {
                            const fecha = inicioSemana.clone().add(i, 'days');
                            const dia = fecha.date();
                            const mes = fecha.locale('es').format('MMMM');
                            const diaBoton = document.createElement('button');
                            diaBoton.classList.add('btn', 'btn-outline-success', 'mx-2', 'px-3', 'py-2');
                            diaBoton.dataset.fecha = fecha.format('YYYY-MM-DD');
                            diaBoton.innerHTML = `<small class="d-block">${mes}</small><span class="d-block">${dia}</span>`;
                            diasDisponiblesContainer.appendChild(diaBoton);
                        }
                    }

                    // Manejar el clic en el botón "Anterior"
                    btnPrev.addEventListener('click', function() {
                        inicioSemana.subtract(1, 'week'); // Retroceder una semana
                        semanaContainer.setAttribute('data-inicio-semana', inicioSemana.toDate()); // Actualizar el atributo de fecha
                        actualizarDiasDisponibles(); // Actualizar los días en la vista
                    });

                    // Manejar el clic en el botón "Siguiente"
                    btnNext.addEventListener('click', function() {
                        inicioSemana.add(1, 'week'); // Avanzar una semana
                        semanaContainer.setAttribute('data-inicio-semana', inicioSemana.toDate()); // Actualizar el atributo de fecha
                        actualizarDiasDisponibles(); // Actualizar los días en la vista
                    });

                    // Manejar el clic en cualquier día para seleccionar la fecha
                    diasDisponiblesContainer.addEventListener('click', function(event) {
                        if (event.target.tagName === 'BUTTON') {
                            const fechaSeleccionada = event.target.dataset.fecha;
                            fechaCitaInput.value = fechaSeleccionada; // Establecer la fecha seleccionada
                        }
                    });

                    // Sincronizar la hora de inicio con el campo oculto del formulario
                    horaInicioInput.addEventListener('change', function() {
                        horaInicioHiddenInput.value = horaInicioInput.value;
                    });

                    // Inicializar la vista con la semana actual
                    actualizarDiasDisponibles();
                });
            </script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const botonesDias = document.querySelectorAll("#diasDisponibles button");
                    const horaContainer = document.getElementById("hora-container");
                    const fechaCitaInput = document.getElementById("fechaCita");
                    const horaInicioInput = document.getElementById("horaInicio");

                    botonesDias.forEach((boton) => {
                        boton.addEventListener("click", function () {
                            // Marcar el botón seleccionado
                            botonesDias.forEach((btn) => btn.classList.remove("active"));
                            this.classList.add("active");

                            // Mostrar el contenedor de selección de hora
                            horaContainer.classList.remove("d-none");

                            // Actualizar el campo oculto con la fecha seleccionada
                            const fechaSeleccionada = this.getAttribute("data-fecha");
                            fechaCitaInput.value = fechaSeleccionada;
                        });
                    });

                    // Actualizar el input oculto cuando el usuario selecciona una hora
                    horaInicioInput.addEventListener("input", function () {
                        document.getElementById("horaInicioInput").value = this.value;
                    });
                });
            </script>
        </div>


@endsection

<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
