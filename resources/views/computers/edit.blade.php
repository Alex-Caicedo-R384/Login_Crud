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
        <input type="text" name="procesador" value="{{ $computer->procesador }}" required>
        
        <label for="modulos_ram">Módulos RAM:</label>
        <input type="number" name="modulos_ram" value="{{ $computer->modulos_ram }}" required>
        
        <label for="capacidad_ram">Capacidad RAM (GB):</label>
        <input type="number" name="capacidad_ram" value="{{ $computer->capacidad_ram }}" required>
        
        <label for="gpu">GPU:</label>
        <input type="text" name="gpu" value="{{ $computer->gpu }}" required>

        <button type="submit" class="btn-submit">Actualizar</button>
    </form>
@endsection
