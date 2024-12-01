<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\EnviarRecordatorio;
use App\Console\Commands\GenerarAgendaDiaria;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // Aquí puedes programar tus comandos
        $schedule->command('recordatorio:enviar')->daily(); // Programar para que se ejecute diariamente
        $schedule->command('agenda:generar')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');  // Cargar la carpeta Commands

        $this->command(GenerarAgendaDiaria::class); // Registrar el nuevo comando
        $this->command(EnviarRecordatorio::class);

        // Registrar los comandos personalizados
        require base_path('routes/console.php');  // Incluir las rutas de consola
    }
}
