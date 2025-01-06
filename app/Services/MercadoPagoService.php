<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;

class MercadoPagoService
{
    public static function configure()
    {
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
    }
}
