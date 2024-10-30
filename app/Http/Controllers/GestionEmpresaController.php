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
    public function showServices($empresaId)
    {
        $empresa = Empresa::findOrFail($empresaId);
        $servicios = $empresa->servicios; // Obtener los servicios relacionados con la empresa

        return view('Empresa.gestion', compact('empresa', 'servicios'));
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
        
        try{
        $empresa = Empresa::findOrFail($id);
        
        // Actualizar la empresa con los datos generales
        $empresa->update($request->only(['nombre', 'slogan', 'ubicacion']));

        // Asociar los rubros seleccionados a la empresa
        $empresa->rubros()->sync($request->rubros);

        // Limpiar los horarios existentes de la empresa
        $empresa->horarios()->delete();

        // Guardar los horarios de atención (si se ingresaron)
        $this->guardarHorarios($empresa, $request->horarios);

        // Redireccionar con mensaje de éxito
        return response()->json(['success' => true, 'message' => 'La empresa se actualizó correctamente.']);
        } catch (\Exception $e) {
            // Retornar un mensaje de error como respuesta JSON
            return response()->json(['success' => false, 'message' => 'Ocurrió un error al actualizar la empresa: ' . $e->getMessage()], 500);
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
