<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AgendaAutomaticaController;

class GenerarAgendaDiaria extends Command
{
    // Definir la firma del comando
    protected $signature = 'agenda:generar';

    // Descripción del comando
    protected $description = 'Generar la agenda diaria para todos los profesionales';

    public function __construct()
    {
        parent::__construct();
    }

    // Este método es el que se ejecuta cuando se invoca el comando
    public function handle()
    {
        // Crear una instancia del controlador
        $agendaController = new AgendaAutomaticaController();

        // Llamar a la función generarAgendaDiaria
        $agendaController->generarAgendaDiaria();

        // Mostrar un mensaje en consola después de ejecutar la tarea
        $this->info('Agenda diaria generada con éxito.');
    }
}
