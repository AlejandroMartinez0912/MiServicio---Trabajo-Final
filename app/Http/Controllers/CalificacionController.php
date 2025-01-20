<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\User;
use App\Models\Persona;
use App\Models\Calificacion;
use App\Models\Profesion;
use App\Models\Servicio;
use App\Models\DatosProfesion;
use Hamcrest\Core\AllOf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CalificacionController extends Controller
{
    public function pendientes()
    {
        $userId = Auth::id();
    
        // Obtener el idProfesional asociado al usuario autenticado
        $idProfesional = DatosProfesion::where('user_id', $userId)->value('id');
    
    
        // Construir la consulta para citas sin calificar
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
        // Verificar que los datos están presentes
        $validated = $request->validate([
            'calificacion' => 'required|integer|min:1|max:5',
            'comentarios' => 'nullable|string|max:255',
        ]);
        
        $cita = Cita::findOrFail($idCita);
        $cita->calificaciones()->create([
            'calificacion' => $request->input('calificacion'),
            'comentario' => $request->input('comentarios'),  // Cambié a comentarios, ya que es el nombre del input
            'tipo' => 'cliente_a_especialista',
        ]);

        //Calificacion por servicio
        $this->guardarCalificacionServicio($idCita);

        //Calificacion por profesional
        $this->promedioCalificacion($idCita);

        //Volver a cargar la misma ruta/vista con un mensaje de calificacion completa
        return redirect()->back()->with('success', 'Calificación guardada exitosamente.');
    }

    //Calificacion por servicio
    public function guardarCalificacionServicio($idCita)
    {
        //Actualizar servicio->calificacion
        
        // Encontrar idServicio
        $cita = Cita::findOrFail($idCita);
        $idProfesion = $cita->idProfesion;
        $idServicio = $cita->idServicio;

        // Encontrar citas con ese idServicio y idProfesion
        $citas = Cita::where('idProfesion', $idProfesion)
            ->where('idServicio', $idServicio)
            ->get();

        //Por cada idCita encontrar calificaciones de esas citas en calificacion con el idCita
        $sumaCalificacion = 0;
        $cantidadCalificaciones = 0;
        foreach ($citas as $cita) {
            $calificacion = Calificacion::where('idCita', $cita->idCita)->first();
            $sumaCalificacion = $sumaCalificacion + $calificacion->calificacion;
            $cantidadCalificaciones = $cantidadCalificaciones + 1;
        }

        //Calcular promedio
        $promedio = $sumaCalificacion / $cantidadCalificaciones;

        //Actualizar servicio->calificacion
        $servicio = Servicio::find($idServicio);
        $servicio->calificacion = $promedio;
        $servicio->save(); 
    }

    //Promedio de calificacion especialista
    public function promedioCalificacion($idCita)
    {
        //Promedio de especialista

        //Tomar idProfesion cita
        $cita = Cita::findOrFail($idCita);
        $idProfesion = $cita->idProfesion;

        $datos_profesion_id = $idProfesion;

        //Encontrar servicios por datos_profesion_id
        $servicios = Servicio::where('datos_profesion_id', $datos_profesion_id)->get();

        //Calcular promedio de calificaciones de servicios
        $sumaCalificacion = 0;
        $cantidadCalificaciones = 0;
        foreach ($servicios as $servicio) {
            $sumaCalificacion = $sumaCalificacion + $servicio->calificacion;
            $cantidadCalificaciones = $cantidadCalificaciones + 1;
        }

        //Promedio de calificaciones
        $promedio = $sumaCalificacion / $cantidadCalificaciones;
        
        //Guardar calificacion especialista en la tabla datos_profesion
        $datosProfesion = DatosProfesion::find($datos_profesion_id);
        $datosProfesion->calificacion = $promedio;
        $datosProfesion->save();

    }




}
