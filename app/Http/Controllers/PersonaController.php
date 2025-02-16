<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Auditoria;

class PersonaController extends Controller
{
    // Mostrar perfil
    public function edit()
    {
        $persona = Auth::user()->persona;
        return view('Perfil/perfil', compact('persona'));
    }

    // Actualizar perfil
    public function update(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:50',
            'apellido' => 'required|max:50',
            'domicilio' => 'required|max:100',
            'fecha_nacimiento' => 'required|date',
            'documento' => 'required|numeric|unique:persona,documento,' . Auth::user()->persona->id,
            'telefono' => 'required|max:15',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $persona = Auth::user()->persona;

        // Si se subió una nueva foto
        if ($request->hasFile('foto')) {
            // Eliminar la foto anterior si existe
            if ($persona->foto && Storage::exists('public/perfiles/' . $persona->foto)) {
                Storage::delete('public/perfiles/' . $persona->foto);
            }

            // Guardar la nueva foto
            $filename = $request->file('foto')->store('public/perfiles');
            $persona->foto = basename($filename);
        }

        $personaViejo = $persona;

        try {
        // Actualizar otros datos
        $persona->update($request->only([
            'nombre', 
            'apellido', 
            'domicilio', 
            'fecha_nacimiento', 
            'documento', 
            'telefono'
        ]));

        $detalles =
            "Domicilio anterior: " . $personaViejo->domicilio . "\n" .  
            "Domicilio nuevo: " . $request->input('domicilio') . "\n".
            "Teléfono anterior: " . $personaViejo->telefono . "\n" .  
            "Teléfono nuevo: " . $request->input('telefono') . "\n"
            ;
    
        $auditoria = new Auditoria();
        $auditoria->user_id = $persona->user_id;
        $auditoria->accion = 'Actualizar';
        $auditoria->modulo = 'Usuarios';
        $auditoria->detalles = $detalles;
        $auditoria->ip = request()->ip();
        $auditoria->save();
        
        // Mensaje de exito.
        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
        } catch (\Exception $e) {
            // Mensaje de error
            return redirect()->back()->with('error', 'Hubo un problema al guardar los datos.');
        }
    }
}
