<!-- resources/views/configuraciones/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Configuración</h1>
        <form action="{{ route('configuracion.update', $configuracion->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="resolucion" class="form-label">Resolución</label>
                <input type="text" class="form-control" id="resolucion" name="resolucion" value="{{ $configuracion->resolucion }}" required>
            </div>
            <div class="mb-3">
                <label for="preset" class="form-label">Preset</label>
                <input type="text" class="form-control" id="preset" name="preset" value="{{ $configuracion->preset }}" required>
            </div>
            <div class="mb-3">
                <label for="rtx" class="form-label">RTX</label>
                <input type="text" class="form-control" id="rtx" name="rtx" value="{{ $configuracion->rtx }}" required>
            </div>
            <button type="submit" class="btn btn-warning">Actualizar</button>
        </form>
    </div>
@endsection
