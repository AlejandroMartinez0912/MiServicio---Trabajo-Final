<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionProfesion extends Model
{
    use HasFactory;

    protected $table = 'calificacion_profesion'; // Nombre de la tabla
    protected $fillable = [
        'idCita',
        'idProfesion',
        'idServicio',
        'calificacion',
        'comentarios',
    ];

    /**
     * Relación con la tabla Cita.
     */
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }

    /**
     * Relación con la tabla Servicio.
     */
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idServicio');
    }

    /**
     * Relación con la tabla DatosProfesion.
     */
    public function profesion()
    {
        return $this->belongsTo(DatosProfesion::class, 'idProfesion');
    }
}
