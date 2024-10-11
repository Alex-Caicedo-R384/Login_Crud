@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/create-computer.css') }}">
@endsection

@section('content')
    <h1>Crear Computadora</h1>

    <form action="{{ route('computers.store') }}" method="POST" class="computer-form">
        @csrf
        <label for="procesador">Procesador:</label>
        <input type="text" name="procesador" required>
        
        <label for="modulos_ram">Módulos RAM:</label>
        <input type="number" name="modulos_ram" required>
        
        <label for="capacidad_ram">Capacidad RAM (GB):</label>
        <input type="number" name="capacidad_ram" required>
        
        <label for="gpu">GPU:</label>
        <input type="text" name="gpu" required>

        <button type="submit" class="btn-submit">Crear</button>
    </form>
@endsection
