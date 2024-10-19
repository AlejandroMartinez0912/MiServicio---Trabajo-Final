<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\EmpresaController;
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
Route::get('/gestionar', [EmpresaController::class, 'gestionar'])->name('gestionar-empresas')->middleware('auth');
// Editar empresa
Route::get('/editar/{id}', [EmpresaController::class, 'edit'])->name('editar-empresa')->middleware('auth');
// Eliminar una empresa
Route::delete('/eliminar-empresa/{id}', [EmpresaController::class, 'destroy'])->name('eliminar-empresa')->middleware('auth');
