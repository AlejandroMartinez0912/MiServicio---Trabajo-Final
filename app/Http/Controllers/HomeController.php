<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\Persona;
use App\Models\User;
use App\Models\DatosProfesion;
use App\Models\HorarioTrabajo;
use App\Models\Dias;
use App\Models\Rubro;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
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


        return view('homeIn', compact('servicios', 'dias', 'rubros', 'persona', 
        'citas', 'horariosTrabajo', 'datosProfesion', 'user'));
    }

}
