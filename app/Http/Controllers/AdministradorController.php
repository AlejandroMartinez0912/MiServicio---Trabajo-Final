<?php

namespace App\Http\Controllers;

use App\Models\Persona;
use App\Models\User;
use App\Models\DatosProfesion;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\CalificacionProfesion;
use App\Models\Auditoria;
use App\Models\Rubro;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;




class AdministradorController extends Controller
{
    //vista index de administrador
    public function index(){
        return view('Administrador.index');
    }

    //Cargar vistas dentro del index,
    public function usuarios()
    {
        //Pasar usuarios
        $usuarios = User::all();
        $persona = Persona::all();
        $profesiones = DatosProfesion::with('user.persona')->get();
        return view('Administrador.usuarios', compact('usuarios', 'persona', 'profesiones'));
    }
    //Desactivar usuario
    public function desactivarUsuario($id){
        $user = User::find($id);
        $user->estado = 0;
        $user->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 1;
            $auditoria->accion = 'Eliminar';
            $auditoria->modulo = 'Usuarios';
            $auditoria->detalles = 'Estado anterior: ' . $user->estado . ' Estado actual: ' . $user->estado;
            $auditoria->ip = request()->ip();
            $auditoria->save();

        return redirect()->back()->with('success', 'Usuario desactivado');
    }
    //Activar usuario
    public function activarUsuario($id){
        $user = User::find($id);
        $user->estado = 1;
        $user->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 1;
            $auditoria->accion = 'Activar';
            $auditoria->modulo = 'Usuarios';
            $auditoria->detalles = 'Estado anterior: ' . $user->estado . ' Estado actual: ' . $user->estado;
            $auditoria->ip = request()->ip();
            $auditoria->save();
        return redirect()->back()->with('success', 'Usuario activado');
    }

    //Activar y desactivar profesional
    // Desactivar Profesional
    public function desactivarProfesional($idProfesion){
        $profesion = DatosProfesion::find($idProfesion);
        $profesion->estado = 0;
        $profesion->save();

        //desactivar todoas los servicios del profesional
        $servicios = Servicio::where('datos_profesion_id', $idProfesion)->get();
        foreach ($servicios as $servicio) {
            $servicio->estado = 'inactivo';
            $servicio->save();
        }

        $auditoria = new Auditoria();
            $auditoria->user_id = 1;
            $auditoria->accion = 'Desactivar';
            $auditoria->modulo = 'DatoProfesion';
            $auditoria->detalles = 'Profesional desactivado: ' . $profesion->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
        return redirect()->back()->with('success', 'Profesional desactivado');
    }

    // Activar Profesional
    public function activarProfesional($idProfesion){
        $profesion = DatosProfesion::find($idProfesion);
        $profesion->estado = 1;
        $profesion->save();

        //activar todos los servicios del profesional
        $servicios = Servicio::where('datos_profesion_id', $idProfesion)->get();
        foreach ($servicios as $servicio) {
            $servicio->estado = 'activo';
            $servicio->save();
        }

        $auditoria = new Auditoria();
            $auditoria->user_id = 1;
            $auditoria->accion = 'Activar';
            $auditoria->modulo = 'DatoProfesion';
            $auditoria->detalles = 'Profesional activado: ' . $profesion->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
        return redirect()->back()->with('success', 'Profesional activado');
    }

    //Ver perfil de usuario
    
    public function verPerfil($id){
        $user = User::find($id);
        $persona = Persona::where('user_id', $id)->first();
        $citas = Cita::where('idPersona', $id)
        ->with('calificacionesProfesion')
        ->with('calificacionesCliente')
        ->get();
       

        return view('Administrador.usuariosPerfil', compact('user', 'persona', 'citas'));
    }
    //actualizar perfil de usuario
    public function actualizarPerfil(Request $request, $id){
        $user = User::find($id);
        $user->email = $request->input('email');
        $user->save();

        $persona = Persona::where('user_id', $id)->first();
        $persona->nombre = $request->input('nombre');
        $persona->apellido = $request->input('apellido');
        $persona->domicilio = $request->input('domicilio');
        $persona->fecha_nacimiento = $request->input('fecha_nacimiento');
        $persona->documento = $request->input('documento');
        $persona->telefono = $request->input('telefono');
        $persona->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 1;
            $auditoria->accion = 'Actualizar';
            $auditoria->modulo = 'Usuarios';
            $auditoria->detalles = 'Perfil actualizado: ' . $user->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();

        return redirect()->back()->with('success', 'Perfil actualizado');
    }


