<!-- resources/views/juegos/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Juego</h1>
        <form action="{{ route('juegos.update', $juego->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $juego->nombre }}" required>
            </div>
            <button type="submit" class="btn btn-warning">Actualizar</button>
        </form>
    </div>
@endsection
