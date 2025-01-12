<?php

namespace App\Http\Controllers;

use App\Models\DatosProfesion;
use App\Models\Persona;
use App\Models\User;
use App\Models\HorarioTrabajo;
use App\Models\Dias;
use App\Models\Servicio;
use App\Models\Rubro;
use App\Models\Cita;
use App\Models\MercadoPagoAccount;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class GestionServicioController extends Controller
{
    /**
     * Mostrar Gestion de Servicios 
     */

     public function index(Request $request)
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

        // si datosProfesion esta vacios no pasar nada, sino pasar citas del idProfeison
        if ($datosProfesion) {
            // Si $datosProfesion no está vacío, obtener las citas del idProfesion
            $citas = Cita::where('idProfesion', $datosProfesion->id)->get();
        } else {
            // Si $datosProfesion está vacío, devolver una colección vacía
            $citas = collect(); // Crea una colección vacía
        }

        //BUSCAR MERCADO PAGO DEL USER 
        // Buscar cuentas de Mercado Pago para el usuario
        $mercadoPagoAccounts = MercadoPagoAccount::where('user_id', $userId)->get();

        // Verificar si hay cuentas registradas
        if ($mercadoPagoAccounts->isEmpty()) {
            // No hay cuentas de Mercado Pago
            $mercadoPagoAccounts = null;
        }

        // Filtrar citas si hay filtros en la solicitud
        $citasFiltradas = $this->filtro($request);   

         // Pasar los datos a la vista
         return view('Servicios.gestionNew', compact('userId','persona' ,'datosProfesion', 'dias', 
         'promedio', 'horariosTrabajo', 'rubros','servicios', 'citas', 'mercadoPagoAccounts', 'citasFiltradas'));
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

    public function filtro(Request $request)
    {
        $userId = Auth::id();
        $datosProfesion = DatosProfesion::where('user_id', $userId)->first();
    
        if (!$datosProfesion) {
            return collect(); // Retorna una colección vacía si no hay datos de profesión
        }
    
        // Obtener los filtros de la solicitud
        $fecha = $request->input('fecha');
        $cliente = $request->input('cliente');
        $montoMin = $request->input('monto_min'); // Monto mínimo
        $montoMax = $request->input('monto_max'); // Monto máximo
        $servicio = $request->input('servicio'); // Filtro por servicio
    
        // Consultar los datos filtrados
        $citasFiltradas = Cita::where('idProfesion', $datosProfesion->id)
            ->where('estado', 4) // Filtrar por estado pagado
            ->when($fecha, function ($query, $fecha) {
                return $query->whereDate('fechaCita', $fecha);
            })
            ->when($cliente, function ($query, $cliente) {
                return $query->whereHas('persona', function ($q) use ($cliente) {
                    $q->where('nombre', 'like', "%{$cliente}%")
                    ->orWhere('apellido', 'like', "%{$cliente}%");
                });
            })
            ->when($montoMin, function ($query, $montoMin) {
                return $query->whereHas('servicio', function ($q) use ($montoMin) {
                    $q->where('precio_base', '>=', $montoMin);
                });
            })
            ->when($montoMax, function ($query, $montoMax) {
                return $query->whereHas('servicio', function ($q) use ($montoMax) {
                    $q->where('precio_base', '<=', $montoMax);
                });
            })
            ->when($servicio, function ($query, $servicio) {
                return $query->whereHas('servicio', function ($q) use ($servicio) {
                    $q->where('nombre', 'like', "%{$servicio}%");
                });
            })
            ->with(['servicio', 'persona']) // Cargar relaciones
            ->get();
    
        return $citasFiltradas;
    }
    



}
