<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Cita;
use App\Mail\NotificacionCita;
use App\Mail\AgendaProfesional;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Persona;
use App\Models\DatosProfesion;


use Illuminate\Http\Request;

class AgendaAutomaticaController extends Controller
{
    /**
     * Metodo enviar recordatorio
     */
    public function enviarRecordatorio(){
        $manana = Carbon::now()->addDay()->toDateString();

        $citas = Cita::whereDate('fechaCita', '=', $manana)->get();
        
        foreach ($citas as $cita) {
            //Encontrar mail de persona
            $email = $cita->persona->user->email;
            // Enviar notificación
            Mail::to($email)->send(new NotificacionCita($cita));

        }

        return response()->json([
            'mensaje' => 'Notificaciones enviadas con éxito.',
            'citas' => $citas
        ]);
    }

    /**
     * Index para confrimar cita
     */
    public function citaConfirmadaIndex($idCita){
        $cita = Cita::findOrFail($idCita);
        $users = $cita->persona->user->id;
        return view('AgendaAutomatica.citaConfirmar', compact('cita', 'users'));
    }
    /**
     * confirmar cita cliente 
     */
    public function citaConfirmada($idCita)
    {
        $cita = Cita::findOrFail($idCita);
        $cita->estado_cliente = 'confirmada'; // o el estado que desees
        $cita->save();
        
        // Redirigir a una página de confirmación o mostrar un mensaje
        return redirect()->route('cita-confirmada-cliente', ['idCita' => $idCita])->with('success', 'Cita confirmada exitosamente.');
    }
    

    /**
     * Generar agenda diaria
     */
    public function generarAgendaDiaria()
    {
        // Obtener la fecha de hoy
        $hoy = Carbon::today();
        
        // Obtener todos los usuarios que tienen una profesión registrada
        $datosProfesion = DatosProfesion::all(); // Todos los profesionales con profesión
        
        // Recorrer a todos los profesionales
        foreach ($datosProfesion as $datoProfesion) {
            // Obtener el ID de la profesión
            $idProfesion = $datoProfesion->id;
        
            // Obtener las citas confirmadas para ese profesional en el día de hoy
            $citasDelDia = Cita::where('idProfesion', $idProfesion)
                                ->where('estado_cliente', 'confirmada')
                                ->whereDate('fechaCita', '=', $hoy)
                                ->get();
        
            // Encontrar el email del usuario asociado
            $email = $datoProfesion->user->email; // Aquí accedes al email del usuario asociado al datoProfesion
        
            // Enviar la notificación (correo) al profesional
            Mail::to($email)->send(new AgendaProfesional($citasDelDia));
        }

        return response()->json(['message' => 'Agenda generada y correos enviados.']);
    }

}
