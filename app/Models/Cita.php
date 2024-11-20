<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    // Especifica la tabla asociada
    protected $table = 'citas';

    // Especifica la llave primaria
    protected $primaryKey = 'idCita';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'estadoCita',
        'fechaCita',
        'horaCita',
        'comentariosCliente',
        'calificacion',
        'idPersona',
        'idServicio',
        'idProfesion',
    ];

    // Relación con la tabla 'personas'
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'idPersona', 'id');
    }

    // Relación con la tabla 'servicios'
    public function servicio()
    {
        return $this->belongsTo(Servicio::class, 'idServicio', 'id');
    }

    //Relacion con la tabla datos_profesion
    public function datosProfesion()
    {
        return $this->belongsTo(DatosProfesion::class, 'idProfesion', 'id');
    }
}
