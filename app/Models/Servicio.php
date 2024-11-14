<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = ['nombre', 'precio', 'modalidad', 'duracion', 'descripcion', 'estado', 'datos_profesionales_id'];

    /**
     * Relación con la tabla 'datos_profesionales'
     */
    public function datosProfesionales()
    {
        return $this->belongsTo(DatosProfesion::class, 'datos_profesionales_id');
    }
}
