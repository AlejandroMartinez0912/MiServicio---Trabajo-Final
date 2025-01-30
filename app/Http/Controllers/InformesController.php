<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\CalificacionProfesion;
use App\Models\DatosProfesion;
use App\Models\User;
use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use FPDF;


class InformesController extends Controller
{
    //mostrar informes
    public function index(Request $request) 
    {
        $userId = Auth::id();
        $persona = Persona::where('user_id', $userId)->first();
        
        // Obtener la profesión del usuario
        $profesion = DatosProfesion::where('user_id', $userId)->first();
        if (!$profesion) {
            return back()->with('error', 'Esta sección es exclusiva para profesionales.');
        }
        // Cargar los servicios disponibles según la profesión del usuario
        $idProfesion = $profesion->id;
        $servicios = Servicio::where('datos_profesion_id', $idProfesion)->get();
        
        // Inicializar la consulta de citas
        $query = Cita::where('idProfesion', $profesion->id)
            ->with('calificacionesProfesion')
            ->with('calificacionesCliente');
        
        // Filtro por idServicio
        if ($request->has('idServicio') && $request->idServicio != '') {
            $query->where('idServicio', $request->idServicio);
        }
        
       // Filtro por estado
        if ($request->has('estado') && $request->estado != '') {
            $estadoMap = [
                'Pendiente' => 0,
                'Confirmada' => 1,
                'Cancelada' => 2,
                'Re-confirmada' => 3,
                'Pagada' => 4,
            ];
            
            // Filtramos por el estado numérico correspondiente
            $estado = $request->estado;
            if (isset($estadoMap[$estado])) {
                $query->where('estado', $estadoMap[$estado]);
            }
        }
    
        // Filtro por calificación de la profesión
        if ($request->has('calificacion') && $request->calificacion != '') {
            $query->whereHas('calificacionesProfesion', function ($q) use ($request) {
                $q->where('calificacion', '>=', $request->calificacion);
            });
        }
        
        // Filtro por fecha
        if ($request->has('fechaCita') && $request->fechaCita != '') {
            $query->whereDate('fechaCita', $request->fechaCita);
        }

        
        
        // Obtener las citas filtradas
        $citas = $query->get();
        
        return view('Informes.informes', compact('citas', 'servicios', 'persona'));
    }
   
    public function exportarExcel(Request $request)
    {
        // Filtrar las citas con los mismos parámetros que en la vista
        $citas = Cita::query();

        // Filtros que el usuario ha seleccionado
        if ($request->has('estado') && $request->estado != '') {
            $estadoMap = [
                'Pendiente' => 0,
                'Confirmada' => 1,
                'Cancelada' => 2,
                'Re-confirmada' => 3,
                'Pagada' => 4,
            ];
            $estado = $request->estado;
            if (isset($estadoMap[$estado])) {
                $citas->where('estado', $estadoMap[$estado]);
            }
        }

        // Otros filtros: servicio, fecha, calificación...
        if ($request->has('idServicio') && $request->idServicio != '') {
            $citas->where('servicio_id', $request->idServicio);
        }
        if ($request->has('fechaCita') && $request->fechaCita != '') {
            $citas->whereDate('fechaCita', $request->fechaCita);
        }
        if ($request->has('calificacion') && $request->calificacion != '') {
            $citas->where('calificacion', '>=', $request->calificacion);
        }

        // Obtener las citas filtradas
        $citas = $citas->get();

        // Crear el archivo Excel
        $filename = 'informes_citas.xls';
        $handle = fopen('php://output', 'w');

        // Definir las cabeceras del archivo
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Escribir los encabezados de columna
        fputcsv($handle, ['Servicio', 'Fecha de Cita', 'Estado', 'Calificación Profesional', 'Calificación Cliente']);

        // Escribir los datos de las citas
        foreach ($citas as $cita) {
            fputcsv($handle, [
                $cita->servicio->nombre,
                \Carbon\Carbon::parse($cita->fechaCita)->format('d-m-Y H:i'),
                $cita->estado,
                $cita->calificacionesProfesion->avg('calificacion') ?? 'No disponible',
                $cita->calificacionesCliente->avg('calificacion') ?? 'No disponible',
            ]);
        }

        fclose($handle);
        exit;
    }

}
