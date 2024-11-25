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
        /* Contenedor principal */
  .date-picker-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      background-color: #f8f9fa;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      gap: 20px;
  }

  /* Botones de navegación */
  .navigation-buttons {
      display: flex;
      flex-direction: column;
      align-items: center;
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

  /* Contenedor de fechas */
  .date-display {
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      font-size: 18px;
      gap: 10px;
  }

  /* Contenedor de horarios */
  .schedule-container {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      padding: 10px;
      background-color: #ffffff;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }

  /* Días seleccionables */
  .day-box {
      text-align: center;
      background-color: #70e188;
      color: #333;
      padding: 20px;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      margin: 2px;
  }

  .day-box.selected {
      background-color: #3f3fd1;
      color: white;
  }

  .day-box.unavailable {
      background-color: #ffebee;
      color: #f44336;
      cursor: not-allowed;
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
  .schedule-item {
        margin: 5px;
        padding: 10px;
        background-color: #f0f0f0;
        border: 1px solid #ccc;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .schedule-item:hover {
        background-color: #ddd;
    }

    .schedule-item.selected {
        background-color: #4caf50;
        color: #fff;
        font-weight: bold;
        border-color: #4caf50;
    }
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-dialog {
        margin: 15% auto;
        max-width: 500px;
    }

    .modal-content {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-body {
        margin: 10px 0;
    }

    .modal-footer {
        display: flex;
        justify-content: flex-end;
    }
    /* Botón agendar cita */
    .btn-agendar-cita {
        display: block;
        margin: 20px auto;
        padding: 10px 20px;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 5px;
        color: #fff;
        background-color: #333; /* Color de fondo predeterminado */
        transition: all 0.3s ease;
        border: none; /* Asegura que no haya borde visible */
    }

    .btn-agendar-cita:hover {
        background-color: #3A3F47; /* Color de fondo al pasar el mouse */
        color: #FFD700; /* Color del texto al pasar el mouse */
        cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
    }
    h3 {
        font-family: sans-serif;
        font-weight: 900;
        color: #333333;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        text-align: center;
        margin-bottom: 30px;
    }

</style>

@section('contenido')
<div class="container" style="background-color: #f8f9fa; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
    <h3 class="text-center mb-5 text-uppercase font-weight-bold">Agendar Cita</h3>
    <div class="container" style="padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1); display: flex; gap: 20px;">
        <div style="flex: 1;">
            <!-- Contenido del primer div -->
            <h4><i class="bx bx-wrench"></i>Servicio elegido</h5>
            <div class="d-flex align-items-center mt-3">
                <div>
                    <h6 class="mb-0" style="font-family: 'Roboto', sans-serif; font-weight: bold; font-size: 1.2rem;">
                        {{ $servicio->nombre }}
                    </h6>
    
                    @php
                        // Convertir tiempo de formato HH:MM a minutos
                        $duracionEstimada = \Carbon\Carbon::parse($servicio->duracion_estimada);
                        $duracionEnMinutos = $duracionEstimada->hour * 60 + $duracionEstimada->minute;
                    @endphp
                    <!-- Duración formateada en horas y minutos -->
                    
                    <p class="card-text" style="font-size: 0.9rem; color: #6c757d;">
                        Duración: {{ floor($duracionEnMinutos / 60) }}h {{ $duracionEnMinutos % 60 }}m
                    </p>
                    <!-- Precio estimado -->
                    <p class="card-text" style="font-size: 0.9rem; color: #6c757d;">
                        Precio estimado: ${{ number_format($servicio->precio_base, 2) }}
                    </p>
                </div>
            </div>
        </div>
        <div style="flex: 1;">
            <!-- Contenido del segundo div -->
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
    </div>
    
    <!-- Eleccion de fecha y horario -->
    <div class="container" style=padding: 20px; border-radius: 10px; box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);">
        <hr>
        <div class="d-flex justify-content-between align-items-center">
            <h4 class="mb-3"><i class='bx bxs-calendar'></i> Elegir fecha y horario</h4>
        </div>

          <div class="container mt-5">
            <div class="date-picker-container">
                <!-- Contenedor de botones de navegación -->
                <div class="navigation-buttons">
                    <!-- Botón retroceder fecha -->
                    <button id="prevDate" onclick="changeDate(-1)">&#8249;</button>
                </div>

                <!-- Contenedor de selección de fechas -->
                <div class="date-display" id="dateDisplay">
                    <!-- Días dinámicos -->
                    <div class="day-box" id="day1" onclick="selectDay(1)"></div>
                    <div class="day-box" id="day2" onclick="selectDay(2)"></div>
                    <div class="day-box" id="day3" onclick="selectDay(3)"></div>
                    <div class="day-box" id="day4" onclick="selectDay(4)"></div>
                    <div class="day-box" id="day5" onclick="selectDay(5)"></div>
                </div>

                <!-- Contenedor de selección de horario -->
                <div class="schedule-container">
                    <div id="schedule" class="schedule-display">
                        <p>Selecciona un día para ver los horarios disponibles</p>
                    </div>
                </div>

                <!-- Botón adelantar fecha -->
                <div class="navigation-buttons">
                    <button id="nextDate" onclick="changeDate(1)">&#8250;</button>
                </div>
            </div>
        </div>
    </div>
     <!-- Botón para abrir el Modal -->
     <button type="button" class="btn-agendar-cita" onclick="openConfirmationModal()">Agendar Cita</button>

     <!-- Modal de Confirmación -->
     <div id="confirmationModal" class="modal" tabindex="-1">
         <div class="modal-dialog">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title">Confirmar Cita</h5>
                     <button type="button" class="btn-close" onclick="closeConfirmationModal()"></button>
                 </div>
                 <div class="modal-body">
                     <p><strong>Fecha seleccionada:</strong> <span id="selectedDate"></span></p>
                     <p><strong>Hora seleccionada:</strong> <span id="selectedTime"></span></p>
                 </div>
                 <div class="modal-footer">
                     <!-- Formulario para enviar datos -->
                     <form id="appointmentForm" method="POST" action="{{ route('guardar-cita') }}">
                         @csrf
                         <input type="hidden" id="hiddenDate" name="fecha">
                         <input type="hidden" id="hiddenTime" name="horaInicio">
                         <input type="hidden" id="hiddenService" name="servicio_id" value="{{ $servicio->id }}">
                         <button type="submit" class="btn btn-success">Confirmar</button>
                         <button type="button" class="btn btn-secondary" onclick="closeConfirmationModal()">Cancelar</button>
                     </form>
                     
                 </div>
             </div>
         </div>
     </div>

     <script>
         let currentDate = new Date();
         let selectedDay = null;

         let date = null;
         let time = null; 
     
         // Días laborables desde el servidor
         const workingDays = @json($diasDeTrabajo);

         // Horarios disponibles por día de la semana
         const availableSchedules = {
               1: ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"], // Lunes
               2: ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"],// Martes
               3: ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"],// Miércoles
               4: ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"],// Jueves
               5: ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"],// Viernes
               6: ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"],// Sábado
               7: ["00:00","01:00","02:00","03:00","04:00","05:00","06:00","07:00","08:00","09:00", "10:00", "11:00", "12:00", "13:00", "14:00", "15:00", "16:00", "17:00", "18:00", "19:00", "20:00", "21:00", "22:00", "23:00"],// Domingo
         };

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
                   const dayElement = document.getElementById(`day${i + 1}`);
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
                       dayElement.setAttribute('onclick', `selectDay(${i + 1}, ${dayOfWeek})`); // Activar el clic
                   }
               }
         }

         // Función para cambiar la fecha (adelantar o retroceder)
         function changeDate(direction) {
               currentDate.setDate(currentDate.getDate() + direction);
               updateDateDisplay();
               deselectAllDays(); // Deseleccionar todos los días cuando se cambia la fecha
               clearSchedule(); // Limpiar horarios
         }

         // Función para seleccionar un día
         function selectDay(dayNumber, dayOfWeek) {
               // Deseleccionar el día previamente seleccionado
               deselectAllDays();

               // Seleccionar el día clicado
               const dayElement = document.getElementById(`day${dayNumber}`);
               dayElement.classList.add('selected');
               selectedDay = dayNumber;

             // Obtener la fecha seleccionada
             const day = dayElement.querySelector("#day").textContent;
             const month = dayElement.querySelector("#month").textContent;
             
             const year = new Date().getFullYear(); // Suponiendo que siempre es el año actual
        
             // Formatear la fecha seleccionada como 'YYYY-MM-DD'
             date = `${year}-${month}-${day.padStart(2, '0')}`;

             // Actualizar el campo oculto en el formulario
             document.getElementById('hiddenDate').value = date;


               // Mostrar horarios para el día seleccionado
               displaySchedule(dayOfWeek);

         }

         // Función para deselectar todos los días
         function deselectAllDays() {
               const allDays = document.querySelectorAll('.day-box');
               allDays.forEach(day => {
                   day.classList.remove('selected');
               });
         }

         // Función para mostrar los horarios disponibles
         function displaySchedule(dayOfWeek) {
                 const scheduleContainer = document.getElementById('schedule');
                 scheduleContainer.innerHTML = ''; // Limpiar horarios previos

                 if (availableSchedules[dayOfWeek] && availableSchedules[dayOfWeek].length > 0) {
                     availableSchedules[dayOfWeek].forEach(schedule => {
                         const scheduleItem = document.createElement('button');
                         scheduleItem.classList.add('schedule-item');
                         scheduleItem.textContent = schedule;

                         // Añadir evento de clic para seleccionar el horario
                         scheduleItem.onclick = () => selectSchedule(scheduleItem);

                         scheduleContainer.appendChild(scheduleItem);
                     });
                 } else {
                     scheduleContainer.innerHTML = '<p>No hay horarios disponibles para este día</p>';
                 }
         }

         // Nueva función para seleccionar un horario
             function selectSchedule(scheduleItem) {
                 // Deseleccionar horarios previamente seleccionados
                 const allSchedules = document.querySelectorAll('.schedule-item');
                 allSchedules.forEach(item => item.classList.remove('selected'));

                 // Marcar el horario clicado como seleccionado
                 scheduleItem.classList.add('selected');
             // Obtener el horario seleccionado
             time = scheduleItem.textContent;

             // Actualizar el campo oculto en el formulario
             document.getElementById('hiddenTime').value = time;

         }

         // Función para limpiar los horarios
         function clearSchedule() {
               const scheduleContainer = document.getElementById('schedule');
               scheduleContainer.innerHTML = '<p>Selecciona un día para ver los horarios disponibles</p>';
         }

         // Inicializar con la fecha actual
         updateDateDisplay();

         // Función para abrir el modal
         function openConfirmationModal() {
             const modal = document.getElementById('confirmationModal');
             modal.style.display = 'block';

             // Actualizar los valores mostrados en el modal
             document.getElementById('selectedDate').textContent = document.getElementById('hiddenDate').value;
             document.getElementById('selectedTime').textContent = document.getElementById('hiddenTime').value;
         }

         // Función para cerrar el modal
         function closeConfirmationModal() {
             const modal = document.getElementById('confirmationModal');
             modal.style.display = 'none';
         }
     </script>
        
</div>





@endsection

<script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
