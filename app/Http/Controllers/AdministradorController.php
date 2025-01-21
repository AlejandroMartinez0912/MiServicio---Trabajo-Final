<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministradorController extends Controller
{
    //vista index de administrador
    public function index(){
        return view('Administrador.index');
    }
}