    //ver perfil de profesional
    public function verPerfilProfesional($idProfesion){
        $profesion = DatosProfesion::find($idProfesion)->with('user.persona')->first();
        $servicios = Servicio::where('datos_profesion_id', $idProfesion)->get();
        $calificacionesProfesion = CalificacionProfesion::where('idProfesion', $idProfesion)->get();
        $citas = Cita::where('idProfesion', $idProfesion)->get();
        return view('Administrador.profesionalesPerfil', compact('profesion', 'servicios', 'calificacionesProfesion', 'citas'));
    }
    


    /**
     * LOGICA DE SERVCIOS
     */

    public function servicios(){
        $servicios = Servicio::with('datosProfesion.user.persona')->get();
        return view('Administrador.servicios', compact('servicios'));
    }

    //Ver servicio en especifico
    public function verServicio($id){
        //Rubros
        $rubros = Rubro::all();

        $servicio = Servicio::with('rubros')->findOrFail($id);

        return view('Administrador.servicioIn', compact('servicio', 'rubros'));
    }
    
    // desactivar servicio
    public function desactivarServicio($id){
        $servicio = Servicio::find($id);
        $servicio->estado = 'inactivo';
        $servicio->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 1;
            $auditoria->accion = 'Desactivar';
            $auditoria->modulo = 'Servicios';
            $auditoria->detalles = 'Servicio desactivado: ' . $servicio->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
        return redirect()->back()->with('success', 'Servicio desactivado');
    }   
    //activar servicio
    public function activarServicio($id){
        $servicio = Servicio::find($id);
        $servicio->estado = 'activo';
        $servicio->save();

        $auditoria = new Auditoria();
            $auditoria->user_id = 1;
            $auditoria->accion = 'Activar';
            $auditoria->modulo = 'Servicios';
            $auditoria->detalles = 'Servicio activado: ' . $servicio->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();

        return redirect()->back()->with('success', 'Servicio activado');
    }

    //actualizar servicio
    public function actualizarServicio(Request $request, $id){

        $servicio = Servicio::findOrFail($id);
      
          // Actualizamos los datos del servicio
          $servicio->update([
              'nombre' => $request->nombre,
              'descripcion' => $request->descripcion,
              'precio_base' => $request->precio_base,
              'duracion_estimada' => $request->duracion_estimada,
          ]);
      
        // Actualizamos los rubros asociados (tabla pivote)
        $servicio->rubros()->sync($request->rubros);


        $auditoria = new Auditoria();
            $auditoria->user_id = 1;
            $auditoria->accion = 'Actualizar';
            $auditoria->modulo = 'Servicios';
            $auditoria->detalles = 'Servicio actualizado: ' . $servicio->id;
            $auditoria->ip = request()->ip();
            $auditoria->save();
    
        return redirect()->back()->with('success', 'Servicio actualizado');
    }

    public function validarServicios(Request $request)
    {
            $nombre = $request->input('nombre');
            $descripcion = $request->input('descripcion');
            $precio_base = $request->input('precio_base');
            $duracion_estimada = $request->input('duracion_estimada');

            // Validar que todos los campos sean obligatorios
            if (!$nombre || !$descripcion || !$precio_base || !$duracion_estimada) {
                return ['status' => false, 'message' => 'Todos los campos son obligatorios.'];
            }

            // Validar que el nombre no sea vacío y no contenga solo números
            if (empty(trim($nombre)) || is_numeric($nombre)) {
                return ['status' => false, 'message' => 'El nombre no puede estar vacío ni contener solo números.'];
            }

            // Validar longitud del nombre
            if (strlen($nombre) > 255) {
                return ['status' => false, 'message' => 'El nombre no puede exceder los 255 caracteres.'];
            }

            // Validar descripción
            if (strlen($descripcion) > 500) {
                return ['status' => false, 'message' => 'La descripción no puede exceder los 500 caracteres.'];
            }

            // Validar que el precio base no sea negativo o cero
            if ($precio_base <= 0) {
                return ['status' => false, 'message' => 'El precio base debe ser mayor que cero.'];
            }

            // Validar duración estimada
            if ($duracion_estimada <= 0) {
                return ['status' => false, 'message' => 'La duración estimada debe ser mayor que cero.'];
            }

            // Si todas las validaciones pasan
            return ['status' => true, 'message' => ''];
    }
 
    public function pagos()
    {
        return view('Administrador.pagos');
    }


    /**
     * LOGICA DE AUDITORIAS
     */

