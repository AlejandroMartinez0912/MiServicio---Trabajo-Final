<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DatosProfesionales;
use App\Models\Rubro;
use App\Models\DiasSemana;
use App\Models\HorariosTrabajo;

class DatosProfesionalesController extends Controller
{

    /**
     * Guardar los datos profesionales en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        //$request->validate($this->rules());

        try{
            // Crear un nuevo objeto de datos profesionales
            $datosProfesionales = DatosProfesionales::create([
                'nombre_fantasia' => $request->nombre_fantasia,
                'slogan' => $request->slogan,
                'ubicacion' => $request->ubicacion,
                'estado' => 1,
                'user_id' => Auth::id(),
            ]);

            // Asociar los rubros seleccionados a la empresa
            $datosProfesionales->rubros()->attach($request->rubros);

            // Asociar los horarios de trabajo seleccionados a los datos
            // Guardar los horarios de atención (si se ingresaron)
            $this->guardarHorarios($datosProfesionales, $request->horarios);

            

        // Redireccionar con mensaje de éxito
        return redirect()->route('gestion-servicios')->with('success', 'Datos profesionales guardados exitosamente.');
        } catch (\Exception $e) {
            // Mensaje de error
            return redirect()->back()->with('error', 'Hubo un problema al guardar los datos.');
        }
    }

    /**
     * Guardar horarios de atención de la empresa.
     */
    private function guardarHorarios(DatosProfesionales $datosProfesionales, $horarios)
    {
        foreach ($horarios as $horario) {
            // Crear una nueva instancia de HorariosTrabajo
            $horarioTrabajo = new HorariosTrabajo();
            $horarioTrabajo->datos_profesionales_id = $datosProfesionales->id;
            $horarioTrabajo->dia_semana_id = $horario['dia_semana_id'];
            $horarioTrabajo->hora_inicio = $horario['hora_inicio'];
            $horarioTrabajo->hora_fin = $horario['hora_fin'];
            $horarioTrabajo->hora_inicio1 = $horario['hora_inicio1'] ?? null;
            $horarioTrabajo->hora_fin1 = $horario['hora_fin1'] ?? null;

            // Determinar y asignar los turnos
            $horarioTrabajo->turno1 = $this->determinarTurno($horario['hora_inicio'], $horario['hora_fin']);
            $horarioTrabajo->turno2 = isset($horario['hora_inicio1']) && isset($horario['hora_fin1']) 
                                    ? $this->determinarTurno($horario['hora_inicio1'], $horario['hora_fin1']) 
                                    : null;

            // Guardar el horario en la base de datos
            $horarioTrabajo->save();
        }
    }

    /**
     * Determina el turno (mañana, tarde, corrido) en base a la hora de inicio y fin
     */
    private function determinarTurno($horaInicio, $horaFin)
    {
        // Convertir horas a formato de minutos para comparaciones
        $horaInicioMin = strtotime($horaInicio);
        $horaFinMin = strtotime($horaFin);

        // Definir los rangos en minutos
        $mananaFin = strtotime("12:30");
        $tardeInicio = strtotime("13:00");

        if ($horaInicioMin <= $mananaFin && $horaFinMin <= $mananaFin) {
            return 'mañana'; // Si todo el turno está en la mañana
        } elseif ($horaInicioMin >= $tardeInicio && $horaFinMin > $tardeInicio) {
            return 'tarde'; // Si todo el turno está en la tarde
        } else {
            return 'corrido'; // Si el turno cubre ambas partes del día
        }
    }


    /**
     * Funcion para validar datos
     */
    private function rules()
    {
        return [
            'nombre_fantasia' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'rubros' => 'required|array',
            'rubros.*' => 'exists:rubros,id',
            'horarios' => 'nullable|array',

            // Validación de horarios por cada día de la semana (de 1 a 7)
            
        ];
    }
}
