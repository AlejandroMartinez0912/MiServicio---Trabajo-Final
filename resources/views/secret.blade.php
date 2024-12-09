@extends('layouts.miservicioIn')

@section('titulo')
MiServicio
@endsection

@section('contenido')

<!-- Botón -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#myModal">
    Abrir Modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Modal título</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        Contenido del modal.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Guardar cambios</button>
      </div>
    </div>
  </div>
</div>


@endsection

