<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\User;
use App\Models\Persona;
use App\Models\Calificacion;
use Hamcrest\Core\AllOf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function pendientes()
    {
        $userId = Auth::id();

        $citasSinCalificar = Cita::where('idPersona', $userId)
            ->where('estado', 4) // Finalizada
            ->whereDoesntHave('calificaciones', function ($query) {
                $query->where('tipo', 'cliente_a_especialista');
            })
            ->take(1)
            ->get();

        return response()->json([
            'pendientes' => $citasSinCalificar->map(function ($cita) {
                return [
                    'idCita' => $cita->idCita,
                    'idProfesion' => $cita->idProfesion,
                    'fechaCita' => $cita->fechaCita,
                ];
            }),
        ]);
    }

    public function guardarCalificacion(Request $request, $idCita)
    {
        $cita = Cita::findOrFail($idCita);
        $cita->calificaciones()->create([
            'calificacion' => $request->input('calificacion'),
            'comentario' => $request->input('comentarios'),  // Cambié a comentarios, ya que es el nombre del input
            'tipo' => 'cliente_a_especialista',
        ]);

        //Volver a cargar la misma ruta/vista con un mensaje de calificacion completa
        return redirect()->back()->with('success', 'Calificación guardada exitosamente.');
    }



}
