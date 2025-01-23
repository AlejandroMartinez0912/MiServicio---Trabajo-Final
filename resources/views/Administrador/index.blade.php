@extends('layouts.administracion')


@section('contenido')

<h2>Panel de Control</h2>
            <p>Bienvenido al panel de administración. Desde aquí puedes gestionar usuarios, servicios, pagos y mucho más.</p>
            <div class="dashboard-buttons">
                <div class="button" href="{{ route('admin-usuarios') }}"><i class="icon">&#128100;</i>Gestionar Usuarios</div>
                <div class="button"><i class="icon">&#128176;</i>Gestionar Pagos</div>
                <div class="button"><i class="icon">&#128211;</i>Reportes</div>
                <div class="button"><i class="icon">&#128297;</i>Auditoría</div>
                <div class="button"><i class="icon">&#128736;</i>Servicios</div>
            </div>

@endsection