<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio_base',
        'duracion_estimada',
        'estado',
        'calificacion',
        'cantidad_reservas',
        'tags',
        'datos_profesion_id',
    ];
    /**
     * Relacion con datos_profesion
     */
    public function datosProfesion()
    {
        return $this->belongsTo(DatosProfesion::class, 'datos_profesion_id');
    }

    /**
     * Relacion con servicio_rubro
     */
    public function rubros()
    {
        return $this->belongsToMany(Rubro::class, 'servicio_rubro', 'servicio_id', 'rubro_id');
    }

    /**
     * Relacion con citas
     */
    public function citas()
    {
        return $this->hasMany(Cita::class, 'idServicio', 'id');
    }

    //Relacion con calificaciones - 1 servicio puede tener varias calificaciones
    public function calificaciones()
    {
        return $this->hasMany(CalificacionProfesion::class, 'idServicio', 'id');
    }


  
}
