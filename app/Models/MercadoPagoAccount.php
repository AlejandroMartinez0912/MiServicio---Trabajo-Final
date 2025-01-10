<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MercadoPagoAccount extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'mercado_pago_accounts';

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'access_token',
        'refresh_token',
        'token_expires_at',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'token_expires_at' => 'datetime',
    ];

    /**
     * Relación con el modelo User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Verifica si el token ha expirado.
     *
     * @return bool
     */
    public function isTokenExpired(): bool
    {
        return $this->token_expires_at && $this->token_expires_at->isPast();
    }

    /**
     * Actualiza el token de acceso.
     *
     * @param string $accessToken
     * @param string|null $refreshToken
     * @param string|null $expiresAt
     * @return void
     */
    public function updateToken(string $accessToken, ?string $refreshToken = null, ?string $expiresAt = null): void
    {
        $this->access_token = $accessToken;
        if ($refreshToken) {
            $this->refresh_token = $refreshToken;
        }
        if ($expiresAt) {
            $this->token_expires_at = $expiresAt;
        }
        $this->save();
    }
}
