<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo HorarioTrabajo
 * 
 * Representa los horarios de trabajo asociados a los datos profesionales de un usuario.
 * Cada horario está vinculado a un día específico y puede tener hasta dos turnos de trabajo por día.
 * 
 * @property int $id
 * @property int $datos_profesion_id
 * @property int $dias_id
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property string|null $hora_inicio1
 * @property string|null $hora_fin1
 * @property string $turno1
 * @property string|null $turno2
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class HorarioTrabajo extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'horarios_trabajo';

    /**
     * Campos asignables de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'datos_profesion_id', // ID de la profesión a la que pertenece este horario
        'dias_id',            // ID del día de la semana correspondiente
        'hora_inicio',        // Hora de inicio del primer turno de trabajo
        'hora_fin',           // Hora de finalización del primer turno de trabajo
        'hora_inicio1',       // Hora de inicio del segundo turno de trabajo (opcional)
        'hora_fin1',          // Hora de finalización del segundo turno de trabajo (opcional)
        'turno1',             // Turno del primer horario ('mañana', 'tarde', 'corrido')
        'turno2',             // Turno del segundo horario, si aplica ('mañana', 'tarde', 'corrido')
    ];

    /**
     * Relación con el modelo DatosProfesion.
     * Un horario de trabajo pertenece a un registro de datos de profesión.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function datosProfesion()
    {
        return $this->belongsTo(DatosProfesion::class, 'datos_profesion_id');
    }

    /**
     * Relación con el modelo Dia.
     * Un horario de trabajo está asociado a un día específico de la semana.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dia()
    {
        return $this->belongsTo(Dia::class, 'dias_id');
    }
}
