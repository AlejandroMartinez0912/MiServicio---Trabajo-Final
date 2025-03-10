<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'role',
        'estado',
        'verificacion_email',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => 'string',
            'estado' => 'boolean',
        ];
    }
    
    /**
     * Relación de uno a uno con Persona.
     */
    public function persona()
    {
        return $this->hasOne(Persona::class);
    }

    /**
     * Relación de uno a uno con DatosProfesionales.s
     */
    public function datosProfesionales()
    {
        return $this->hasOne(DatosProfesion::class, 'user_id');
    }
    public function mercadoPagoAccount()
    {
        return $this->hasOne(MercadoPagoAccount::class);
    }

    //RELACION CON FACTURAS LUEGO QUE REALIZA EL PAGO.  1 USUARIO 1..* FACTURAS
    public function facturas()
    {
        return $this->hasMany(Factura::class);
    }

}
