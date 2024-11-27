@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Agregar Nueva Configuración</h1>
        <form action="{{ route('configuracion.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="resolucion" class="form-label">Resolución</label>
                <input type="text" class="form-control" id="resolucion" name="resolucion" required>
            </div>
            <div class="mb-3">
                <label for="preset" class="form-label">Preset</label>
                <input type="text" class="form-control" id="preset" name="preset" required>
            </div>
            <div class="mb-3">
                <label for="rtx" class="form-label">RTX</label>
                <input type="text" class="form-control" id="rtx" name="rtx" required>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
@endsection
