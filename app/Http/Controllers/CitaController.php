<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Persona;
use App\Models\DatosProfesion;
use App\Models\User;
use App\Models\HorarioTrabajo;
use App\Models\Dias;
use App\Models\Rubro;
use App\Models\Cita;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CitaController extends Controller
{
    /**
     * Mostrar servicios para citar
     */
    public function index(){

        // Obtener el id del usuario autenticado
        $userId = Auth::id();

        $datosProfesion = DatosProfesion::where('user_id', $userId)->first();

        //id de persona
        $persona = Persona::where('user_id', $userId)->first();
        $idPersona = $persona->id;

        $citas = Cita::where('idPersona', $idPersona)->get();

        //SI el cliente tiene datos profesionales
        if ($datosProfesion) {
             // Obtener todos los servicios, pero excluir los creados por el usuario autenticado
            $servicios = Servicio::where('datos_profesion_id', '!=', $datosProfesion->id)->get();

        }
        else{
            // Obtener todos los servicios
            $servicios = Servicio::all();
        }


        // Obtener todos los días y rubros
        $dias = Dias::all();
        $rubros = Rubro::all();

        //Obtener horarios trabajo asociados 
        $horariosTrabajo = HorarioTrabajo::all();


        return view('Cita.gestion', compact('servicios', 'dias', 'rubros', 'persona', 'citas', 'horariosTrabajo'));
    }
    /**
     * Guardar cita
     */
    public function guardarCita(Request $request)
    {   
        //datos de cita de la vista
        $fechaCita = $request->input('fecha');
        $horaCita = $request->input('hora');
        $idServicio = $request->input('servicio_id');

        // Verificar que no haya citas duplicadas en el mismo día y hora
        $mensaje2 = '';
        $boolean = $this->verificarCitas($fechaCita, $horaCita, $idServicio, $mensaje2);

        // Si ya hay una cita en el mismo día y hora, redirigir con error
        if ($boolean == false) {
            return redirect()->route('index-cita')->with('error', $mensaje2);
        }
                
        //id de persona
        $userId = Auth::id();
        $idPersona = Persona::where('user_id', $userId)->first();
        $idPersona = $idPersona->id;

        //id de profesion
        $servicio = Servicio::findOrFail($idServicio);
        $idprofesion = $servicio->datos_profesion_id;

        $cita = new Cita([
            'estadoCita' => 'confirmada',
            'fechaCita' => $fechaCita,
            'horaCita' => $horaCita,
            'idPersona' => $idPersona,
            'idServicio' => $idServicio,
            'idProfesion' => $idprofesion,
        ]);
        // Guardar la cita
        $cita->save();

        $servicio->cantidad_reservas = $servicio->cantidad_reservas + 1;
        $servicio->save();
        
        // Redirigir con éxito
        return redirect()->route('index-cita')->with('success', 'Cita creada exitosamente.');
                
    }

    /**
     * Funcion para ver horario disponible en la cita solicitada
     */
    public function verificarDiaHora($fecha, $hora, $idServicio, &$mensaje)
    {
        // Servicio del id solicitado
        $servicio = Servicio::findOrFail($idServicio);

        // Obtener horarios de trabajo del profesional
        $idprofesion = $servicio->datos_profesion_id;
        $horariosTrabajo = HorarioTrabajo::where('datos_profesion_id', $idprofesion)->get();

        // Obtener todas las citas
        $citas = Cita::all();

        // Obtener el día de la semana de la cita solicitada
        $fechaCarbon = Carbon::parse($fecha);
        $diaSemana = $fechaCarbon->dayOfWeek;

        // Verificar horarios
        foreach ($horariosTrabajo as $horario) {
            // Validar si el profesional trabaja en el día solicitado
            if ($diaSemana == $horario->dias_id) {
                // Convertir la hora solicitada a un objeto Carbon
                $horaSolicitada = Carbon::parse($hora);
                $horaInicio = Carbon::parse($horario->hora_inicio);
                $horaFin = Carbon::parse($horario->hora_fin);

                // Verificar primer horario de trabajo
                if ($horaSolicitada->between($horaInicio, $horaFin)) {
                    $mensaje = 'Horario disponible.';
                    return true; // Si encuentra un horario válido, retorna true
                }

                // Verificar segundo horario de trabajo
                if ($horario->hora_inicio1 && $horario->hora_fin1) {
                    $horaInicio1 = Carbon::parse($horario->hora_inicio1);
                    $horaFin1 = Carbon::parse($horario->hora_fin1);

                    if ($horaSolicitada->between($horaInicio1, $horaFin1)) {
                        $mensaje = 'Horario disponible.';
                        return true;
                    }
                }

                $mensaje = 'El profesional no trabaja en la hora solicitada.';
                return false;
            }
        }

        // Si no se encuentra ningún horario para el día solicitado
        $mensaje = 'El profesional no trabaja en el día solicitado.';
        return false;
    }

    /**
     * Funcion para verificar si no hay agendado otra cita en el mismo dia y horario
     */
    public function verificarCitas($fecha, $hora, $idServicio, &$mensaje) {
        // Obtener todas las citas
        $citas = Cita::all();
   
        // Obtener el id del servicio y del profesional
        $servicio = Servicio::findOrFail($idServicio);
        $idProfesional = $servicio->datos_profesion_id;
   
        // Convertir la hora y fecha solicitadas
        $horaSolicitada = Carbon::parse($hora);
        $fechaSolicitada = Carbon::parse($fecha);
   
        // Recorrer todas las citas para verificar conflicto
        foreach ($citas as $cita) {
            // Convertir la fecha y hora de las citas en la base de datos
            $fechaCita = Carbon::parse($cita->fechaCita);
            $horaCita = Carbon::parse($cita->horaCita);
   
            // Verificar si la cita es del mismo profesional
            if ($cita->idProfesion == $idProfesional) {
                // Verificar si la fecha y hora coinciden
                if ($fechaCita == $fechaSolicitada){
                    if ($horaCita == $horaSolicitada) {
                        $mensaje = 'Ya hay una cita agendada en el mismo dia y horario.';
                        return false;  // No está disponible
                    }
                }
            }
        }
        // Si no hay conflicto
        $mensaje = 'Cita disponible.';
        return true;  // Disponible
   }
   

}



