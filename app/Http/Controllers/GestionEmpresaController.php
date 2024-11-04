<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Servicio;
use App\Models\Rubro;
use App\Models\HorariosEmpresa;
use App\Models\DiasSemana;

use Illuminate\Http\Request;

class GestionEmpresaController extends Controller
{
    /**
     * Mostrar el formulario de gestión de empresas.
     */
    public function index($empresaId)
    {
        $empresa = Empresa::findOrFail($empresaId); // Obtiene la empresa por su ID o lanza un error si no la encuentra
        $rubros = Rubro::all(); // Obtener todos los rubros
        $servicios = $empresa->servicios; // Obtener los servicios relacionados con la empresa

        return view('Empresa.gestion', compact('empresa', 'rubros', 'servicios')); // Pasa la empresa y los rubros a la vista
    }
}
