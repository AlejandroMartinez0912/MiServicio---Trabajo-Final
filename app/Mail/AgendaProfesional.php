<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AgendaProfesional extends Mailable
{
    use Queueable, SerializesModels;

    // Variable para almacenar las citas del día
    public $citasDelDia;

    /**
     * Crear una nueva instancia de mensaje.
     *
     * @param $citasDelDia
     * @return void
     */
    public function __construct($citasDelDia)
    {
        // Asignar las citas recibidas a la propiedad de la clase
        $this->citasDelDia = $citasDelDia;
    }

    /**
     * Construir el mensaje de correo.
     *
     * @return $this
     */
    public function build()
    {
        // Definir el asunto y la vista que se utilizará para el correo
        return $this->subject('Agenda del día de hoy')
                    ->view('emails.agendaProfesional')  // Usamos la vista 'emails.agendaProfesional' (que debes crear)
                    ->with([
                        'citas' => $this->citasDelDia,  // Pasar las citas al correo
                    ]);
    }
    }
