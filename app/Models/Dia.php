<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Modelo Dia
 * 
 * Representa los días de la semana para la configuración de horarios de trabajo.
 * Cada día tiene un nombre, una abreviatura y un número de orden que indica su posición en la semana.
 * 
 * @property int $id
 * @property string $nombre        // Nombre completo del día (ej. "Lunes")
 * @property string $abreviatura   // Abreviatura del día (ej. "Lun")
 * @property int $orden            // Orden del día en la semana (1 para Lunes, 7 para Domingo)
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Dia extends Model
{
    use HasFactory;

    /**
     * Nombre de la tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'dias';

    /**
     * Campos asignables de forma masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',      // Nombre completo del día
        'abreviatura', // Abreviatura del día
        'orden',       // Orden del día en la semana (1 a 7)
    ];

    /**
     * Relación con el modelo HorarioTrabajo.
     * Un día puede tener múltiples horarios de trabajo asociados.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horariosTrabajo()
    {
        return $this->hasMany(HorarioTrabajo::class, 'dias_id');
    }
}
