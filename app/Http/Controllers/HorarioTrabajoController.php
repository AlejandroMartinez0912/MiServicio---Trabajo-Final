<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HorarioTrabajo;
use App\Models\DatosProfesion;
use App\Models\Dias;

class HorarioTrabajoController extends Controller
{
    /**
     * Guardar un nuevo horario de trabajo.
     */
    public function guardarHorario(Request $request)
    {
        // Validar los datos del formulario con validaciones personalizadas
        $validated = $request->validate([
            'dia_id' => 'required|exists:dias,id',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'hora_inicio1' => 'nullable|date_format:H:i',
            'hora_fin1' => 'nullable|date_format:H:i',
        ]);

        // Obtener las horas de inicio y fin
        $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFin = \Carbon\Carbon::createFromFormat('H:i', $request->hora_fin);

        //Obtener las horas de inicio1 y fin1
        $horaInicio1 = $request->hora_inicio1 ? \Carbon\Carbon::createFromFormat('H:i', $request->hora_inicio1) : null;
        $horaFin1 = $request->hora_fin1 ? \Carbon\Carbon::createFromFormat('H:i', $request->hora_fin1) : null;
       

        // Llamar a la función de validación de horarios
        $isValid = $this->validarHorario($horaInicio, $horaFin, $horaInicio1, $horaFin1);

        // Si la validación falla, devolver un error con el mensaje correspondiente
        if (!$isValid) {
            return redirect()->route('gestion-servicios')->with('error', 'Los horarios no son válidos o se solapan.')->withInput();        
        }

        //Validar dia no repetido
        $existeHorario = HorarioTrabajo::where('datos_profesion_id', DatosProfesion::where('user_id', Auth::user()->id)->value('id'))
            ->where('dias_id', $request->dia_id)
            ->exists();
        if ($existeHorario) {
        // Si ya existe, devolver un mensaje de error
        return redirect()->route('gestion-servicios')->with('error', 'Ya existe un horario para este día.')->withInput();
        }
        
        // Determinar el turno
        $turno1 = $this->determinarTurno($horaInicio, $horaFin);
        $turno2 = null;

        if ($request->hora_inicio1 && $request->hora_fin1) {
            $turno2 = $this->determinarTurno($horaInicio1, $horaFin1);
        }
        //Asignar a datos_profesion_id el id del usuario logueado
        $datos_profesion_id = DatosProfesion::where('user_id', Auth::user()->id)->value('id');

        $horario = new HorarioTrabajo([
            'datos_profesion_id' => $datos_profesion_id,
            'dias_id' => $request->dia_id,  // Cambiar de dia_id a dias_id si es necesario
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
            'hora_inicio1' => $request->hora_inicio1,
            'hora_fin1' => $request->hora_fin1,
            'turno1' => $turno1,
            'turno2' => $turno2,
            'estado' => true,
        ]);
        // Guardar el horario en la base de datos
        $horario->save();
        
        if ($horario->save()) {
            return redirect()->route('gestion-servicios')->with('success', 'Horario guardado correctamente.');
        } else {
            return redirect()->route('gestion-servicios')->with('error', 'No se pudo guardar correctamente los horarios.')->withInput();        }
    }

    /**
     * Determinar el turno según las horas.
     */
    private function determinarTurno($horaInicio, $horaFin)
    {
        if ($horaInicio->isBetween('00:00', '12:30') && $horaFin->isBetween('00:00', '12:30')) {
            return 'Mañana';
        }

        if ($horaInicio->isBetween('13:00', '23:30') && $horaFin->isBetween('13:00', '23:30')) {
            return 'Tarde';
        }

        return 'Corrido';
    }

    /**
     * Actualizar un horario existente.
     */
    public function actualizarHorario(Request $request, $id)
    {
        // Validar los datos del formulario con validaciones personalizadas
        $validated = $request->validate([
            'dia_id' => 'required|exists:dias,id', // Verifica que el ID del día exista
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'hora_inicio1' => 'nullable|date_format:H:i',
            'hora_fin1' => 'nullable|date_format:H:i',
        ]);
    
        // Obtener las horas de inicio y fin
        $horaInicio = \Carbon\Carbon::createFromFormat('H:i', $request->hora_inicio);
        $horaFin = \Carbon\Carbon::createFromFormat('H:i', $request->hora_fin);
    
        // Obtener las horas de inicio1 y fin1
        $horaInicio1 = $request->hora_inicio1 ? \Carbon\Carbon::createFromFormat('H:i', $request->hora_inicio1) : null;
        $horaFin1 = $request->hora_fin1 ? \Carbon\Carbon::createFromFormat('H:i', $request->hora_fin1) : null;
    
        // Determinar los turnos
        $turno1 = $this->determinarTurno($horaInicio, $horaFin);
        $turno2 = null;
    
        if ($horaInicio1 && $horaFin1) {
            $turno2 = $this->determinarTurno($horaInicio1, $horaFin1);
        }
    
        // Buscar el horario existente en la base de datos
        $horario = HorarioTrabajo::findOrFail($id); // Aquí se obtiene el horario por ID
    
        // Actualizar los campos del horario
        $horario->dia_id = $request->dia_id;
        $horario->hora_inicio = $horaInicio;
        $horario->hora_fin = $horaFin;
        $horario->hora_inicio1 = $horaInicio1;
        $horario->hora_fin1 = $horaFin1;
        $horario->turno1 = $turno1;
        $horario->turno2 = $turno2;
    
        // Guardar los cambios en la base de datos
        if ($horario->save()) {
            return redirect()->route('gestion-servicios')->with('success', 'Horario actualizado correctamente.');
        } else {
            return back()->withErrors(['error' => 'Hubo un problema al actualizar el horario.'])->withInput();
        }
    }
    


    /**
     * Eliminar un horario.
     */
    public function EliminarHorario($id)
    {
        $horario = HorarioTrabajo::findOrFail($id);
        $horario->delete();

        return redirect()->route('gestion-servicios')->with('success', 'Horario eliminado correctamente.');
    }

    /**
     * Anular un horario, cambiando su estado a inactivo.
     */
    public function AnularHorario($id)
    {
        $horario = HorarioTrabajo::findOrFail($id);
        $horario->estado = false;
        $horario->save();

        return redirect()->route('gestion-servicios')->with('success', 'Horario anulado correctamente.');
    }
    /**
     * Activar horario, cambiando su estado a activo
     */
    public function ActivarHorario($id)
    {
        $horario = HorarioTrabajo::findOrFail($id);
        $horario->estado = true;
        $horario->save();

        return redirect()->route('gestion-servicios')->with('success', 'Horario activado correctamente.');
    }

    /**
     * Funcion de validacion de logica de horarios
     */
    public function ValidarHorario($horaInicio, $horaFin, $horaInicio1=null, $horaFin1=null)
    {
         // Validar que la hora de inicio sea menor que la hora de fin en el primer rango
        if ($horaInicio >= $horaFin) {
            return false;
        }

        // Si se proporciona un segundo rango, validar su lógica
        if ($horaInicio1 && $horaFin1) {
            // Validar que la hora de inicio del segundo rango sea menor que su hora de fin
            if ($horaInicio1 >= $horaFin1) {
                return false;
            }

            // Validar que el segundo rango no se solape con el primer rango
            // (El inicio del segundo rango debe ser posterior al fin del primer rango)
            if ($horaInicio1 < $horaFin) {
                return false;
            }
        }

        // Si todo es válido, retornar true
        return true;
    }

}   
