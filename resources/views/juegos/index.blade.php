<!-- resources/views/juegos/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Juegos</h1>
        <a href="{{ route('juegos.create') }}" class="btn btn-primary">Agregar Nuevo Juego</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($juegos as $juego)
                    <tr>
                        <td>{{ $juego->nombre }}</td>
                        <td>{{ $juego->categoria }}</td>
                        <td>
                            <a href="{{ route('juegos.edit', $juego->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('juegos.destroy', $juego->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
