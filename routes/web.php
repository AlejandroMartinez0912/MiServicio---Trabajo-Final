<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\GestionEmpresaController;
use App\Http\Controllers\ServicioController;
use Illuminate\Support\Facades\Route;


// Ruta de página principal llamada Home
Route::view('/', "home")->name('home');

// RUTAS DE LOGIN
Route::view('/login', "Login/login")->name('login');
Route::view('/registro', "Login/register")->name('registro');
Route::view('/privada', "secret")->middleware('auth')->name('privada');

Route::post('/validar-registro', [LoginController::class, 'register'])->name('validar-registro');
Route::post('/inicia-sesion', [LoginController::class, 'login'])->name('inicia-sesion');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// RUTAS DE PERFIL
Route::get('/perfil', [PersonaController::class, 'edit'])->name('perfil')->middleware('auth');
Route::put('/perfil-update', [PersonaController::class, 'update'])->name('perfil-update')->middleware('auth');

// RUTAS DE EMPRESA
// Crear y guardar empresa
Route::get('/empresa/crear', [EmpresaController::class, 'create'])->name('crear-empresa')->middleware('auth');
Route::post('/empresa/guardar', [EmpresaController::class, 'store'])->name('guardar-empresa')->middleware('auth');
// Gestión de empresas
Route::get('/empresa/gestionar', [EmpresaController::class, 'gestionar'])->name('gestionar-empresas')->middleware('auth');
// Eliminar una empresa
Route::delete('/empresa/eliminar/{id}', [EmpresaController::class, 'destroy'])->name('eliminar-empresa')->middleware('auth');


// Ruta de gestion de empresa
Route::get('/empresa/gestion/{id}', [GestionEmpresaController::class, 'index'])->name('gestion-empresa')->middleware('auth');

// RUTAS DE SERVICIOS
Route::middleware('auth')->group(function () {
    Route::get('/empresa/gestion/{empresaId}/servicio/crear', [ServicioController::class, 'createService'])->name('crear-servicio');
    Route::post('/empresa/gestion/{empresaId}/servicio/guardar', [ServicioController::class, 'storeService'])->name('guardar-servicio');
    
    Route::get('/empresa/gestion/{empresaId}/servicio/{servicioId}/editar', [ServicioController::class, 'editService'])->name('editar-servicio');
    Route::put('/empresa/gestion/{empresaId}/servicio/{servicioId}', [ServicioController::class, 'updateService'])->name('actualizar-servicio');
    Route::delete('/empresa/{empresaId}/servicio/{servicioId}', [ServicioController::class, 'deleteService'])->name('eliminar-servicio');
});



//Rutas para ver y editar datos de la empresa
Route::get('/empresa/{id}/editar', [EmpresaController::class, 'editar'])->name('editar-empresa');
Route::put('/empresa/{id}', [EmpresaController::class, 'actualizar'])->name('actualizar-empresa');
