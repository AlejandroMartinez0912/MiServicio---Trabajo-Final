<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';

    protected $fillable = [
        'user_id',
        'cita_id',
        'total',
        'metodo_pago',
        'fecha_pago',
        'estado',

    ];

    //RELACION CON USUARIO QUE REALIZA EL PAGO 1 USUARIO 1..* FACTURAS
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //relacion con citas 1cita 1 factura
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
}
