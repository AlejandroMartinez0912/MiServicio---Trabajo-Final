<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresa';
    /**
     * Campos que se pueden llenar en la creación de una empresa
     */
    protected $fillable = ['nombre', 'slogan', 'ubicacion', 'user_id'];
    /**
     * Relación: Una empresa pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /** 
     * Relacion: una empresa puede tener muchos rubros
    */
    public function rubros()
    {
        return $this->belongsToMany(Rubro::class, 'empresa_rubro');
    }
    /**
     * Relacion de empresa con horarios
     */
    // Relación: Una empresa puede tener muchos horarios de trabajo
    public function horarios()
    {
        return $this->hasMany(HorariosEmpresa::class, 'empresa_id');
    }
    /**
     * Relación con la tabla servicios
     */
    public function servicios()
    {
        return $this->hasMany(Servicio::class);
    }
}
