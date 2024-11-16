<?php

namespace App\Http\Controllers;

use App\Models\DatosProfesion;
use App\Models\Persona;
use App\Models\User;
use App\Models\HorarioTrabajo;
use App\Models\Dias;
use App\Models\Servicio;
use App\Models\Rubro;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GestionServicioController extends Controller
{
    /**
     * Mostrar Gestion de Servicios 
     */

     public function index()
     {
         $userId = Auth::id();  // Obtiene el id del usuario autenticado

         //Obtener datos de persona
         $persona = Persona::where('user_id', $userId)->first();
         
         // Obtener los datos de la profesión del usuario
         $datosProfesion = DatosProfesion::where('user_id', $userId)->first();
         
         // Obtener los horarios de trabajo relacionados con los datos de la profesión
         $horariosTrabajo = $datosProfesion ? $datosProfesion->horariosTrabajo : collect();  // Si no hay datos, se pasa una colección vacía
         
     
         // Obtener el promedio de calificación (ajusta este método según tu implementación)
         $promedio = $this->calificacionTotal();
         
         // Obtener todos los días (si es necesario)
         $dias = Dias::all();

         //Rubros
         $rubros = Rubro::all();

         // Obtener los servicios asociados al datos_profesion_id
        $servicios = $datosProfesion
            ? Servicio::with('rubros')->where('datos_profesion_id', $datosProfesion->id)->get()
            : collect(); // Si no hay datos de profesión, se pasa una colección vacía


         // Pasar los datos a la vista
         return view('Servicios.gestion', compact('userId','persona' ,'datosProfesion', 'dias', 'promedio', 'horariosTrabajo', 'rubros','servicios'));
     }
     

    public function calificacionTotal()
    {
        $userId = Auth::id();  // Obtiene el id del usuario autenticado
    
        // Obtén todas las calificaciones del usuario
        $calificaciones = DatosProfesion::where('user_id', $userId)
                                         ->whereNotNull('calificacion')  // Asegurarse de que la calificación no sea nula
                                         ->get();
    
        // Si existen calificaciones, calculamos el total
        if ($calificaciones->count() > 0) {
            $totalCalificacion = $calificaciones->sum('calificacion');  // Suma todas las calificaciones
            $cantidadCalificaciones = $calificaciones->count();  // Número de calificaciones
            $promedio = $totalCalificacion / $cantidadCalificaciones;  // Calcula el promedio
        } else {
            $promedio = 0;  // Si no hay calificaciones, el promedio es 0
        }
    
        // Redondeamos el promedio a 2 decimales
        $promedio = round($promedio, 2);
        return $promedio;
    }
}
