<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\User;
use App\Models\Persona;
use App\Models\Calificacion;
use App\Models\CalificacionCliente;
use App\Models\CalificacionProfesion;

use App\Models\Profesion;
use App\Models\Servicio;
use App\Models\DatosProfesion;
use Hamcrest\Core\AllOf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Auditoria;

class CalificacionController extends Controller
{
    // FUNCION PARA GUARDAR CALIFICACION A PROFESIONAL Y SERVICIO

    //ver calificaciones pendientes
    public function VerCalificacionesPendientes()
    {
        $id = Auth::user()->id;
        $persona = Persona::where('user_id', $id)->first();
        $idPersona = $persona->id;

        // Obtener las citas pendientes
        $citasPendientes = Cita::where('calificacion_profesion', 0)
            ->where('idPersona', $idPersona)
            ->where('estado', 4)
            ->get();

        // Manejar el caso en que no haya citas pendientes
        if ($citasPendientes->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No hay citas pendientes.',
                'data' => [],
            ], 200);
        }

        // Retornar las citas pendientes si existen
        return response()->json([
            'success' => true,
            'message' => 'Citas pendientes obtenidas correctamente.',
            'data' => $citasPendientes,
        ], 200);
    }
    public function GuardarCalificacionProfesion(Request $request, $id)
    {

        $cita = Cita::findOrFail($id);

        $calificacion = new CalificacionProfesion();
        $calificacion->idCita = $cita->idCita;  
        $calificacion->idProfesion = $cita->idProfesion;
        $calificacion->idServicio = $cita->idServicio;
        $calificacion->calificacion = $request->calificacion;
        $calificacion->comentarios = $request->comentario;
        $calificacion->save();

        //actualizar cita con calificacion
        $cita->calificacion_profesion = 1;
        $cita->save();

        //calcular promedio de servicios y profesion
        $this->PromedioProfesional($cita->idServicio, $cita->idProfesion);

        $auditoria = new Auditoria();
            $auditoria->user_id = Auth::user()->id;
            $auditoria->accion = 'Crear';
            $auditoria->modulo = 'Calificacion a profesion';
            $auditoria->detalles = 'Calificacion guardada: ' . $calificacion->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();

        return redirect()->back()->with('success', 'Calificacion guardada exitosamente.');
    }

    //promedio de servicios
    public function PromedioProfesional($idServicio, $idProfesion)
    {
        // Calcular el promedio directamente en la base de datos
        $promedioServicio = CalificacionProfesion::where('idServicio', $idServicio)->avg('calificacion');

        $promedioProfesion = CalificacionProfesion::where('idProfesion', $idProfesion)->avg('calificacion');
        
        //actualizar calificacion en servicios 
        $servicio = Servicio::findOrFail($idServicio);
        $servicio->calificacion = $promedioServicio;
        $servicio->save();
        //actualizar calificacion en profesion
        $profesion = DatosProfesion::findOrFail($idProfesion);
        $profesion->calificacion = $promedioProfesion;
        $profesion->save();
    }

    /**
     * LOGICA PARA CALIFICAR CLIENTE
     */

    public function GuardarCalificacionCliente(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);  

        $calificacion = new CalificacionCliente();
        $calificacion->idCita = $cita->idCita;  
        $calificacion->idPersona = $cita->idPersona;
        $calificacion->calificacion = $request->calificacion;
        $calificacion->comentarios = $request->comentario;
        $calificacion->save();

        //actualizar cita con calificacion
        $cita->calificacion_cliente = 1;
        $cita->save();

        //calcular promedio de cliente
        $this->PromedioCliente($cita->idPersona);

        $auditoria = new Auditoria();
            $auditoria->user_id = Auth::user()->id;
            $auditoria->accion = 'Crear';
            $auditoria->modulo = 'Calificacion a cliente';
            $auditoria->detalles = 'Calificacion guardada: ' . $calificacion->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();

        return redirect()->back()->with('success', 'Calificacion guardada exitosamente.');
    }

    //promedio de cliente
    public function PromedioCliente($idPersona)
    {
        // Calcular el promedio directamente en la base de datos
        $promedioCliente = CalificacionCliente::where('idPersona', $idPersona)->avg('calificacion');
        
        //actualizar calificacion en servicios 
        $persona = Persona::findOrFail($idPersona);
        $persona->calificacion = $promedioCliente;
        $persona->save();
    }

}
