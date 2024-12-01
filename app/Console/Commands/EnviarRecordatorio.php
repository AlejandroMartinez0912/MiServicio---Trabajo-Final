<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\AgendaAutomaticaController;

class EnviarRecordatorio extends Command
{
    protected $signature = 'recordatorio:enviar'; // Comando que usaremos para ejecutar la tarea
    protected $description = 'Enviar recordatorios de citas programadas para mañana';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Crear una instancia del controlador
        $agendaController = new AgendaAutomaticaController();
        
        // Llamar al método que ejecutará la tarea
        $agendaController->enviarRecordatorio();
        
        // Mostrar un mensaje en consola después de ejecutar la tarea
        $this->info('Recordatorios enviados con éxito.');
    }
}