     // AUDITORIAS.BLADE.PHP
     public function auditorias(Request $request)
    {
        // Obtener los filtros del request
        $idAuditoria = $request->input('idAuditoria');
        $userId = $request->input('userId');
        $accion = $request->input('accion');
        $modulo = $request->input('modulo');
        $fechaInicio = $request->input('fechaInicio');
        $fechaFin = $request->input('fechaFin');

        // Consulta con filtros aplicados
        $auditorias = Auditoria::query();

        if ($idAuditoria) {
            $auditorias->where('id', $idAuditoria);
        }

        if ($userId) {
            $auditorias->where('user_id', $userId);
        }

        if ($accion) {
            $auditorias->where('accion', $accion);
        }

        if ($modulo) {
            $auditorias->where('modulo', $modulo);
        }

        if ($fechaInicio && $fechaFin) {
            $auditorias->whereBetween('created_at', [$fechaInicio . ' 00:00:00', $fechaFin . ' 23:59:59']);
        } elseif ($fechaInicio) {
            $auditorias->where('created_at', '>=', $fechaInicio . ' 00:00:00');
        } elseif ($fechaFin) {
            $auditorias->where('created_at', '<=', $fechaFin . ' 23:59:59');
        }

        // Obtener resultados ordenados por fecha
        $auditorias = $auditorias->orderBy('created_at', 'desc')->get();

        // Listado de valores posibles para los filtros
        $acciones = ['Crear', 'Eliminar', 'Actualizar', 'Anular', 'Activar'];
        $modulos = ['Usuarios', 'Citas', 'Servicios', 'Profesión', 'Pagos', 'Empresas', 'Auditorías'];

        return view('Administrador.auditorias', compact('auditorias', 'acciones', 'modulos'));
    }

    public function exportarPDF(Request $request)
    {
        // Aplicar los filtros de la vista
        $query = Auditoria::query();

        if ($request->has('idAuditoria') && $request->idAuditoria) {
            $query->where('id', $request->idAuditoria);
        }
        if ($request->has('userId') && $request->userId) {
            $query->where('user_id', $request->userId);
        }
        if ($request->has('accion') && $request->accion) {
            $query->where('accion', $request->accion);
        }
        if ($request->has('modulo') && $request->modulo) {
            $query->where('modulo', $request->modulo);
        }
        if ($request->has('fechaInicio') && $request->fechaInicio) {
            $query->whereDate('created_at', '>=', $request->fechaInicio);
        }
        if ($request->has('fechaFin') && $request->fechaFin) {
            $query->whereDate('created_at', '<=', $request->fechaFin);
        }

        $auditorias = $query->get();

        // Generar el PDF
        $pdf = Pdf::loadView('Administrador.pdfAuditorias', compact('auditorias'));

        return $pdf->download('auditorias_filtradas.pdf');
    }

    /**
     * ESTADISTICAS
     */

     public function estadisticas(Request $request)
    {
        $informe1 = $this->serviciosPorRubro($request);
        $informe2 = $this->optimizarPrecios();
        $informe3 = $this->mejoresServicios();
        $informe4 = $this->serviciosBajaCalidad();

        // Obtener rubros para el filtro
        $rubros = DB::table('rubros')->pluck('nombre', 'nombre');

        return view('Administrador.estadisticas', compact('informe1', 'informe2', 'informe3', 'informe4', 'rubros'));
    }
    


     //Informe 1
     //servicios por rubros
     public function serviciosPorRubro(Request $request)
     {
         $query = DB::table('servicio_rubro')
             ->join('servicios', 'servicio_rubro.servicio_id', '=', 'servicios.id')
             ->join('citas', 'citas.idServicio', '=', 'servicios.id') // Unir con la tabla `citas`
             ->join('rubros', 'servicio_rubro.rubro_id', '=', 'rubros.id')
             ->select('rubros.nombre as rubro', DB::raw('SUM(servicios.cantidad_reservas) as total_reservas'))
             ->groupBy('rubros.nombre')
             ->orderByDesc('total_reservas');
     
         // Filtros dinámicos
         if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
             $query->whereBetween('citas.fechaCita', [$request->fecha_inicio, $request->fecha_fin]); // Corregido a `citas.fechaCita`
         }
     
         if ($request->filled('rubro')) {
             $query->where('rubros.nombre', $request->rubro);
         }
     
