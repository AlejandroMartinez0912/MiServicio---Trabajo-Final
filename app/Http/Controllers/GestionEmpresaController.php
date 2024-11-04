<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Servicio;
use App\Models\Rubro;
Use App\Models\HorariosEmpresa;
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
            return redirect()->route('gestion-empresas', ['id' => $id])->with('success', 'Servicio creado con éxito');
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
            return redirect()->route('gestion-empresas', ['id' => $empresaId])->with('success', 'Servicio actualizado con éxito');
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
            return redirect()->route('gestion-empresas', ['id' => $empresaId])->with('success', 'Servicio eliminado con éxito');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Hubo un error al eliminar el servicio.');
        }
    }



    /**
     * LOGICA PARA EDITAR EMPRESA
     */
    /**
     * Mostrar el formulario de edición de una empresa.
     */
    public function editar($id)
    {
        $empresa = Empresa::findOrFail($id); // Obtener la empresa
        $rubros = Rubro::all(); // Obtener todos los rubros
        $horarios = HorariosEmpresa::all(); // Obtener horarios de la empresa

        return view('Empresa.gestion', compact('empresa', 'rubros', 'horarios')); // Pasar datos a la vista
    }
    /**
     * Actualizar una empresa existente.
     */
    public function actualizar(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate($this->rules());
   
        $empresa = Empresa::findOrFail($id);

        try{
        // Actualizar la empresa con los datos generales
        $empresa->update($request->only(['nombre', 'slogan', 'ubicacion']));

        // Asociar los rubros seleccionados a la empresa
        $empresa->rubros()->sync($request->rubros);

        // Limpiar los horarios existentes de la empresa
        $empresa->horarios()->delete();

        // Guardar los horarios de atención (si se ingresaron)
        $this->guardarHorarios($empresa, $request->horarios);

        // Redireccionar con mensaje de éxito
        return redirect()->route('gestion-empresa', ['id' => $empresa->id])->with('success', 'Empresa actualizada con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('gestion-empresa', ['id' => $empresa->id])->with('error', 'Hubo un problema al actualizar la empresa.');
        }
    }

    /**
     * Funciones especiales
     */
    private function guardarHorarios($empresa, $horarios)
    {
        if ($horarios) {
            foreach ($horarios as $dia => $horario) {
                // Cambiar el día a su ID correspondiente
                $diaId = DiasSemana::where('nombre', ucfirst($dia))->first()->id;

                // Iterar sobre los horarios del día
                foreach ($horario['hora_inicio'] as $index => $horaInicio) {
                    if (isset($horaInicio) && isset($horario['hora_fin'][$index])) {
                        // Determinar el turno basado en las horas
                        $turno = $this->determinarTurno($horaInicio, $horario['hora_fin'][$index]);

                        HorariosEmpresa::create([
                            'empresa_id' => $empresa->id,
                            'dia_semana_id' => $diaId,
                            'hora_inicio' => $horaInicio,
                            'hora_fin' => $horario['hora_fin'][$index],
                            'turno' => $turno,
                        ]);
                    }
                }
            }
        }
    }

    /**
     * Determinar el turno según la hora de inicio y fin.
     */
    private function determinarTurno($horaInicio, $horaFin)
    {
        // Convertir a timestamps para facilitar la comparación
        $inicio = strtotime($horaInicio);
        $fin = strtotime($horaFin);

        // Definir los rangos de tiempo para mañana y tarde
        $mananaInicio = strtotime('00:00');
        $mananaFin = strtotime('12:30');
        $tardeInicio = strtotime('13:00');
        $tardeFin = strtotime('23:30');

        // Comprobar en qué turno se encuentra el horario
        if ($inicio >= $mananaInicio && $fin <= $mananaFin) {
            return 'mañana';
        } elseif ($inicio >= $tardeInicio && $fin <= $tardeFin) {
            return 'tarde';
        } elseif($inicio <= $mananaFin && $fin >= $tardeFin) {
            return 'completo';
        }

        return null; // O lanzar una excepción si es necesario
    }

    /**
     * Obtener las reglas de validación para las empresas.
     */
    private function rules()
    {
        return [
            'nombre' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'rubros' => 'required|array',
            'rubros.*' => 'exists:rubros,id',
            'horarios' => 'nullable|array',
        
            // Validación para cada día de la semana
            'horarios.lunes.hora_inicio.*' => 'nullable|date_format:H:i',
            'horarios.lunes.hora_fin.*' => 'nullable|date_format:H:i|after:horarios.lunes.hora_inicio.*',
        
            'horarios.martes.hora_inicio.*' => 'nullable|date_format:H:i',
            'horarios.martes.hora_fin.*' => 'nullable|date_format:H:i|after:horarios.martes.hora_inicio.*',
        
            'horarios.miércoles.hora_inicio.*' => 'nullable|date_format:H:i',
            'horarios.miércoles.hora_fin.*' => 'nullable|date_format:H:i|after:horarios.miércoles.hora_inicio.*',
        
            'horarios.jueves.hora_inicio.*' => 'nullable|date_format:H:i',
            'horarios.jueves.hora_fin.*' => 'nullable|date_format:H:i|after:horarios.jueves.hora_inicio.*',
        
            'horarios.viernes.hora_inicio.*' => 'nullable|date_format:H:i',
            'horarios.viernes.hora_fin.*' => 'nullable|date_format:H:i|after:horarios.viernes.hora_inicio.*',
        
            'horarios.sábado.hora_inicio.*' => 'nullable|date_format:H:i',
            'horarios.sábado.hora_fin.*' => 'nullable|date_format:H:i|after:horarios.sábado.hora_inicio.*',
        
            'horarios.domingo.hora_inicio.*' => 'nullable|date_format:H:i',
            'horarios.domingo.hora_fin.*' => 'nullable|date_format:H:i|after:horarios.domingo.hora_inicio.*',
        ];
    }


}
