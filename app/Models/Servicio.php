<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = ['datos_profesionales_id', 'nombre', 'precio_hora','precio_fijo', '
            duracion', 'modalidad', 'descripcion', 'estado'];

    // Accesor para obtener el presupuesto dependiendo del tipo
        public function getPresupuestoAttribute()
        {
            return $this->precio ?? $this->precio_hora;
        }
    
        // Mutador para asignar presupuesto fijo o por hora
        public function setPresupuestoAttribute($value)
        {
            if ($this->attributes['tipo_presupuesto'] === 'fijo') {
                $this->attributes['precio'] = $value;
                $this->attributes['precio_hora'] = null;
            } else {
                $this->attributes['precio_hora'] = $value;
                $this->attributes['precio'] = null;
            }
        }
    /**
     * Relacion con la tabla 'empresas'
     */
    public function datosProfesionales()
    {
        return $this->belongsTo(DatosProfesionales::class, 'datos_profesionales_id');
    }


}
