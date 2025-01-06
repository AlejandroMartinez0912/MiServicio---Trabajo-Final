<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagoAutomaticoController extends Controller
{
    //pago de la cita
    public function index()
    {
        return view('PagoAutomatico.index');
    }
}
