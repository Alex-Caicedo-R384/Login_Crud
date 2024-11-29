@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/processors.css') }}">
@endsection

@section('content')
<div class="container">
    <h1 class="title">Lista de Procesadores</h1>
    <a href="{{ route('processors.create') }}" class="btn primary-btn">Agregar Procesador</a>
    
    <div class="table-container">
        <table class="computer-table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($processors as $processor)
                    <tr>
                        <td>{{ $processor->name }}</td>
                        <td class="action-buttons">
                            <a href="{{ route('processors.edit', $processor->id) }}" class="btn btn-edit">Editar</a>
                            <form action="{{ route('processors.destroy', $processor->id) }}" method="POST" class="inline-form">
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
