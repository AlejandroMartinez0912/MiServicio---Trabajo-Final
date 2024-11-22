<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DatosProfesion;
use App\Models\Rubro;
use App\Models\Dia;
use App\Models\HorarioTrabajo;
use App\Models\Persona;
use App\Models\User;

use Illuminate\Support\Facades\Auth;

class DatosProfesionController extends Controller
{
    /**
     * Método para guardar los datos profesionales.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function guardarDatos(Request $request)
    {
        $userId = Auth::id(); // Obtiene el ID del usuario autenticado
        // Validar los datos que recibimos del formulario
        $validatedData = $request->validate([
            'nombre_fantasia' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'experiencia' => 'required|integer|min:0',

        ]);
        // Crear un nuevo registro de datos profesionales
        $datosProfesion = new DatosProfesion();
        $datosProfesion->user_id = $userId;
        $datosProfesion->nombre_fantasia = $validatedData['nombre_fantasia'];
        $datosProfesion->slogan = $validatedData['slogan'];
        $datosProfesion->ubicacion = $validatedData['ubicacion'];
        $datosProfesion->telefono = $validatedData['telefono'];
        $datosProfesion->experiencia = $validatedData['experiencia'];
        $datosProfesion->calificacion = 0;
        $datosProfesion->estado = 1;
        $datosProfesion->save();

        //Actualizar estado en persona a persona con profesion
        $userId = Auth::id();         // Obtiene el id del usuario autenticado
        $estadoProfesion = Persona::where('user_id', $userId)->value('estado_profesional');  // Obtiene el estado profesional del usuario
        // Si estadoProfesion es 0 (inactivo), se guardan los datos profesionales
        if ($estadoProfesion == 0) {
            //actualizar estado en persona
            Persona::where('user_id', $userId)->update(['estado_profesional' => 1]);
        }


        // Devolver una respuesta
        return redirect()->route('gestion-servicios')->with('success', 'Datos guardados correctamente.');
    }
    /**
     * Método para actualizar los datos profesionales.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function actualizarDatos(Request $request, $id)
    {
        $datosProfesion = DatosProfesion::findOrFail($id);

        $validatedData = $request->validate([
            'slogan' => 'nullable|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:255',
            'estado' => 'required|boolean',
        ]);

        //Actualizar datos
        $datosProfesion->slogan = $validatedData['slogan'];
        $datosProfesion->ubicacion = $validatedData['ubicacion'];
        $datosProfesion->telefono = $validatedData['telefono'];
        //$datosProfesion->experiencia = $validatedData['experiencia'];   
        $datosProfesion->estado = $validatedData['estado'];
        $datosProfesion->save();

        return redirect()->route('gestion-servicios')->with('success', 'Datos actualizados correctamente.');
    }

}
