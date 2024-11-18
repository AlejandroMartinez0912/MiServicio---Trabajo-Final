<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';

    protected $fillable = [
        'id',
    ];

    //Relacion con citas
    public function citas()
    {
        return $this->hasMany(Cita::class, 'idCliente');
    }
}
