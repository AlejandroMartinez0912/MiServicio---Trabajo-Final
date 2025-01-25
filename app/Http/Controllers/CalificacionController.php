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

class CalificacionController extends Controller
{
    // FUNCION PARA GUARDAR CALIFICACION A PROFESIONAL Y SERVICIO

    //ver calificaciones pendientes
    public function VerCalificacionesPendientes()
    {
        $id = Auth::user()->id;

        $citasPendientes = Cita::where('calificacion_profesion', 0)
            ->where('idPersona', $id)
            ->get();
            return response()->json($citasPendientes);

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

}
