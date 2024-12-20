@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Agregar Nuevo Juego</h1>
        <form action="{{ route('juegos.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-control" id="categoria" name="categoria" required>
                    <option value="" disabled selected>Selecciona una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria }}">{{ $categoria }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
@endsection
