<?php

namespace App\Services;

use GuzzleHttp\Client;

class MercadoPagoService
{
    public function createPreference(array $data, string $accessToken)
    {
        $client = new Client([
            'base_uri' => 'https://api.mercadopago.com/',
        ]);

        $response = $client->post('checkout/preferences', [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    }
}
