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
use App\Http\Controllers\PagoAutomaticoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CajaController;
use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\AdministradorController;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\InformesController;


// Ruta de página principal llamada Home
Route::view('/', "Home.home")->name('home');

//Ruta de iniciar sesion
Route::view('/login', "Auth.Login")->name('login');

//Ruta de register
Route::view('/register', "Auth.Register")->name('register');

// RUTAS DE LOGIN
Route::view('/privada', "homeIn")->middleware('auth')->name('privada');

Route::get('/homein', [HomeController::class, 'index'])->name('homein');

//Ruta de busquedas
Route::get('/search', [HomeController::class, 'search'])->name('search');


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
Route::post('/servicios/{id}/activar', [ServicioController::class, 'activarServicio'])->name('activar-servicio');

//RUTAS DE CITAS
Route::get('/cita', [CitaController::class, 'index'])->name('index-cita')->middleware('auth');
Route::get('cita/agendar/{idServicio}', [CitaController::class, 'agendarCita'])
    ->name('agendar-cita')
    ->middleware('auth');


Route::post('/citas/guardar', [CitaController::class, 'guardarCita'])->name('guardar-cita')->middleware('auth');

Route::put('/citas/{id}', [CitaController::class, 'actualizarCita'])->name('actualizar-cita');

Route::post('/cancelar-cita', [CitaController::class, 'cancelarCita'])->name('cancelar-cita');



// Ruta para confirmar cita con 
Route::post('/confirmar-cita', [CitaController::class, 'confirmarCita'])->name('confirmar-cita');
Route::post ('/cancelar-cita', [CitaController::class, 'cancelarCita'])->name('cancelar-cita');

//RUTAS PROCESO AUTOMATIZADO - AGENDA AUTOMATICA
Route::get('/confirmar-cita/cliente/{idCita}', [AgendaAutomaticaController::class, 'citaConfirmada'])->name('confirmar-cita-cliente');
Route::get('/confirmada-cita/cliente/{idCita}', [AgendaAutomaticaController::class, 'citaConfirmadaIndex'])->name('cita-confirmada-cliente');

//RUTAS PROCESO AUTOMATICO - PAGAR CITA
Route::get('/ver-pago', [PagoAutomaticoController::class, 'index'])->name('ver-pago');

Route::get('/mercado-pago', [PagoAutomaticoController::class, 'mercadoPago'])->name('mercado-pago');
Route::get('/mercado-pago/success', [PagoAutomaticoController::class, 'success'])->name('mercado-pago.success');
Route::get('/mercado-pago/failure', [PagoAutomaticoController::class, 'failure'])->name('mercado-pago.failure');
Route::get('/mercado-pago/pending', [PagoAutomaticoController::class, 'pending'])->name('mercado-pago.pending');


//VINCULAR MERCADO PAGO
Route::get('mercado-pago/vincular', [PagoAutomaticoController::class, 'vincularMercadoPago'])->name('mercado-pago-vincular');
Route::get('mercado-pago/callback', [PagoAutomaticoController::class, 'mercadoPagoCallback'])->name('mercado-pago-callback');

//RUTAS PARA CALIFICAR.
//RUTAS CALIFICAR PROFESION
Route::get('/calificaciones/pendientes', [CalificacionController::class, 'VerCalificacionesPendientes']);
Route::post('/calificaciones/{id}/guardar', [CalificacionController::class, 'GuardarCalificacionProfesion'])->name('calificaciones.guardar');

//RUTAS CALIFICAR CLIENTE
Route::post('/calificaciones-cliente/{id}/guardar', [CalificacionController::class, 'GuardarCalificacionCliente'])->name('calificaciones-cliente.guardar');


//RUTAS PARA ADMINISTRADOR
Route::get('/admin', [AdministradorController::class, 'index'])->name('index-admin');

//Rutas de usuarios
Route::get('/admin/usuarios', [AdministradorController::class, 'usuarios'])->name('admin-usuarios');
// Rutas para activar y desactivar usuarios
Route::post('/usuarios/{id}/activar', [AdministradorController::class, 'activarUsuario'])->name('usuarios-activar');
Route::patch('/usuarios/{id}/desactivar', [AdministradorController::class, 'desactivarUsuario'])->name('usuarios-desactivar');
//Rutas de profesionales activar y desactivar
Route::patch('/desactivar-profesional/{id}', [AdministradorController::class, 'desactivarProfesional'])->name('desactivar-Profesional');
Route::post('/profesional/{idProfesion}/activar', [AdministradorController::class, 'activarProfesional'])->name('activar-Profesional');

//ver perfil usuario cliente. 
Route::get('/admin/perfil/{id}', [AdministradorController::class, 'verPerfil'])->name('admin-ver-perfil');
Route::get ('/admin/perfil-profesional/{idProfesion}', [AdministradorController::class, 'verPerfilProfesional'])->name('admin-ver-perfil-profesion');

//ACTUALIZAR PERFIL
Route::post('/actualizar-perfil/{id}', [AdministradorController::class, 'actualizarPerfil'])->name('admin-actualizar-perfil');
//Activar y desactivar servicios
Route::post('/desactivar-servicio/{id}', [AdministradorController::class, 'desactivarServicio'])->name('desactivar-servicio');
Route::post('/servicio/{id}/activar', [AdministradorController::class, 'activarServicio'])->name('activar-servicio');

//ACTUALIZAR SERVICIO ADMIN
Route::put('/admin/servicios/{id}', [AdministradorController::class, 'actualizarServicio'])->name('admin-actualizar-servicio');


Route::get('/admin/servicios', [AdministradorController::class, 'servicios'])->name('admin-servicios');
Route::get('/admin/servicio/{id}', [AdministradorController::class, 'verServicio'])->name('admin-ver-servicio');
Route::get('/admin/pagos', [AdministradorController::class, 'pagos'])->name('admin-pagos');

//rutas de auditorias
Route::get('/auditorias', [AdministradorController::class, 'auditorias'])->name('admin-auditoria');

Route::get('/admin/auditorias/exportar-pdf', [AdministradorController::class, 'exportarPDF'])
    ->name('exportar-auditoria-pdf');

//Rutas estadisticas
Route::get('/admin/estadisticas', [AdministradorController::class, 'estadisticas'])->name('admin-estadisticas');
Route::get('/exportar-excel', [AdministradorController::class, 'exportarExcel'])->name('exportar-excel');
Route::get('/reportes/optimizar-precios', [AdministradorController::class, 'optimizarPrecios'])->name('reportes.optimizar-precios');
Route::get('/reportes/mejores-servicios', [AdministradorController::class, 'mejoresServicios'])->name('reportes.mejores-servicios');
Route::get('/estadisticas', [AdministradorController::class, 'estadisticas'])->name('estadisticas');


Route::get('/informe1/pdf', [AdministradorController::class, 'informe1'])->name('informe1-pdf');
Route::get('/informe2/pdf', [AdministradorController::class, 'informe2'])->name('informe2-pdf');
Route::get('/informe3/pdf', [AdministradorController::class, 'informe3'])->name('informe3-pdf');
Route::get('/informe4/pdf', [AdministradorController::class, 'informe4'])->name('informe4-pdf');

/**
 * RUTAS INFORMES
 */
Route::get('/informes', [InformesController::class, 'index'])->name('informes');
Route::get('informes/exportar-pdf', [InformesController::class, 'exportarPDF'])->name('informes.exportar-pdf');
Route::get('/exportar-pdf', [InformesController::class, 'exportarPDF'])->name('exportar.pdf');
Route::get('/informes/exportar-excel', [InformesController::class, 'exportarExcel'])->name('informes.exportar-excel');

