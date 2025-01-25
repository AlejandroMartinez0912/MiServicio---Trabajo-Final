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
        $profesiones = DatosProfesion::all();
        return view('Administrador.usuarios', compact('usuarios', 'persona', 'profesiones'));
    }
    //Desactivar usuario
    public function desactivarUsuario($id){
        $user = User::find($id);
        $user->estado = 0;
        $user->save();
        return redirect()->route('admin-usuarios')->with('success', 'Usuario desactivado');
    }
    //Activar usuario
    public function activarUsuario($id){
        $user = User::find($id);
        $user->estado = 1;
        $user->save();
        return redirect()->route('admin-usuarios')->with('success', 'Usuario activado');
    }

    //Activar y desactivar profesional
    // Desactivar Profesional
    public function desactivarProfesional($idProfesion){
        $profesion = DatosProfesion::find($idProfesion);
        $profesion->estado = 0;
        $profesion->save();
        return redirect()->route('admin-usuarios')->with('success', 'Profesional desactivado');
    }

    // Activar Profesional
    public function activarProfesional($idProfesion){
        $profesion = DatosProfesion::find($idProfesion);
        $profesion->estado = 1;
        $profesion->save();
        return redirect()->route('admin-usuarios')->with('success', 'Profesional activado');
    }

    //Ver perfil de usuario
    
    public function verPerfil($id){
        $user = User::find($id);
        $persona = Persona::where('user_id', $id)->first();
        $citas = Cita::where('idPersona', $id)->get();
        //por cada cita encontrar calificaciones de esas citas en calificacion con el idCita y agendar en cada cita su calificacion

        foreach ($citas as $cita) {
            $cita->calificacion_profesion = CalificacionProfesion::where('idCita', $cita->id)->first();
            $cita->calificacion_cliente = CalificacionCliente::where('idCita', $cita->id)->first();
        }

        return view('Administrador.usuariosPerfil', compact('user', 'persona', 'citas'));
    }


    /**
     * LOGICA DE SERVCIOS
     */
    public function servicios()
    {
        return view('Administrador.servicios');
    }

    public function pagos()
    {
        return view('Administrador.pagos');
    }
}
