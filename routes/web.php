<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\DatosProfesionController;
use App\Http\Controllers\GestionServicioController;
use App\Http\Controllers\ServicioController;

use Illuminate\Support\Facades\Route;


// Ruta de página principal llamada Home
Route::view('/', "home")->name('home');

// RUTAS DE LOGIN
Route::view('/privada', "secret")->middleware('auth')->name('privada');

Route::post('/validar-registro', [LoginController::class, 'register'])->name('validar-registro');
Route::post('/inicia-sesion', [LoginController::class, 'login'])->name('inicia-sesion');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// RUTAS DE PERFIL
Route::get('/perfil', [PersonaController::class, 'edit'])->name('perfil')->middleware('auth');
Route::put('/perfil-update', [PersonaController::class, 'update'])->name('perfil-update')->middleware('auth');

// RUTAS DE GESTION DE SERVICIOS
Route::get('/gestion-servicios', [GestionServicioController::class, 'index'])->name('gestion-servicios')->middleware('auth');

// RUTAS DE DATOS PROFESIONALES
Route::post('/gestion-servicios/datos-profesionales', [DatosProfesionController::class, 'guardarDatos'])->name('guardar-datos')->middleware('auth');
Route::put('/gestion-servicios/datos-profesionales/{id}', [DatosProfesionController::class, 'actualizarDatos'])->name('actualizar-datos')->middleware('auth');