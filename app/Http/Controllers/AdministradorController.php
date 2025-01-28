<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\User;
use App\Models\DatosProfesion;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\Calificacion;
use App\Models\CalificacionCliente;
use App\Models\CalificacionProfesion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Rubro;
use App\Models\MercadoPagoAccount;
use App\Models\Auditoria;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class AdministradorController extends Controller
{
    //vista index de administrador
    public function index(){
        return view('Administrador.index');
    }

    //Cargar vistas dentro del index,
    public function usuarios()
    {
        //Pasar usuarios
        $usuarios = User::all();
        $persona = Persona::all();
        $profesiones = DatosProfesion::with('user.persona')->get();
        return view('Administrador.usuarios', compact('usuarios', 'persona', 'profesiones'));
    }
    //Desactivar usuario
    public function desactivarUsuario($id){
        $user = User::find($id);
        $user->estado = 0;
        $user->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 9;
            $auditoria->accion = 'Eliminar';
            $auditoria->modulo = 'Usuarios';
            $auditoria->detalles = 'Usuario eliminado: ' . $user->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();

        return redirect()->back()->with('success', 'Usuario desactivado');
    }
    //Activar usuario
    public function activarUsuario($id){
        $user = User::find($id);
        $user->estado = 1;
        $user->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 9;
            $auditoria->accion = 'Activar';
            $auditoria->modulo = 'Usuarios';
            $auditoria->detalles = 'Usuario activado: ' . $user->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
        return redirect()->back()->with('success', 'Usuario activado');
    }

    //Activar y desactivar profesional
    // Desactivar Profesional
    public function desactivarProfesional($idProfesion){
        $profesion = DatosProfesion::find($idProfesion);
        $profesion->estado = 0;
        $profesion->save();

        //desactivar todoas los servicios del profesional
        $servicios = Servicio::where('datos_profesion_id', $idProfesion)->get();
        foreach ($servicios as $servicio) {
            $servicio->estado = 'inactivo';
            $servicio->save();
        }

        $auditoria = new Auditoria();
            $auditoria->user_id = 9;
            $auditoria->accion = 'Desactivar';
            $auditoria->modulo = 'DatoProfesion';
            $auditoria->detalles = 'Profesional desactivado: ' . $profesion->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
        return redirect()->back()->with('success', 'Profesional desactivado');
    }

    // Activar Profesional
    public function activarProfesional($idProfesion){
        $profesion = DatosProfesion::find($idProfesion);
        $profesion->estado = 1;
        $profesion->save();

        //activar todos los servicios del profesional
        $servicios = Servicio::where('datos_profesion_id', $idProfesion)->get();
        foreach ($servicios as $servicio) {
            $servicio->estado = 'activo';
            $servicio->save();
        }

        $auditoria = new Auditoria();
            $auditoria->user_id = 9;
            $auditoria->accion = 'Activar';
            $auditoria->modulo = 'DatoProfesion';
            $auditoria->detalles = 'Profesional activado: ' . $profesion->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
        return redirect()->back()->with('success', 'Profesional activado');
    }

    //Ver perfil de usuario
    
    public function verPerfil($id){
        $user = User::find($id);
        $persona = Persona::where('user_id', $id)->first();
        $citas = Cita::where('idPersona', $id)
        ->with('calificacionesProfesion')
        ->with('calificacionesCliente')
        ->get();
       

        return view('Administrador.usuariosPerfil', compact('user', 'persona', 'citas'));
    }
    //actualizar perfil de usuario
    public function actualizarPerfil(Request $request, $id){
        $user = User::find($id);
        $user->email = $request->input('email');
        $user->save();

        $persona = Persona::where('user_id', $id)->first();
        $persona->nombre = $request->input('nombre');
        $persona->apellido = $request->input('apellido');
        $persona->domicilio = $request->input('domicilio');
        $persona->fecha_nacimiento = $request->input('fecha_nacimiento');
        $persona->documento = $request->input('documento');
        $persona->telefono = $request->input('telefono');
        $persona->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 9;
            $auditoria->accion = 'Actualizar';
            $auditoria->modulo = 'Usuarios';
            $auditoria->detalles = 'Perfil actualizado: ' . $user->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();

        return redirect()->back()->with('success', 'Perfil actualizado');
    }


    //ver perfil de profesional
    public function verPerfilProfesional($idProfesion){
        $profesion = DatosProfesion::find($idProfesion)->with('user.persona')->first();
        $servicios = Servicio::where('datos_profesion_id', $idProfesion)->get();
        $calificacionesProfesion = CalificacionProfesion::where('idProfesion', $idProfesion)->get();
        $citas = Cita::where('idProfesion', $idProfesion)->get();
        return view('Administrador.profesionalesPerfil', compact('profesion', 'servicios', 'calificacionesProfesion', 'citas'));
    }
    


    /**
     * LOGICA DE SERVCIOS
     */

    public function servicios(){
        $servicios = Servicio::with('datosProfesion.user.persona')->get();
        return view('Administrador.servicios', compact('servicios'));
    }
    
    // desactivar servicio
    public function desactivarServicio($id){
        $servicio = Servicio::find($id);
        $servicio->estado = 'inactivo';
        $servicio->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 9;
            $auditoria->accion = 'Desactivar';
            $auditoria->modulo = 'Servicios';
            $auditoria->detalles = 'Servicio desactivado: ' . $servicio->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
        return redirect()->back()->with('success', 'Servicio desactivado');
    }   
    //activar servicio
    public function activarServicio($id){
        $servicio = Servicio::find($id);
        $servicio->estado = 'activo';
        $servicio->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 9;
            $auditoria->accion = 'Activar';
            $auditoria->modulo = 'Servicios';
            $auditoria->detalles = 'Servicio activado: ' . $servicio->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();

        return redirect()->back()->with('success', 'Servicio activado');
    }

    //actualizar servicio
    public function actualizarServicio(Request $request, $id){

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio_base' => 'required|numeric|min:0',
            'duracion_estimada' => 'nullable|numeric|min:0',
        ]);

        $servicio = Servicio::find($id);
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->precio_base = $request->input('precio_base');
        $servicio->duracion_estimada = $request->input('duracion_estimada');
        $servicio->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 9;
            $auditoria->accion = 'Actualizar';
            $auditoria->modulo = 'Servicios';
            $auditoria->detalles = 'Servicio actualizado: ' . $servicio->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
    
        return redirect()->back()->with('success', 'Servicio actualizado');
    }

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
 
    public function pagos()
    {
        return view('Administrador.pagos');
    }
}
