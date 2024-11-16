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
     * Relacion con servicios
     */
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'servicio_rubro', 'rubro_id', 'servicio_id');    }
}
