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
use App\Mail\CitaConfirmada;
use App\Mail\CitaRechazada;
use App\Mail\CitaRegistrada;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\Mail;
setlocale(LC_TIME, 'es_ES.UTF-8');
use App\Models\Calificacion;        
use Illuminate\Support\Facades\DB;
use App\Models\Auditoria;



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
        $datosProfesion = DatosProfesion::all();
        $user = User::all();
        //Obtener horarios trabajo asociados 
        $horariosTrabajo = HorarioTrabajo::all();


        return view('Cita.gestion', compact('servicios', 'dias', 'rubros', 'persona', 
        'citas', 'horariosTrabajo', 'datosProfesion', 'user'));
    }

    /**
     * Agendar cita
     */
    public function agendarCita(Request $request){

        $idServicio = $request->input('idServicio');
        $servicio = Servicio::findOrFail($idServicio);

        //id de profesion
        $idProfesion = $servicio->datos_profesion_id;
        $datosProfesion = DatosProfesion::findOrFail($idProfesion);
        $user = User::findOrFail($datosProfesion->user_id);
        $persona = Persona::findOrFail($user->id);

        
        //id de persona
        $persona_id = $user->id;
        $citas = Cita::where('idPersona', $persona_id)->get();

        //id dia de horario trabajo
        $horarioTrabajo = HorarioTrabajo::where('datos_profesion_id', $idProfesion)->get();
        $diasDeTrabajo = [];
        foreach ($horarioTrabajo as $horarioTrabajo) {
            $idDia = $horarioTrabajo->dias_id;
            if (!in_array($idDia, $diasDeTrabajo)) {
                $diasDeTrabajo[] = $idDia;
            }
        }


        return view('Cita.agendar', compact('servicio', 'persona',
        'datosProfesion','citas', 'diasDeTrabajo'));
    }

    /**
     * Guardar cita
     */
    public function guardarCita(Request $request)
    { 
        
        //datos de cita de la vista
        $fechaCita = $request->input('fecha');
        $horaInicio = $request->input('horaInicio');
        $idServicio = $request->input('servicio_id');


        //hora fin
        $horaFin = $this->HoraFin($horaInicio, $idServicio);

        //verificar dia hora
        $boolean = $this->verificarDiaHora($fechaCita, $horaInicio, $idServicio, $mensaje);
        if ($boolean == false) {
            return redirect()->back()->with('error', $mensaje);
        }

        $boolean = $this->verificarCita($fechaCita, $horaInicio, $horaFin, $idServicio, $mensaje);
        if ($boolean == false) {
            return redirect()->back()->with('error', $mensaje);
        }
  
        //id de persona
        $userId = Auth::id();
        $idPersona = Persona::where('user_id', $userId)->first();
        $idPersona = $idPersona->id;

        //id de profesion
        $servicio = Servicio::findOrFail($idServicio);
        $idProfesion = $servicio->datos_profesion_id;

        //Convertir fecha
        $fechaCita = Carbon::parse($fechaCita);


        $cita = new Cita([
            'estado' => 0,
            'fechaCita' => $fechaCita,
            'horaInicio' => $horaInicio,
            'horaFin' => $horaFin,
            'idPersona' => $idPersona,
            'idServicio' => $idServicio,
            'idProfesion' => $idProfesion,
            'calificacion_profesion' => $i=0,
            'calificacion_cliente' => $i=0,
        ]);
        // Guardar la cita
        $cita->save();

        $servicio->cantidad_reservas = $servicio->cantidad_reservas + 1;
        $servicio->save();

        // Enviar el correo de confirmación
        $persona = Persona::findOrFail($idPersona);
        $user = User::findOrFail($persona->user_id);
        $usuario = User::findOrFail($user->id);
        Mail::to($usuario->email)->send(new CitaRegistrada($cita));

        $auditoria = new Auditoria();
            $auditoria->user_id = Auth::user()->id;
            $auditoria->accion = 'Creación';
            $auditoria->modulo = 'Citas';
            $auditoria->detalles = 'Creacion de cita: ' . $cita->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();

        
        // Redirigir con éxito
        return redirect()->route('homein')->with('success', 'Cita creada exitosamente.');
                
    }
       /**
    * Funcion para traer hora fin
    */
     public function HoraFin($horaInicio, $idServicio){
        //convertir horaInicio
        $horaInicio = Carbon::parse($horaInicio);

        //traer servicio
        $servicio = Servicio::findOrFail($idServicio);
        //convertir duracion_estimada en hora
        // Convertir la duración estimada (time) en segundos
        $duracionEnSegundos = strtotime($servicio->duracion_estimada) - strtotime('00:00:00');

        // Añadir la duración a la hora de inicio
        $horaFin = $horaInicio->addSeconds($duracionEnSegundos);

        // Devolver la horaFin en formato 'H:i:s' para la base de datos
        return $horaFin->format('H:i:s');
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
     * Funcion para ver si no hay agendada otra cita en esa hora y dia
     */
    public function verificarCita($fecha, $horaInicio,$horaFin, $idServicio, &$mensaje){
        //todas las citas
        $citas = Cita::all();

        //convertir fecha en carbon
        $fecha = Carbon::parse($fecha);

        //convertir hora inicio en carbon
        $horaInicio = Carbon::parse($horaInicio);
        $horaFin = Carbon::parse($horaFin);

        //recorrer citas
        foreach($citas as $cita){
            //convertir fecha cita en carbon
            $fechaCita = Carbon::parse($cita->fechaCita);
            $horaInicioCita = Carbon::parse($cita->horaInicio);
            $horaFinCita = Carbon::parse($cita->horaFin);

            //verificar si el dia de la cita es igual al dia de la cita solicitada
            if($fecha->day == $fechaCita->day){
                //verificar si la hora de inicio de la cita es igual a la hora de inicio de la cita solicitada  
                if($horaInicio->hour == $horaInicioCita->hour){
                    $mensaje = 'Horario no disponible';
                    return false;
                }
                //verificar si la hora de inicio de la cita es igual a la hora de fin de la cita solicitada  
                if($horaInicio->hour == $horaFinCita->hour){
                    $mensaje = 'Horario no disponible';
                    return false;
                }
                //verificar si la hora de fin de la cita es igual a la hora de inicio de la cita solicitada  
                if($horaFin->hour == $horaInicioCita->hour){
                    $mensaje = 'Horario no disponible';
                    return false;
                }
                //verificar si la hora de fin de la cita es igual a la hora de fin de la cita solicitada  
                if($horaFin->hour == $horaFinCita->hour){
                    $mensaje = 'Horario no disponible';
                    return false;
                }
            }
        }
        $mensaje = 'Horario disponible';
        return true;
    }

    /**
     * Confirmar cita especialista
     */
    /**
     * Confirmar cita
     */
    public function confirmarCita(Request $request)
    {
        $IdCita = request()->input('citaId');
        $cita = Cita::find($IdCita);

        if (!$cita) {
            // Redirige con un mensaje de error si no se encuentra la cita
            return redirect()->back()->with('error', 'Cita no encontrada.');
        }

        $cita->estado = 1;
        $cita->save();

        // Enviar el correo de confirmación
        $idPersona = $cita->idPersona;
        $persona = Persona::findOrFail($idPersona);
        $user = User::findOrFail($persona->user_id);
        $usuario = User::findOrFail($user->id);
        Mail::to($usuario->email)->send(new CitaConfirmada($cita));



        return redirect()->route('gestion-servicios')->with('success', 'Cita confirmada');

    }

    /**
     * Cancelar cita
     */
    public function cancelarCita(Request $request)
    {
        $IdCita = request()->input('citaId');
        $cita = Cita::find($IdCita);

        if (!$cita) {
            // Redirige con un mensaje de error si no se encuentra la cita
            return redirect()->back()->with('error', 'Cita no encontrada.');
        }

        $cita->estado = 2;
        $cita->save();

        // Enviar el correo de confirmación
        $idPersona = $cita->idPersona;
        $persona = Persona::findOrFail($idPersona);
        $user = User::findOrFail($persona->user_id);
        $usuario = User::findOrFail($user->id);
        Mail::to($usuario->email)->send(new CitaRechazada($cita));

        $auditoria = new Auditoria();
            $auditoria->user_id = Auth::user()->id;
            $auditoria->accion = 'Eliminar';
            $auditoria->modulo = 'Cita';
            $auditoria->detalles = 'Cita eliminada: ' . $cita->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();

        return redirect()->route('gestion-servicios')->with('success', 'Cita cancelada con éxito.');

    }

    
}




