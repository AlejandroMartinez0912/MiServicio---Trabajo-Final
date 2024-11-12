<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\DatosProfesionalesController;
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

// RUTAS DE SERVICIOS
Route::get('/gestion-servicios', [ServicioController::class, 'index'])->name('gestion-servicios')->middleware('auth');

// RUTAS DE SERVICIOS
Route::middleware('auth')->group(function () {
    Route::get('/gestion/servicios/crear', [ServicioController::class, 'crearServicio'])->name('crear-servicio');
    Route::post('/gestion/servicios/guardar', [ServicioController::class, 'guardarServicio'])->name('guardar-servicio');
    
    Route::get('/gestion/servicios/{servicioId}/editar', [ServicioController::class, 'editarServicio'])->name('editar-servicio');
    Route::put('/gestion/servicios/{servicioId}', [ServicioController::class, 'actualizarServicio'])->name('actualizar-servicio');
    Route::delete('/gestion/servicio/{servicioId}', [ServicioController::class, 'eliminarServicio'])->name('eliminar-servicio');
});

//RUTA DE DATOS PROFESIONALES
Route::post('gestion-servicios/datos-profesionales', [DatosProfesionalesController::class, 'store'])->name('guardar-datos')->middleware('auth');