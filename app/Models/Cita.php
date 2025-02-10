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
        'idPersona',
        'idServicio',
        'idProfesion',
        'estado',
        'fechaCita',
        'horaInicio',
        'horaFin',
        'calificacion_profesion',
        'calificacion_cliente',
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

    // Relación con CalificacionesCliente - relacion 1 a 1 con citas
    public function calificacionesCliente()
    {
        return $this->hasOne(CalificacionCliente::class, 'idCita', 'idCita');
    }

    //Relacion con CalificacionesProfesion - relacion 1 a 1 con citas
    public function calificacionesProfesion()
    {
        return $this->hasOne(CalificacionProfesion::class, 'idCita', 'idCita');
    }

    //Relacion 1cita a 1 factura
    public function factura()
    {
        return $this->hasOne(Factura::class, 'idCita', 'idCita');
    }

}
