@extends('layouts.plantillain')

@section('titulo', 'Agendar Cita')
<style>
    /* Estilo para los elementos h5 */
    h3 {
        font-family:sans-serif; /* Fuente gruesa y moderna */
        font-weight: 900; /* Máxima negrita */
        color: #333333; /* Gris oscuro para un contraste elegante */
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); /* Sombra para mayor profundidad */
        
    }
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
<div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
    <h3>Agendar Cita</h3>
    <!-- Contenedor de informacion-->
    <div class="container" style=padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
        <div class="d-flex justify-content-between align-items-center">
            <h4><i class="bx bx-wrench"></i>Servicio elegido</h5>
            <a href="{{ route('index-cita') }}" class="btn btn-link text-decoration-none">
                <i class="fas fa-edit"></i> Modificar servicio
            </a>
        </div>
                <h5 class="card-title">{{ $servicio->nombre }}</h5>

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
        <h4></h4>
        <!-- Profesional elegido -->
        <div class="container" style=padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <h4><i class='bx bxs-briefcase-alt-2' ></i> Profesional encargado</h5>
            </div>
            <div class="d-flex align-items-center mt-3">
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
        <!-- Eleccion de fecha y horario -->
        <div class="container" style=padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-3"><i class='bx bxs-calendar'></i> Elegir fecha y horario</h4>
            </div>
            <div class="container mt-5">
                <div class="date-picker-container">
                  <!-- Botón retroceder fecha -->
                  <button id="prevDate" onclick="changeDate(-1)">&#8249;</button>
            
                  <!-- Fecha seleccionable -->
                  <div class="date-display" id="dateDisplay">
                    <!-- Días dinámicos -->
                    <div class="day-box" id="day1" onclick="selectDay(1)"></div>
                    <div class="day-box" id="day2" onclick="selectDay(2)"></div>
                    <div class="day-box" id="day3" onclick="selectDay(3)"></div>
                    <div class="day-box" id="day4" onclick="selectDay(4)"></div>
                    <div class="day-box" id="day5" onclick="selectDay(5)"></div>
                  </div>
            
                  <!-- Botón adelantar fecha -->
                  <button id="nextDate" onclick="changeDate(1)">&#8250;</button>
                </div>
            </div>
                        
            <script>
                let currentDate = new Date();
                let selectedDay = null;
                
                const workingDays = @json($diasDeTrabajo); 
            
                // Función para actualizar la visualización de las fechas
                function updateDateDisplay() {
                  const days = [];
                  for (let i = 0; i < 5; i++) {
                    let tempDate = new Date(currentDate);
                    tempDate.setDate(currentDate.getDate() + i); // Sumar el i-ésimo día al actual
                    days.push(tempDate);
                  }
            
                  // Actualizar la interfaz con las 5 fechas
                  for (let i = 0; i < 5; i++) {
                    const dayElement = document.getElementById(`day${i+1}`);
                    const day = days[i].getDate();
                    const month = days[i].toLocaleString('default', { month: 'short' });
                    const weekday = days[i].toLocaleString('default', { weekday: 'short' });
                    const dayOfWeek = days[i].getDay() === 0 ? 7 : days[i].getDay(); // Ajuste: Domingo es 7, no 0
            
                    // Establecer el contenido de cada día
                    dayElement.innerHTML = `
                      <span id="month">${month}</span>
                      <span id="weekday">${weekday}</span>
                      <span id="day">${day}</span>
                    `;
            
                    // Verificar si el día es laborable o no
                    if (workingDays.indexOf(dayOfWeek) === -1) {
                      dayElement.classList.add('unavailable');
                      dayElement.setAttribute('onclick', ''); // Deshabilitar la acción de clic
                    } else {
                      dayElement.classList.remove('unavailable');
                      dayElement.setAttribute('onclick', `selectDay(${i+1})`); // Activar el clic
                    }
                  }
                }
            
                // Función para cambiar la fecha (adelantar o retroceder)
                function changeDate(direction) {
                  currentDate.setDate(currentDate.getDate() + direction);
                  updateDateDisplay();
                  deselectAllDays(); // Deseleccionar todos los días cuando se cambia la fecha
                }
            
                // Función para seleccionar un día
                function selectDay(dayNumber) {
                  // Deseleccionar el día previamente seleccionado
                  deselectAllDays();
                  
                  // Seleccionar el día clicado
                  const dayElement = document.getElementById(`day${dayNumber}`);
                  dayElement.classList.add('selected');
                  selectedDay = dayNumber;
                }
            
                // Función para deselectar todos los días
                function deselectAllDays() {
                  const allDays = document.querySelectorAll('.day-box');
                  allDays.forEach(day => {
                    day.classList.remove('selected');
                  });
                }
            
                // Inicializar con la fecha actual
                updateDateDisplay();
            </script>
    
        </div>
    </div>
    <style>
        /* Estilos personalizados */
        .date-picker-container {
          display: flex;
          align-items: center;
          justify-content: center;
          background-color: #f8f9fa;
          padding: 20px;
          border-radius: 10px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    
        .date-picker-container button {
          background-color: #333;
          color: white;
          border: none;
          padding: 10px 15px;
          border-radius: 5px;
          cursor: pointer;
          font-size: 18px;
        }
    
        .date-picker-container button:hover {
          background-color: #0056b3;
        }
    
        .date-display {
          display: flex;
          flex-direction: row;
          justify-content: center;
          align-items: center;
          font-size: 18px;
          margin: 0 20px;
        }
    
        .day-box {
          margin: 0 10px;
          text-align: center;
          background-color:#70e188;
          color: #333;
          padding: 20px;
          border-radius: 10px;
          border: 2px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
          cursor: pointer;
          transition: all 0.3s ease;
        }
    

        .day-box.selected {
          background-color: #3f3fd1; 
          border-color: #3f3fd1;
          color:white
        }
        .day-box.unavailable {
            background-color: #ffebee; /* Rojo clarito para días no disponibles */
            color: #f44336; /* Color del texto cuando no está disponible */
            cursor: not-allowed; /* Cambiar el cursor para indicar que no se puede seleccionar */
            border-color: #f44336;
            }
    
        .day-box span {
          display: block;
        }
    
        .day-box #month {
          font-size: 18px;
          font-weight: bold;
        }
    
        .day-box #weekday {
          font-size: 16px;
        }
    
        .day-box #day {
          font-size: 20px;
          font-weight: bold;
        }
    
        /* Sección de espaciado */
        .spacing {
          margin: 20px;
        }
    </style>


@endsection

<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
