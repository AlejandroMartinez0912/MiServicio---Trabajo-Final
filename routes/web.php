<?php

use App\Http\Controllers\AgendaAutomaticaController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\DatosProfesionController;
use App\Http\Controllers\GestionServicioController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\HorarioTrabajoController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\DependencyInjection\RegisterControllerArgumentLocatorsPass;

// Ruta de página principal llamada Home
Route::view('/', "home")->name('home');

//Ruta de iniciar sesion
Route::view('/login', "Auth.Login")->name('login');

//Ruta de register
Route::view('/register', "Auth.Register")->name('register');

// RUTAS DE LOGIN
Route::view('/privada', "homeIn")->middleware('auth')->name('privada');

Route::get('/homein', [HomeController::class, 'index'])->name('homein');

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


//RUTAS PARA HORARIOS
// Ruta para guardar un nuevo horario
Route::post('/horarios', [HorarioTrabajoController::class, 'guardarHorario'])->name('guardar-horario');
// Ruta para actualizar un horario existente
Route::patch('/horarios/actualizar/{id}', [HorarioTrabajoController::class, 'actualizarHorario'])->name('actualizar-horario');
// Ruta para eliminar un horario
Route::delete('/horarios/{id}', [HorarioTrabajoController::class, 'EliminarHorario'])->name('eliminar-horario');
// Ruta para anular un horario
Route::patch('/horarios/anular/{id}', [HorarioTrabajoController::class, 'AnularHorario'])->name('anular-horario');
//Ruta para activar un horario
Route::patch('/horarios/activar/{id}', [HorarioTrabajoController::class, 'ActivarHorario'])->name('activar-horario');


//RUTAS DE SERVICIOS
Route::post('/servicios', [ServicioController::class, 'guardarServicio'])->name('guardar-servicio')->middleware('auth');
Route::put('/servicios/{id}', [ServicioController::class, 'actualizarServicio'])->name('actualizar-servicio')->middleware('auth');
Route::delete('/servicios/{id}', [ServicioController::class, 'eliminarServicio'])->name('eliminar-servicio')->middleware('auth');
Route::put('/servicios/{id}/anular', [ServicioController::class, 'anularServicio'])->name('anular-servicio');
Route::put('/servicios/{id}/activar', [ServicioController::class, 'activarServicio'])->name('activar-servicio');

//RUTAS DE CITAS
Route::get('/cita', [CitaController::class, 'index'])->name('index-cita')->middleware('auth');
Route::get('cita/agendar', [CitaController::class, 'agendarCita'])
    ->name('agendar-cita')
    ->middleware('auth');

Route::post('/citas/guardar', [CitaController::class, 'guardarCita'])->name('guardar-cita')->middleware('auth');

// Ruta para confirmar cita con 
Route::post('/confirmar-cita', [CitaController::class, 'confirmarCita'])->name('confirmar-cita');
Route::post ('/cancelar-cita', [CitaController::class, 'cancelarCita'])->name('cancelar-cita');

//RUTAS PROCESO AUTOMATIZADO - AGENDA AUTOMATICA
Route::get('/confirmar-cita/cliente/{idCita}', [AgendaAutomaticaController::class, 'citaConfirmada'])->name('confirmar-cita-cliente');
Route::get('/confirmada-cita/cliente/{idCita}', [AgendaAutomaticaController::class, 'citaConfirmadaIndex'])->name('cita-confirmada-cliente');