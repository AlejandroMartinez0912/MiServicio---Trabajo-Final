@extends('layouts.administracion')


@section('contenido')

<h2 style="font-family: Arial, sans-serif; color: #333399;">Panel de Control</h2>
<p style="font-family: Arial, sans-serif; font-size: 1.2rem; color: #333;">Bienvenido al panel de administración. Desde aquí puedes gestionar usuarios, servicios, pagos y mucho más.</p>

<div class="dashboard-buttons" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center; margin-top: 20px;">
    <a href="{{ route('index-admin') }}" 
       style="display: block; padding: 12px 24px; background: linear-gradient(90deg, #ff00cc, #333399); color: white; font-family: Arial, sans-serif; font-weight: bold; text-align: center; border-radius: 8px; text-decoration: none; width: 150px; transition: background-color 0.3s;">
       Panel: Administrador
    </a>
    <a href="{{ route('admin-usuarios') }}" 
       style="display: block; padding: 12px 24px; background: linear-gradient(90deg, #ff00cc, #333399); color: white; font-family: Arial, sans-serif; font-weight: bold; text-align: center; border-radius: 8px; text-decoration: none; width: 150px; transition: background-color 0.3s;">
       Gestión de Usuarios
    </a>
    <a href="{{ route('admin-servicios') }}" 
       style="display: block; padding: 12px 24px;background: linear-gradient(90deg, #ff00cc, #333399); color: white; font-family: Arial, sans-serif; font-weight: bold; text-align: center; border-radius: 8px; text-decoration: none; width: 150px; transition: background-color 0.3s;">
       Gestión de Servicios
    </a>
    <a href="{{ route('admin-auditoria') }}" 
       style="display: block; padding: 12px 24px;background: linear-gradient(90deg, #ff00cc, #333399); color: white; font-family: Arial, sans-serif; font-weight: bold; text-align: center; border-radius: 8px; text-decoration: none; width: 150px; transition: background-color 0.3s;">
       Auditoría
    </a>
    <a href="{{ route('admin-estadisticas') }}" 
       style="display: block; padding: 12px 24px; background: linear-gradient(90deg, #ff00cc, #333399); color: white; font-family: Arial, sans-serif; font-weight: bold; text-align: center; border-radius: 8px; text-decoration: none; width: 150px; transition: background-color 0.3s;">
       Estadísticas
    </a>
    
</div>

<style>
    .dashboard-buttons a:hover {
        background-color: #ff00cc;
        cursor: pointer;
    }
</style>

@endsection