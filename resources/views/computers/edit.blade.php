@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/edit-computer.css') }}">
@endsection

@section('content')
    <h1>Editar Computadora</h1>

    <form action="{{ route('computers.update', $computer) }}" method="POST" class="computer-form">
        @csrf
        @method('PUT')
        
        <label for="procesador">Procesador:</label>
        <select name="procesador" required>
            <option value="">Seleccione un procesador</option>
            @foreach ($procesadores as $procesador)
                <option value="{{ $procesador->id }}" {{ $procesador->id == $computer->procesador ? 'selected' : '' }}>
                    {{ $procesador->name }}
                </option>
            @endforeach
        </select>

        <label for="gpu">GPU:</label>
        <select name="gpu" required>
            <option value="">Seleccione una GPU</option>
            @foreach ($gpus as $gpu)
                <option value="{{ $gpu->id }}" {{ $gpu->id == $computer->gpu ? 'selected' : '' }}>
                    {{ $gpu->name }}
                </option>
            @endforeach
        </select>

        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <button type="submit" class="btn-submit">Actualizar</button>
    </form>
@endsection
