<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosProfesion extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención de nombres de Laravel)
    protected $table = 'datos_profesion';

    // Definición de los campos asignables en forma masiva
    protected $fillable = [
        'nombre_fantasia',
        'slogan',
        'ubicacion',
        'telefono',
        'experiencia',
        'calificacion',
        'estado',
        'user_id',
    ];

    /**
     * Relación con el modelo User (usuario que posee los datos de la profesión)
     * Un dato de profesión pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el modelo HorarioTrabajo
     * Un dato de profesión puede tener varios horarios de trabajo
     */
    public function horariosTrabajo()
    {
        return $this->hasMany(HorarioTrabajo::class, 'datos_profesion_id');
    }
    /**
     * Relación con el modelo Dias a través de HorarioTrabajo
     * Un dato de profesión tiene horarios de trabajo en días específicos.
     */
    public function dias()
    {
        return $this->hasManyThrough(Dias::class, HorarioTrabajo::class, 'datos_profesion_id', 'id', 'id', 'dias_id');
    }

    /**
     * Relacion con citas
     */
    public function citas()
    {
        return $this->hasMany(Cita::class, 'idProfesion', 'id');
    }

    //Relacion con servicios - 1profesional puede tener varios servicios
    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'idProfesion', 'id');
    }

    //Relacion con calificacionesProfesion - 1profeisonal puede tener varias calificaciones
    public function calificacionesProfesion()
    {
        return $this->hasMany(CalificacionProfesion::class, 'idProfesion', 'id');
    }

}
