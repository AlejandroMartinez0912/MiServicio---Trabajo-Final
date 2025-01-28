<?php

namespace App\Http\Controllers;

use App\Models\DatosProfesion;
use App\Models\Servicio;
use App\Models\User;
use App\Models\Rubro;
use App\Models\Auditoria;
use Faker\Provider\ar_EG\Person;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicioController extends Controller
{
    /**
     * LOGICA SERVICIOS
     */

     //Guardar servicio
     public function guardarServicio(Request $request)
    {
        // Validar datos
        $validacion = $this->validarServicios($request);

        if ($validacion['status'] === true) {
            // Validar id de datos profesion
            $userId = Auth::id();
            $datosProfesion = DatosProfesion::where('user_id', $userId)->first();

            // Crear servicio
            $servicio = new Servicio();
            $servicio->nombre = $request->input('nombre');
            $servicio->descripcion = $request->input('descripcion');
            $servicio->precio_base = $request->input('precio_base');
            $servicio->duracion_estimada = $request->input('duracion_estimada');
            $servicio->estado = 'Activo';
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

            $auditoria = new Auditoria();
            $auditoria->user_id = $userId;
            $auditoria->accion = 'Creación';
            $auditoria->modulo = 'Servicios';
            $auditoria->detalles = 'Servicio creado: ' . $servicio->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
            

            return redirect()->route('gestion-servicios')->with('success', 'Servicio creado exitosamente.');
        } else {
            // Si falla la validación, redirigir con el mensaje de error
            return redirect()->back()->with('error', $validacion['message']);
        }
    }


     /**
      * Funcion para actualizar servicio
      */
      public function actualizarServicio(Request $request, $id)
      {
          $servicio = Servicio::findOrFail($id);
          $userId = Auth::id();
      
          // Actualizamos los datos del servicio
          $servicio->update([
              'nombre' => $request->nombre,
              'descripcion' => $request->descripcion,
              'precio_base' => $request->precio_base,
              'duracion_estimada' => $request->duracion_estimada,
          ]);
      
          // Actualizamos los rubros asociados (tabla pivote)
          $servicio->rubros()->sync($request->rubros);

          $auditoria = new Auditoria();
          $auditoria->user_id = $userId;
          $auditoria->accion = 'Actualización';
          $auditoria->modulo = 'Servicios';
          $auditoria->detalles = 'Servicio actualizado: ' . $servicio->id;
          $auditoria->ip = request()->ip();
          $auditoria->save();
          
      
          return redirect()->route('gestion-servicios')->with('success', 'Servicio actualizado exitosamente.');
      }
      /**
       * Funcion para eliminar servicio
       */
       public function eliminarServicio($id)
       {
           $servicio = Servicio::findOrFail($id);
           $servicio->delete();

           $user = Auth::user();

           $auditoria = new Auditoria();
           $auditoria->user_id = $user->id;
           $auditoria->accion = 'Eliminación';
           $auditoria->modulo = 'Servicios';
           $auditoria->detalles = 'Servicio eliminado: ' . $servicio->id;
           $auditoria->ip = request()->ip();
           $auditoria->save();
           
           return redirect()->route('gestion-servicios')->with('success', 'Servicio eliminado exitosamente.');
       }
       /**
        * Funcion para anular servicio
        */
        public function anularServicio($id)
        {
            $servicio = Servicio::findOrFail($id);
            $servicio->estado = 'Inactivo';
            $servicio->save();

            $user = Auth::user();

            $auditoria = new Auditoria();
            $auditoria->user_id = $user->id;
            $auditoria->accion = 'Anulación';
            $auditoria->modulo = 'Servicios';
            $auditoria->detalles = 'Servicio anulado: ' . $servicio->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
            
            return redirect()->route('gestion-servicios')->with('success', 'Servicio anulado exitosamente.');
        }
        /**
         * Funcion para activar servicio
         */
        public function activarServicio(Request $request, $id)
        {
            $servicio = Servicio::findOrFail($id);

            $user = $servicio->datos_profesion->user->id;

            // Actualizar el estado del servicio a activo
            $servicio->estado = 'Activo'; 
            $servicio->save();


            $auditoria = new Auditoria();
            $auditoria->user_id = $user->id;
            $auditoria->accion = 'Activación';
            $auditoria->modulo = 'Servicios';
            $auditoria->detalles = 'Servicio activado: ' . $servicio->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
            

            return redirect()->route('gestion-servicios')->with('success', 'Servicio activado exitosamente.');
        }
        /**
         * Funcion para validar servicios
         */
        public function validarServicios(Request $request)
        {
            $nombre = $request->input('nombre');
            $descripcion = $request->input('descripcion');
            $precio_base = $request->input('precio_base');
            $duracion_estimada = $request->input('duracion_estimada');

            // Validar que todos los campos sean obligatorios
            if (!$nombre || !$descripcion || !$precio_base || !$duracion_estimada) {
                return ['status' => false, 'message' => 'Todos los campos son obligatorios.'];
            }

            // Validar que el nombre no sea vacío y no contenga solo números
            if (empty(trim($nombre)) || is_numeric($nombre)) {
                return ['status' => false, 'message' => 'El nombre no puede estar vacío ni contener solo números.'];
            }

            // Validar longitud del nombre
            if (strlen($nombre) > 255) {
                return ['status' => false, 'message' => 'El nombre no puede exceder los 255 caracteres.'];
            }

            // Validar descripción
            if (strlen($descripcion) > 500) {
                return ['status' => false, 'message' => 'La descripción no puede exceder los 500 caracteres.'];
            }

            // Validar que el precio base no sea negativo o cero
            if ($precio_base <= 0) {
                return ['status' => false, 'message' => 'El precio base debe ser mayor que cero.'];
            }

            // Validar duración estimada
            if ($duracion_estimada <= 0) {
                return ['status' => false, 'message' => 'La duración estimada debe ser mayor que cero.'];
            }

            // Si todas las validaciones pasan
            return ['status' => true, 'message' => ''];
        }



      
 
}
   


    
