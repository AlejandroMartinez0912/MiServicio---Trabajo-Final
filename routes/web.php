<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


//Ruta de pagina princial llamada Home
Route::get('/', [HomeController::class, 'index']);

