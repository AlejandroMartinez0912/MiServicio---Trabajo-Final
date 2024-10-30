<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\GestionEmpresaController;
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

// Rutas de creación y almacenamiento de servicios
Route::get('/empresa/{empresaId}/servicio/crear', [GestionEmpresaController::class, 'createService'])->name('crear-servicio')->middleware('auth');
Route::post('/empresa/{empresaId}/servicio/guardar', [GestionEmpresaController::class, 'storeService'])->name('guardar-servicio')->middleware('auth');

//Rutas para ver y editar datos de la empresa
Route::get('/empresa/{id}/editar', [EmpresaController::class, 'editar'])->name('editar-empresa');
Route::put('/empresa/{id}', [EmpresaController::class, 'actualizar'])->name('actualizar-empresa');