         return $query->get();
     }
    
     public function informe1(Request $request)
     {
         $query = DB::table('servicio_rubro')
             ->join('servicios', 'servicio_rubro.servicio_id', '=', 'servicios.id')
             ->join('citas', 'citas.idServicio', '=', 'servicios.id') // Unir con la tabla `citas`
             ->join('rubros', 'servicio_rubro.rubro_id', '=', 'rubros.id')
             ->select('rubros.nombre as rubro', DB::raw('SUM(servicios.cantidad_reservas) as total_reservas'))
             ->groupBy('rubros.nombre')
             ->orderByDesc('total_reservas');
     
         // Filtros dinámicos
         if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
             $query->whereBetween('citas.fechaCita', [$request->fecha_inicio, $request->fecha_fin]);
         }
     
         if ($request->filled('rubro')) {
             $query->where('rubros.nombre', $request->rubro);
         }
     
         $serviciosPorRubro = $query->get();
     
         // Generar el PDF
         $pdf = PDF::loadView('Administrador.estadisticasPdf.informe1', compact('serviciosPorRubro'));
     
         // Descargar el PDF
         return $pdf->download('informe_servicios_por_rubro.pdf');
     }
     

    //Informe 2
    //Optimizar precios
    public function optimizarPrecios()
    {
        return Servicio::select('id', 'nombre', 'precio_base', 'calificacion', 'cantidad_reservas')
            ->get()
            ->map(function ($servicio) {
                $precioBase = $servicio->precio_base;
                $calificacion = $servicio->calificacion;
                $reservas = $servicio->cantidad_reservas;
                $precioSugerido = $precioBase;

                // Ajuste basado en calificación y demanda
                if ($calificacion >= 4.7 && $reservas > 15) {
                    $precioSugerido *= 1.20; // Aumento del 20%
                } elseif ($calificacion >= 4.5 && $reservas > 10) {
                    $precioSugerido *= 1.15; // Aumento del 15%
                } elseif ($calificacion >= 4.0 && $reservas >= 5 && $reservas <= 10) {
                    $precioSugerido *= 1.05; // Aumento moderado del 5%
                } elseif ($calificacion >= 4.0 && $reservas < 5) {
                    $precioSugerido *= 0.90; // Descuento del 10%
                } elseif ($calificacion < 3.5 && $reservas < 5) {
                    $precioSugerido *= 0.80; // Gran descuento del 20% por baja demanda y mala calificación
                }

                // Asegurar que el precio sugerido no sea menor al 70% ni mayor al 150% del precio base
                $precioSugerido = max($precioBase * 0.70, min($precioSugerido, $precioBase * 1.50));

                $servicio->precio_sugerido = round($precioSugerido, 2); // Redondear a 2 decimales
                return $servicio;
            });
    }

    public function informe2(Request $request)
    {
        // Obtener los servicios optimizados
        $serviciosOptimizado = $this->optimizarPrecios();

        // Generar el PDF
        $pdf = PDF::loadView('Administrador.estadisticasPdf.informe2', compact('serviciosOptimizado'));

        // Descargar el PDF
        return $pdf->download('informe_optimizacion_precios.pdf');
    }


    //Informe 3
    // mejores servicios
    public function mejoresServicios()
    {
        return Servicio::select('id', 'nombre', 'calificacion', 'cantidad_reservas')
            ->where('calificacion', '>=', 4.5)
            ->where('cantidad_reservas', '>=', 5)
            ->orderByDesc('calificacion') // Primero ordena por calificación
            ->orderByDesc('cantidad_reservas') // Luego por reservas
            ->limit(10) // Limita a los 10 mejores servicios
            ->get();
    }
    public function informe3(Request $request)
    {
        // Obtener los servicios destacados (con calificación >= 4 y reservas >= 3)
        $serviciosDestacados = Servicio::select('id', 'nombre', 'calificacion', 'cantidad_reservas')
            ->where('calificacion', '>=', 4)
            ->where('cantidad_reservas', '>=', 3)
            ->orderByDesc('cantidad_reservas')
            ->get();

        // Cargar la vista del informe y pasar los datos
        $pdf = PDF::loadView('Administrador.estadisticasPdf.informe3', compact('serviciosDestacados'));

        // Descargar el PDF
        return $pdf->download('informe_servicios_destacados.pdf');
    }

    //Informe 4
    //servicios baja calidad
    public function serviciosBajaCalidad()
    {
        return Servicio::select('id', 'nombre', 'calificacion', 'cantidad_reservas')
            ->where('calificacion', '<=', 3.0)
            ->where('cantidad_reservas', '<=', 2)
            ->orderBy('calificacion') // Primero ordena por menor calificación
            ->orderBy('cantidad_reservas') // Luego por menor cantidad de reservas
            ->limit(10) // Limita a los 10 peores servicios
            ->get();
    }
    public function informe4(Request $request)
    {
        // Obtener los servicios de baja calidad (con calificación < 3.5 y reservas < 3)
        $serviciosBajaCalidad = Servicio::select('id', 'nombre', 'calificacion', 'cantidad_reservas')
            ->where('calificacion', '<', 3.5)
            ->where('cantidad_reservas', '<', 3)
            ->orderBy('calificacion')
            ->get();

        // Cargar la vista del informe y pasar los datos
        $pdf = PDF::loadView('Administrador.estadisticasPdf.informe4', compact('serviciosBajaCalidad'));

        // Descargar el PDF
        return $pdf->download('informe_servicios_baja_calidad.pdf');
    }

}
