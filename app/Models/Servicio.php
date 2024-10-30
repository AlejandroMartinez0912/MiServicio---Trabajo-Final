<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $table = 'servicios';

    protected $fillable = ['empresa_id', 'nombre', 'precio', 'duracion', 'modalidad', 'descripcion'];

    /**
     * Relacion con la tabla 'empresas'
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }



}
