<?php

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// php artisan schedule:run

// \Illuminate\Support\Facades\Schedule::command('agenda:generar')->everyMinute();

// \Illuminate\Support\Facades\Schedule::command('recordatorio:enviar')->everyMinute();  


\Illuminate\Support\Facades\Schedule::call(function () {
    $hora_actual = now()->format('H:i');
    if ($hora_actual === '04:00') {
        Artisan::call('agenda:generar');
    }
})->everyMinute();

\Illuminate\Support\Facades\Schedule::call(function () {
    $hora_actual = now()->format('H:i');
    if ($hora_actual === '08:00') {
        Artisan::call('recordatorio:enviar');
    }
})->everyMinute(); 

/**
\Illuminate\Support\Facades\Schedule::call(function () {
    $hora_actual = now()->format('H:i');
    Artisan::call('agenda:generar'); 
    
})->everyMinute();   
\Illuminate\Support\Facades\Schedule::call(function () {
    $hora_actual = now()->format('H:i');
    Artisan::call('recordatorio:enviar');
    
})->everyMinute();   */
