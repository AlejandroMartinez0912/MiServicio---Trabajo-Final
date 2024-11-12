<?php

namespace App\Http\Controllers;

use App\Models\DatosProfesionales;
use App\Models\Servicio;
use App\Models\Rubro;
use App\Models\User;
use App\Models\DiasSemana;

use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Funcion index
     */
    public function index()
    {
        
        $diasSemana = DiasSemana::all();
        $rubros = Rubro::all();
        return view('Servicios.gestion', compact('rubros', 'diasSemana'));
    }

    /**
     * LOGICA SERVICIOS
     */
    /**
     * mostrar servicios ya creaados
     */
    public function showServices($empresaId)
    {
        /*
        $datosProfesionales = DatosProfesionales::findOrFail($datosProfesionales);
        $servicios = $datosProfesionales->servicios; // Obtener los servicios relacionados con la empresa
        
        foreach ($servicios as $servicio) {
            $servicio->duracion_formateada = $this->formatDuration($servicio->duracion);
        } */

        return view('Servicios.gestion', compact('datosProfesionales', 'servicios'));
    }
    /**
     * Funcion para mostrar la duracion de un servicio
     */
    public function formatDuration($duracion)
    {
        if ($duracion) {
            // Convertir la duración de tipo TIME a segundos
            $segundos = strtotime($duracion) - strtotime('TODAY');

            // Calcular horas y minutos
            $horas = floor($segundos / 3600);
            $minutos = floor(($segundos % 3600) / 60);

            // Formatear como texto legible
            return "{$horas} hora(s) y {$minutos} minuto(s)";
        }
        return 'No disponible';
    }

    /**
     * guardar nuevo servicio
     */
    /**public function storeService(Request $request, $id){
        
        // Validaciones
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'precio_hora' => 'required',
            'precio_fijo' => 'required',
            'duracion' => 'required',
            'modalidad' => 'required'
        ]);

        $servicio = new Servicio();
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->precio = $request->input('precio_fijo');
        $servicio->precio_hora = $request->input('precio_hora');
        $horas = $request->input('horas');
        $minutos = $request->input('minutos');
        $servicio->duracion = sprintf('%02d:%02d:00', $horas, $minutos); 
        $servicio->modalidad = $request->input('modalidad');
        $servicio->estado = (1);
        $servicio->empresa_id = $id;

        try {
            $servicio->save();
            return redirect()->route('gestion-empresa', ['id' => $id])->with('success', 'Servicio creado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Hubo un error al guardar el servicio.');
        }
    } */
    public function guardarServicio(Request $request, $id)
    {
        // Validaciones
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'tipo_presupuesto' => 'required|in:fijo,hora',
            'modalidad' => 'required',
            'horas' => 'required|numeric|min:0',
            'minutos' => 'required|numeric|min:0|max:59',
            'presupuesto_fijo' => 'required_if:tipo_presupuesto,fijo|nullable|numeric',
            'presupuesto_hora' => 'required_if:tipo_presupuesto,hora|nullable|numeric',
        ]);

        $servicio = new Servicio();
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->modalidad = $request->input('modalidad');
        $servicio->estado = 1;
        $servicio->empresa_id = $id;

        // Guardar el presupuesto según el tipo seleccionado
        if ($request->input('tipo_presupuesto') === 'fijo') {
            $servicio->precio_fijo = $request->input('presupuesto_fijo');
            $servicio->precio_hora = null;
        } else {
            $servicio->precio_fijo = null;
            $servicio->precio_hora = $request->input('presupuesto_hora');
        }

        // Procesar y guardar la duración
        $horas = (int) $request->input('horas');
        $minutos = (int) $request->input('minutos');
        $servicio->duracion = sprintf('%02d:%02d:00', $horas, $minutos);

        try {
            $servicio->save();
            return redirect()->route('', ['id' => $id])->with('success', 'Servicio creado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Hubo un error al guardar el servicio.');
        }
    }


    /**
     * Mostrar formulario para editar un servicio.
     */
    public function editarServicio($empresaId, $servicioId)
    {
        $datosProfesionales = datosProfesionales::findOrFail($empresaId);
        $servicio = Servicio::findOrFail($servicioId);
        return view('Empresa.edit_service', compact('empresa', 'servicio'));
    }
    /**
     * Actualizar un servicio existente.
     */
    public function actualizarServicio(Request $request, $empresaId, $servicioId)
    {
        // Validaciones
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'tipo_presupuesto' => 'required|in:fijo,hora', // Validación del tipo de presupuesto
            'precio_fijo' => 'required_if:tipo_presupuesto,fijo|nullable|numeric|min:0',
            'precio_hora' => 'required_if:tipo_presupuesto,hora|nullable|numeric|min:0',
            'horas' => 'required|integer|min:0',
            'minutos' => 'required|integer|min:0|max:59',
            'modalidad' => 'required'
        ]);

        $servicio = Servicio::findOrFail($servicioId);
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->modalidad = $request->input('modalidad');
        $servicio->duracion = sprintf('%02d:%02d:00', $request->input('horas'), $request->input('minutos'));

        // Asignación del presupuesto según el tipo de presupuesto seleccionado
        if ($request->input('tipo_presupuesto') === 'fijo') {
            $servicio->precio_fijo = $request->input('precio');
            $servicio->precio_hora = null;
        } else {
            $servicio->precio_hora = $request->input('precio_hora');
            $servicio->precio_fijo = null;
        }

        try {
            $servicio->save();
            return redirect()->route('gestion-empresa', ['id' => $empresaId])->with('success', 'Servicio actualizado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Hubo un error al actualizar el servicio.');
        }
    }

    /**
     * Eliminar un servicio existente.
     */
    public function eliminarServicio ($empresaId, $servicioId)
    {
        $servicio = Servicio::findOrFail($servicioId);
        try {
            $servicio->estado = 0;
            $servicio->save();            
            return redirect()->route('gestion-empresa', ['id' => $empresaId])->with('success', 'Servicio eliminado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Hubo un error al eliminar el servicio.');
        }
    }
}
