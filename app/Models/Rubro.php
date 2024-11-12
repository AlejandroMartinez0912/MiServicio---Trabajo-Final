<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    use HasFactory;

    /**
     * Datos de rubro
     */
    protected $table = 'rubros';
    protected $fillable = ['nombre']; 

    /**
     * Relación: Muchos rubros pueden pertenecer a muchos datos profesionales.
     */
    public function datosProfesionales()
    {
        return $this->belongsToMany(DatosProfesionales::class, 'datos_rubro', 'rubro_id', 'datos_profesional_id');
    }
}
