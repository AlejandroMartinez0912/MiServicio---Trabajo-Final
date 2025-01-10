<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MercadoPagoService;
use App\Models\MercadoPagoAccount;
use App\Models\User;
use App\Models\Cita;
use App\Models\DatosProfesion;
use GuzzleHttp\Client;



class PagoAutomaticoController extends Controller
{
    public function index(Request $request)
    {
        $idCita = $request->input('idCita');

        // Verificar que la cita exista
        $cita = Cita::find($idCita);
        if (!$cita) {
            return redirect()->back()->with('error', 'La cita no existe.');
        }

        return view('PagoAutomatico.index', compact('cita'));
    }


    public function mercadoPago(Request $request)
    {
        $idCita = $request->input('idCita');
        $cita = Cita::find($idCita);

        if (!$cita) {
            return redirect()->back()->with('error', 'La cita no existe.');
        }


        // Obtener el token de Mercado Pago del especialista
        $especialista = $cita->datosProfesion->user;
        $mpAccount = $especialista->mercadoPagoAccount;

        if (!$mpAccount || !$mpAccount->access_token) {
            return redirect()->back()->with('error', 'El especialista no tiene configurada su cuenta de Mercado Pago.');
        }

        // Crear la preferencia de pago
        $client = new Client();
        $response = $client->post('https://api.mercadopago.com/checkout/preferences', [
            'headers' => [
                'Authorization' => 'Bearer ' . $mpAccount->access_token,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'items' => [
                    [
                        'title'       => $cita->servicio->nombre,
                        'quantity'    => 1,
                        'unit_price'  => (float) $cita->servicio->precio_base,
                        'currency_id' => 'ARS', // Cambia según tu moneda local
                    ]
                ],
                'payer' => [
                    'name'    => $cita->persona->nombre,
                    'surname' => $cita->persona->apellido,
                    'email'   => $cita->persona->user->email,
                ],
                'back_urls' => [
                    'success' => route('mercado-pago.success',['idCita' => $cita->idCita]),
                    'failure' => route('mercado-pago.failure',['idCita' => $cita->idCita]),
                    'pending' => route('mercado-pago.pending',['idCita' => $cita->idCita]),
                ],
                'auto_return' => 'approved',
            ],
        ]);

        $preference = json_decode($response->getBody()->getContents());

        // Redirigir al enlace de pago
        return redirect($preference->init_point);
    }


    public function success(Request $request)
    {
        // Obtener la información del pago
        $paymentInfo = $request->all();

        //Modificar estado de la cita a pagada
        $cita = Cita::find($paymentInfo['idCita']);
        $cita->estado = 4;
        $cita->save();

        return redirect()->route('index-cita')->with('success', 'Pago realizado con éxito.');
        // Redirigir a la vista 'Cita.gestion' con los datos necesarios
    }


    public function failure(Request $request)
    {
        $paymentInfo = $request->all();
        return redirect()->route('index-cita')->with('error', 'Pago fallido.');
    }

    public function pending(Request $request)
    {
        $paymentInfo = $request->all();
        return redirect()->route('index-cita')->with('warning', 'Pago pendiente.');
    }


}
