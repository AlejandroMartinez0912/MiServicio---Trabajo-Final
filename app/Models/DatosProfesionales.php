<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosProfesionales extends Model
{
    use HasFactory;

    protected $table = 'datos_profesionales';
    /**
     * Campos que se pueden llenar en la creación de una empresa
     */
    protected $fillable = ['nombre_fantasia', 'slogan', 'ubicacion','estado' ,'user_id'];
   
    /**
     * Relación: Una empresa pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación: Muchos datos profesionales pueden tener muchos rubros.
     */
    public function rubros()
    {
        return $this->belongsToMany(Rubro::class, 'datos_rubro', 'datos_profesional_id', 'rubro_id');
    }
    
    /**
     *  Relación con los horarios de trabajo
     */
    public function horariosTrabajo()
     {
         return $this->hasMany(HorariosTrabajo::class);
     }

     /**
      * Relación con los servicios    
      */
      public function servicios()
      {
          return $this->hasMany(Servicio::class);
      }
}
