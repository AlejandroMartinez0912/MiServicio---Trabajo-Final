<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;


//Ruta de pagina princial llamada Home
Route::view('/', "home")->name('home');

//RUTAS DE LAS VISTAS LOGIN
Route::view('/login', "login")->name('login');
Route::view('/registro', "register")->name('registro');
Route::view('/privada', "secret")->middleware('auth')->name('privada');

Route::post('/validar-registro',[LoginController::class, 'register'])->name('validar-registro');
Route::post('/inicia-sesion',[LoginController::class, 'login'])->name('inicia-sesion');
Route::get('/logout',[LoginController::class,'logout'])->name('logout');


