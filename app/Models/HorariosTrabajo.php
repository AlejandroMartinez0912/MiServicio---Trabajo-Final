<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorariosTrabajo extends Model
{
   use HasFactory;
   // Tabla asociada
   protected $table = 'horarios_trabajo';

   // Definir la relación con 'datos_profesionales'
   public function datosProfesionales()
   {
       return $this->belongsTo(DatosProfesionales::class);
   }

   // Definir la relación con 'dia_semana'
   public function diaSemana()
   {
       return $this->belongsTo(DiasSemana::class);
   }
}
