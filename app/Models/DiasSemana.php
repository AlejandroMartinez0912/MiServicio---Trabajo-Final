<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasSemana extends Model
{
    use HasFactory;

     // Tabla asociada
     protected $table = 'dias_semana';

     // Definir la relación con la tabla 'horarios_trabajo'
     public function horariosTrabajo()
     {
         return $this->hasMany(HorariosTrabajo::class);
     }
}
