<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas';
    protected $primaryKey = 'id';
    protected $guarded = [];

    //Relacion con clientes
    public function clientes()
    {
        return $this->belongsTo(Cliente::class, 'idCliente');
    }

    //Relacion con servicios
    public function servicios()
    {
        return $this->hasMany(Servicio::class, 'idCita');
    }
}
