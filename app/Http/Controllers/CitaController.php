<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Persona;
use App\Models\DatosProfesion;
use App\Models\User;
use App\Models\HorarioTrabajo;
use App\Models\Dias;
use App\Models\Rubro;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CitaController extends Controller
{
    //Mostrar servicios para citar
    public function index(){

        // Obtener el id del usuario autenticado
        $userId = Auth::id(); // O puedes usar Auth::user()->id también
        $datosProfesion = DatosProfesion::where('user_id', $userId)->first();

        // Obtener todos los servicios, pero excluir los creados por el usuario autenticado
        $servicios = Servicio::where('datos_profesion_id', '!=', $datosProfesion->id)->get();

        // Obtener todos los días (si es necesario)
        $dias = Dias::all();

        //Rubros
        $rubros = Rubro::all();

        return view('Cita.gestion', compact('servicios', 'dias', 'rubros'));
    }
}
