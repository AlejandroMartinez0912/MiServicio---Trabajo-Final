<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;

    // Define el nombre de la tabla explícitamente
    protected $table = 'calificaciones';


    protected $fillable = [
        'idCita',
        'tipo',
        'calificacion',
        'comentarios',
    ];

    /**
     * Relación con la tabla `citas`.
     */
    // Relación con la cita
    public function cita()
    {
        // Cambié 'cita_id' por 'idCita' ya que esa es la columna que usas para la relación
        return $this->belongsTo(Cita::class, 'idCita', 'idCita');
    }
}
