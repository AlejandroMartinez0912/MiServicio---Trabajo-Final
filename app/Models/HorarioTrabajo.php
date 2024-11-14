<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioTrabajo extends Model
{
    use HasFactory;

    // Nombre de la tabla (opcional si sigue la convención de nombres de Laravel)
    protected $table = 'horarios_trabajo';

    // Definición de los campos asignables en forma masiva
    protected $fillable = [
        'datos_profesion_id',
        'dias_id',
        'hora_inicio',
        'hora_fin',
        'hora_inicio1',
        'hora_fin1',
        'turno1',
        'turno2',
        'estado'
    ];

      // Relaciones
      public function datosProfesion()
      {
          return $this->belongsTo(DatosProfesion::class, 'datos_profesion_id');
      }
  
      public function dia()
      {
          return $this->belongsTo(Dias::class, 'dia_id');
      }
}
