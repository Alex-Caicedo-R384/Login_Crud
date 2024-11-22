@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/computers.css') }}">
@endsection

@section('content')
    <h1 class="title">Lista de Computadoras</h1>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    {{-- Botón de crear --}}
    <div class="actions">
        <a class="btn primary-btn" href="{{ route('computers.create') }}">Agregar Computadora</a>
    </div>

    {{-- Tabla de datos --}}
    @if ($computers->isEmpty())
        <p class="no-data">No hay computadoras registradas en el sistema.</p>
    @else
        <div class="table-container">
            <table class="computer-table">
                <thead>
                    <tr>
                        <th scope="col">Procesador</th>
                        <th scope="col">GPU</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($computers as $computer)
                        <tr>
                            <td>{{ $computer->processor->name }}</td>
                            <td>{{ $computer->gpu->name }}</td>
                            <td class="action-buttons">
                                {{-- Botón de edición --}}
                                <a class="btn btn-edit" href="{{ route('computers.edit', $computer) }}">Editar</a>

                                {{-- Botón de eliminación --}}
                                <form action="{{ route('computers.destroy', $computer) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('¿Estás seguro de eliminar esta computadora?')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection
