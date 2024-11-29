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
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría</label>
                <select class="form-control" id="categoria" name="categoria" required>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria }}" 
                            @if($categoria === $juego->categoria) selected @endif>
                            {{ $categoria }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-warning">Actualizar</button>
        </form>
    </div>
@endsection
