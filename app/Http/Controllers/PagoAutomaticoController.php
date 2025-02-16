<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MercadoPagoService;
use App\Models\MercadoPagoAccount;
use App\Models\User;
use App\Models\Cita;
use App\Models\DatosProfesion;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\Factura;
use App\Models\Persona;
use App\Mail\FacturaPago;
use MercadoPago\SDK;
use Illuminate\Support\Facades\DB;
use App\Models\Auditoria;

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

        //insertar en facturas
        $factura = new Factura();
        $idPersona = $cita->idPersona;
        $persona = Persona::find($idPersona);
        $idUser = $persona->user_id;
        $factura->user_id = $idUser;
        $factura->idCita = $cita->idCita;
        $total = $cita->servicio->precio_base;
        $factura->total = $total;
        $factura->metodo_pago = 'Mercado Pago';
        $factura->fecha_pago = now();
        $factura->save();

        //Enviar mail con factura de pago
        Mail::to($cita->persona->user->email)->send(new FacturaPago($factura, $persona, $cita));

        //Add Auditoria
        $auditoria = new Auditoria();
        $auditoria->user_id = Auth::user()->id;
        $auditoria->accion = 'Pago';
        $auditoria->modulo = 'Cita';
        $auditoria->detalles = 'Pago realizado de la cita: ' . $cita->idCita .' por el cliente: ' . $cita->persona->user->email . ' con el servicio: ' . $cita->servicio->nombre . ' al especialista: ' . $cita->datosProfesion->nombre_fantasia;
        $auditoria->ip = request()->ip();
        $auditoria->save();

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

    /**
     * LOGICA PARA GESTIONAR CUENTA DE MERCADO PAGO
     */

     public function vincularMercadoPago(Request $request)
     {
         // Obtener el especialista logueado
         $especialista = Auth::user();
     
         // Crear el enlace de autorización de Mercado Pago
         $clientId = env('MERCADO_PAGO_CLIENT_ID');
         $redirectUri = route('mercado-pago-callback');
     
         $url = "https://auth.mercadopago.com.ar/authorization?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}";
     
         return redirect($url); // Redirige al especialista a la página de autorización

         
     }

     public function mercadoPagoCallback(Request $request)
    {
        // Verificar que el 'code' esté presente en la respuesta de Mercado Pago
        if (!$request->has('code')) {
            return redirect()->route('gestion-servicios')->with('error', 'Falta el código de autorización.');
        }

        // Obtener el 'code' enviado por Mercado Pago
        $code = $request->input('code');

        // Obtener el 'client_id' y 'client_secret' de las variables de entorno
        $clientId = env('MERCADO_PAGO_CLIENT_ID');
        $clientSecret = env('MERCADO_PAGO_CLIENT_SECRET');
        $redirectUri = route('mercado-pago.callback'); // El mismo URI de redirección usado en el enlace de autorización

        // Solicitar el 'access_token' de Mercado Pago utilizando el 'code' recibido
        $response = Http::asForm()->post('https://api.mercadopago.com/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $code,
            'redirect_uri' => $redirectUri,
        ]);

        $accessToken = $response->json()['access_token'] ?? null;

        if (!$accessToken) {
            return redirect()->route('gestion-servicios')->with('error', 'No se pudo obtener el Access Token.');
        }

        // Guardar el access_token en la base de datos
        $especialista = Auth::user();
        $mpAccount = $especialista->mercadoPagoAccount;

        if ($mpAccount) {
            // Si ya existe una cuenta de Mercado Pago, actualizar el access_token
            $mpAccount->update(['access_token' => $accessToken]);
        } else {
            // Si no existe una cuenta de Mercado Pago, crearla
            $mpAccount = new MercadoPagoAccount();
            $mpAccount->user_id = $especialista->id;
            $mpAccount->access_token = $accessToken;
            $mpAccount->save();
        }

        return redirect()->route('gestion-servicios')->with('success', 'Cuenta de Mercado Pago vinculada con éxito.');
    }

     
   






}
