<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorariosEmpresa extends Model
{
    use HasFactory;

    protected $table = 'horarios_empresa';

    protected $fillable = ['empresa_id', 'dia_semana_id', 'hora_inicio', 'hora_fin', 'turno'];

    // Relación: Un horario pertenece a una empresa
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    // Relación: Un horario pertenece a un día de la semana
    public function diaSemana()
    {
        return $this->belongsTo(DiasSemana::class, 'dia_semana_id');
    }
}
