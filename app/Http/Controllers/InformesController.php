<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Cita;
use App\Models\CalificacionProfesion;
use App\Models\DatosProfesion;
use App\Models\Persona;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class InformesController extends Controller
{
    // Mostrar informes
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
            ->with(['calificacionesProfesion', 'calificacionesCliente']);

        // Filtro por idServicio
        if ($request->filled('idServicio')) {
            $query->where('idServicio', $request->idServicio);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $estadoMap = [
                'Pendiente' => 0,
                'Confirmada' => 1,
                'Cancelada' => 2,
                'Re-confirmada' => 3,
                'Pagada' => 4,
            ];

            if (isset($estadoMap[$request->estado])) {
                $query->where('estado', $estadoMap[$request->estado]);
            }
        }

        // Filtro por calificación de la profesión
        if ($request->filled('calificacion')) {
            $query->whereHas('calificacionesProfesion', function ($q) use ($request) {
                $q->where('calificacion', '>=', $request->calificacion);
            });
        }

        // 🔹 **Filtro entre fechas**
        if ($request->filled('fechaInicio') && $request->filled('fechaFin')) {
            $fechaInicio = Carbon::parse($request->fechaInicio)->startOfDay();
            $fechaFin = Carbon::parse($request->fechaFin)->endOfDay();
            $query->whereBetween('fechaCita', [$fechaInicio, $fechaFin]);
        }

        // Obtener las citas filtradas
        $citas = $query->get();

        return view('Informes.informes', compact('citas', 'servicios', 'persona'));
    }

    

    public function exportarPDF(Request $request)
    {
        // Obtener las citas con los filtros
        $citas = Cita::with(['servicio', 'calificacionesProfesion', 'calificacionesCliente'])->get();

        // Generar PDF con la vista Blade
        $pdf = Pdf::loadView('Informes.pdf', compact('citas'));

        return $pdf->download('informe_citas.pdf');
    }

    // Exportar a Excel
    public function exportarExcel(Request $request)
    {
        // Recibir las citas pasadas como parámetro JSON
        $citas = collect(json_decode($request->citas));

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
                $cita->calificacionesProfesion->calificacion ?? 'No disponible',
                $cita->calificacionesCliente->calificacion ?? 'No disponible',
            ]);
        }

        fclose($handle);
        exit;
    }



}
