@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/juegos.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="title">Lista de Juegos</h1>
        <a href="{{ route('juegos.create') }}" class="btn primary-btn">Agregar Nuevo Juego</a>

        <div class="table-container">
            <table class="computer-table mt-3">
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
                            <td class="action-buttons">
                                <a href="{{ route('juegos.edit', $juego->id) }}" class="btn btn-edit">Editar</a>
                                <form action="{{ route('juegos.destroy', $juego->id) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
