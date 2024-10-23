<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiasSemana extends Model
{
    use HasFactory;

    protected $table = 'dias_semana';

    protected $fillable = ['nombre', 'abreviatura', 'orden'];

    // Relación: Un día de la semana puede tener muchos horarios
    public function horarios()
    {
        return $this->hasMany(HorariosEmpresa::class, 'dia_semana_id');
    }
}
