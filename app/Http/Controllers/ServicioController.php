<?php

namespace App\Http\Controllers;

use App\Models\DatosProfesion;
use App\Models\Servicio;
use App\Models\User;
use App\Models\Rubro;

use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * LOGICA SERVICIOS
     */

     //Guardar servicio
     public function guardarServicio(Request $request)
     {
        //Validar id de datos profesion
        $userId = Auth::id(); 
        $datosProfesion = DatosProfesion::where('user_id', $userId)->first();

        //Crear servicio
        $servicio = new Servicio();
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->precio_base = $request->input('precio_base');
        $servicio->duracion_estimada = $request->input('duracion_estimada');
        $servicio->estado = 1;
        $servicio->calificacion = 0;
        $servicio->cantidad_reservas = 0;
        $servicio->datos_profesion_id = $datosProfesion->id; 
         
        $servicio->save();

         // Asociar los rubros seleccionados con el servicio
        $rubros = $request->input('rubros'); // Obtener los rubros seleccionados del formulario
        
        if ($rubros) {
            // Usar el método sync para agregar los rubros a la tabla pivote
            $servicio->rubros()->sync($rubros);
        }
 
        return redirect()->route('gestion-servicios')->with('success', 'Servicio creado exitosamente.');
     }

     /**
      * Funcion para actualizar servicio
      */
      public function actualizarServicio(Request $request, $id)
      {
          $servicio = Servicio::findOrFail($id);
      
          // Actualizamos los datos del servicio
          $servicio->update([
              'nombre' => $request->nombre,
              'descripcion' => $request->descripcion,
              'precio_base' => $request->precio_base,
              'duracion_estimada' => $request->duracion_estimada,
          ]);
      
          // Actualizamos los rubros asociados (tabla pivote)
          $servicio->rubros()->sync($request->rubros);
      
          return redirect()->route('gestion-servicios')->with('success', 'Servicio actualizado exitosamente.');
      }
      /**
       * Funcion para eliminar servicio
       */
       public function eliminarServicio($id)
       {
           $servicio = Servicio::findOrFail($id);
           $servicio->delete();
           return redirect()->route('gestion-servicios')->with('success', 'Servicio eliminado exitosamente.');
       }
       /**
        * Funcion para anular servicio
        */
        public function anularServicio($id)
        {
            $servicio = Servicio::findOrFail($id);
            $servicio->estado = 'inactivo';
            $servicio->save();
            return redirect()->route('gestion-servicios')->with('success', 'Servicio anulado exitosamente.');
        }
        /**
         * Funcion para activar servicio
         */
        public function activarServicio(Request $request, $id)
        {
            $servicio = Servicio::findOrFail($id);

            // Actualizar el estado del servicio a activo
            $servicio->estado = 'activo'; 
            $servicio->save();

            return redirect()->route('gestion-servicios')->with('success', 'Servicio activado exitosamente.');
        }

      
 
}
   


    
