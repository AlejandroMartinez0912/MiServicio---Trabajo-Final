<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Servicio;

use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * LOGICA SERVICIOS
     */
    /**
     * mostrar servicios ya creaados
     */
    public function showServices($empresaId)
    {
        $empresa = Empresa::findOrFail($empresaId);
        $servicios = $empresa->servicios; // Obtener los servicios relacionados con la empresa

        foreach ($servicios as $servicio) {
            $servicio->duracion_formateada = $this->formatDuration($servicio->duracion);
        }

        return view('Empresa.gestion', compact('empresa', 'servicios'));
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
    public function storeService(Request $request, $id){
        
        // Validaciones
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'precio' => 'required',
            'duracion' => 'required',
            'modalidad' => 'required'
        ]);

        $servicio = new Servicio();
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->precio = $request->input('precio');
        $horas = $request->input('horas');
        $minutos = $request->input('minutos');
        $servicio->duracion = sprintf('%02d:%02d:00', $horas, $minutos); 
        $servicio->modalidad = $request->input('modalidad');
        $servicio->empresa_id = $id;

        try {
            $servicio->save();
            return redirect()->route('gestion-empresa', ['id' => $id])->with('success', 'Servicio creado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Hubo un error al guardar el servicio.');
        }
    }

    /**
     * Mostrar formulario para editar un servicio.
     */
    public function editService($empresaId, $servicioId)
    {
        $empresa = Empresa::findOrFail($empresaId);
        $servicio = Servicio::findOrFail($servicioId);
        return view('Empresa.edit_service', compact('empresa', 'servicio'));
    }

    /**
     * Actualizar un servicio existente.
     */
    public function updateService(Request $request, $empresaId, $servicioId)
    {
        // Validaciones
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'precio' => 'required',
            'horas' => 'required|integer|min:0',
            'minutos' => 'required|integer|min:0|max:59',
            'modalidad' => 'required'
        ]);

        $servicio = Servicio::findOrFail($servicioId);
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->precio = $request->input('precio');
        $horas = $request->input('horas');
        $minutos = $request->input('minutos');
        $servicio->duracion = sprintf('%02d:%02d:00', $horas, $minutos);
        $servicio->modalidad = $request->input('modalidad');

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
    public function deleteService($empresaId, $servicioId)
    {
        $servicio = Servicio::findOrFail($servicioId);

        try {
            $servicio->delete();
            return redirect()->route('gestion-empresa', ['id' => $empresaId])->with('success', 'Servicio eliminado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Hubo un error al eliminar el servicio.');
        }
    }
}
