<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalificacionCliente extends Model
{
    use HasFactory;

    protected $table = 'calificacion_persona'; // Nombre de la tabla
    protected $fillable = [
        'idCita',
        'idPersona',
        'calificacion',
        'comentarios',
    ];

    /**
     * Relación con la tabla Persona.
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'idPersona');
    }

    /**
     * Relación con la tabla Cita.
     */
    public function cita()
    {
        return $this->belongsTo(Cita::class, 'idCita');
    }
}
