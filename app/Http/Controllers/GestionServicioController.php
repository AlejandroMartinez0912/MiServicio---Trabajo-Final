<?php

namespace App\Http\Controllers;

use App\Models\DatosProfesion;
use App\Models\Persona;
use App\Models\User;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GestionServicioController extends Controller
{
    /**
     * Mostrar Gestion de Servicios 
     */

    public function index()
    {
        $userId = Auth::id();         // Obtiene el id del usuario autenticado
        $datosProfesion = DatosProfesion::where('user_id', $userId)->first();
        $promedio = $this-> calificacionTotal();

        return view('Servicios.gestion', compact('userId', 'datosProfesion', 'promedio'));
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
