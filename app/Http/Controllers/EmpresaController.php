<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rubro;
use App\Models\DiasSemana;
use App\Models\HorariosEmpresa;

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
        // Validar los datos del formulario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'ubicacion' => 'required|string|max:255',
            'rubros' => 'required|array',
            'rubros.*' => 'exists:rubros,id',
            'horarios' => 'nullable|array',
            // Ajustar la validación para múltiples turnos
            'horarios.*.hora_inicio' => 'nullable|array',
            'horarios.*.hora_fin' => 'nullable|array',
            'horarios.*.hora_inicio.*' => 'nullable|date_format:H:i',
            'horarios.*.hora_fin.*' => 'nullable|date_format:H:i|after:horarios.*.hora_inicio.*',
        ]);

        // Crear la empresa
        $empresa = Empresa::create([
            'nombre' => $request->nombre,
            'slogan' => $request->slogan,
            'ubicacion' => $request->ubicacion,
            'user_id' => Auth::id(),
        ]);

        // Asociar los rubros seleccionados a la empresa
        $empresa->rubros()->attach($request->rubros);

        // Guardar los horarios de atención (si se ingresaron)
        if ($request->has('horarios')) {
            foreach ($request->horarios as $dia => $horario) {
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

        // Redireccionar con mensaje de éxito
        return redirect()->route('gestionar-empresas')->with('success', 'Empresa creada exitosamente.');
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
