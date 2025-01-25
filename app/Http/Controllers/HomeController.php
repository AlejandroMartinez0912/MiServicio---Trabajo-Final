<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\Persona;
use App\Models\User;
use App\Models\DatosProfesion;
use App\Models\HorarioTrabajo;
use App\Models\Dias;
use App\Models\Rubro;
use App\Models\MercadoPagoAccount;
use App\Models\CalificacionProfesion;
use App\Models\CalificacionCliente;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
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
        $rubros = Rubro::all();
        $datosProfesion = DatosProfesion::all();
        $user = User::all();
        


        
        return view('Home.homeIn', compact('servicios', 'rubros', 'persona', 
        'datosProfesion', 'user', 'citas'));
    }

    public function search(Request $request)
    {
        $userId = Auth::id();
        $persona = Persona::where('user_id', $userId)->first();
        $datosProfesion = DatosProfesion::where('user_id', $userId)->first();

        // Obtener parámetros de búsqueda
        $search = $request->input('search');
        $rubro = $request->input('rubro');
        $order = $request->input('order');

        // Crear consulta base
        $query = Servicio::query();

        // Aplicar búsqueda por término
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', '%' . $search . '%')
                ->orWhere('descripcion', 'like', '%' . $search . '%');
            });
        }

        /// Filtrar por rubro si está presente
        if ($request->filled('rubro_id')) { 
            $query->whereHas('rubros', function ($subQuery) use ($request) {
                $subQuery->where('rubros.id', $request->input('rubro_id'));
            });
        }

        // Aplicar ordenación si corresponde
        if ($request->filled('order')) {
            $order = $request->input('order');
            if ($order === 'mayor_precio') {
                $query->orderBy('precio_base', 'desc'); // Mayor precio
            } elseif ($order === 'menor_precio') {
                $query->orderBy('precio_base', 'asc'); // Menor precio
            } elseif ($order === 'calificacion') {
                $query->orderBy('calificacion', 'desc'); // Mayor calificación
            }
        }

        // Excluir servicios del usuario si tiene datos profesionales
        if ($datosProfesion) {
            $query->where('datos_profesion_id', '!=', $datosProfesion->id);
        }

        $servicios = $query->get();

        // Obtener otros datos necesarios
        $rubros = Rubro::all();
        $users = User::all();

        return view('Home.homeIn', compact(
            'servicios', 'rubros', 'persona', 
            'datosProfesion', 'users', 'search'
        ));
    }


}
