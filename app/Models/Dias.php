<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dias extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención de nombres de Laravel)
    protected $table = 'dias';

    // Definición de los campos asignables en forma masiva
    protected $fillable = [
        'nombre',
        'abreviatura',
        'orden'
    ];

    /**
     * Relación con el modelo HorarioTrabajo
     * Un día puede estar relacionado con varios horarios de trabajo.
     */
    public function horariosTrabajo()
    {
        return $this->hasMany(HorarioTrabajo::class, 'dias_id');
    }
}
