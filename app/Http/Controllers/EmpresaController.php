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
        $request->validate($this->rules());

        try{
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
        $this->guardarHorarios($empresa, $request->horarios);

        
        // Redireccionar con mensaje de éxito
        return redirect()->route('gestionar-empresas')->with('success', 'Empresa creada exitosamente.');
        } catch (\Exception $e) {
            // Mensaje de error
            return redirect()->back()->with('error', 'Hubo un problema al crear la empresa.');
        }
    }

    /**
     * Guardar horarios de atención de la empresa.
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

    // Mostrar la lista de empresas creadas por el usuario
    public function gestionar()
    {
        $empresas = Empresa::where('user_id', Auth::id())->get();
        return view('Empresa.gestionar', compact('empresas'));
    }

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


    // Eliminar una empresa
    public function destroy($id)
    {
        $empresa = Empresa::where('user_id', Auth::id())->findOrFail($id);
        $empresa->delete();

        return redirect()->route('gestionar-empresas')->with('success', 'Empresa eliminada exitosamente');
    }
}
