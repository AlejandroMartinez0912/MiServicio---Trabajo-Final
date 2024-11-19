<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $table = "persona";

    protected $fillable = [
        'nombre',
        'apellido',
        'domicilio',
        'fecha_nacimiento',
        'documento',
        'telefono',
        'user_id',
        'foto',
        'estado_profesional',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    //relacion con citas
    public function citas()
    {
        return $this->hasMany(Cita::class, 'idPersona', 'id');
    }

}
