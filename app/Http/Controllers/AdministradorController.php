<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\User;
use App\Models\DatosProfesion;

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
