<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rubro;

class EmpresaController extends Controller
{
    /**
     * Mostrar el formulario de creación de empresas.
     */
    public function create()
    {
        $rubros = Rubro::all(); // Obtener todos los rubros
        return view('Empresa.create', compact('rubros')); // Asegúrate de pasar $rubros a la vista
    }


    /**
     * Guardar una nueva empresa en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos ingresados en el formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'rubros' => 'required|array', // Validar que se seleccionen rubros
            'rubros.*' => 'exists:rubros,id', // Validar que los rubros existan
        ]);

        // Crear una nueva empresa asociada al usuario autenticado
        $empresa = Empresa::create([
            'nombre' => $request->nombre,
            'slogan' => $request->slogan,
            'ubicacion' => $request->ubicacion,
            'user_id' => Auth::id(),
        ]);

        // Asociar los rubros a la empresa
        $empresa->rubros()->attach($request->rubros);

        // Redireccionar a una página después de la creación
        return redirect()->route('gestionar-empresas')->with('success', 'Empresa creada exitosamente.');
    }


    // Mostrar la lista de empresas creadas por el usuario
    public function gestionar()
    {
        $empresas = Empresa::where('user_id', Auth::id())->get();
        return view('Empresa.gestionar', compact('empresas'));
    }

     // Mostrar el formulario de edición de una empresa
     public function edit($id)
     {
         $empresa = Empresa::where('user_id', Auth::id())->findOrFail($id);
         return view('Empresa.editar', compact('empresa'));
     }

     // Eliminar una empresa
    public function destroy($id)
    {
        $empresa = Empresa::where('user_id', Auth::id())->findOrFail($id);
        $empresa->delete();

        return redirect()->route('gestionar-empresas')->with('success', 'Empresa eliminada exitosamente');
    }
}
