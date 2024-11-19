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





        return view('Cita.gestion', compact('servicios', 'dias', 'rubros', 'persona', 'citas'));
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

        //id de persona
        $userId = Auth::id();
        $idPersona = Persona::where('user_id', $userId)->first();
        $idPersona = $idPersona->id;

        $cita = new Cita([
            'estadoCita' => 'confirmada',
            'fechaCita' => $fechaCita,
            'horaCita' => $horaCita,
            'idPersona' => $idPersona,
            'idServicio' => $idServicio,
        ]);
        // Guardar la cita
        $cita->save();
        // Redirigir con éxito
        return redirect()->route('index-cita')->with('success', 'Cita creada exitosamente.');        
    }

}



