<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FacturaPago extends Mailable
{
    use Queueable, SerializesModels;

    public $factura;
    public $persona;
    public $cita;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($factura, $persona, $cita)
    {
        $this->factura = $factura;
        $this->persona = $persona;
        $this->cita = $cita;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.factura')
                    ->subject('Factura de pago - MiServicio')
                    ->with([
                        'factura' => $this->factura,
                        'persona' => $this->persona,
                        'cita' => $this->cita
                    ]);
    }
}
