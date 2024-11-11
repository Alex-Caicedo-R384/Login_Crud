@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/computers.css') }}">
@endsection

@section('content')
    <h1>Computadoras</h1>

    @if (session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <a class="btn" href="{{ route('computers.create') }}">Crear Computadora</a>

    <table class="computer-table">
        <thead>
            <tr>
                <th>Procesador</th>
                <th>GPU</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($computers as $computer)
                <tr>
                    <td>{{ $computer->processor->name }}</td>
                    <td>{{ $computer->gpu->name }}</td>
                    <td>
                        <a class="btn-edit" href="{{ route('computers.edit', $computer) }}">Editar</a>
                        <form action="{{ route('computers.destroy', $computer) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
