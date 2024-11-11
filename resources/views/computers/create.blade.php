@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/create-computer.css') }}">
@endsection

@section('content')
    <h1>Crear Computadora</h1>

    <form action="{{ route('computers.store') }}" method="POST" class="computer-form">
        @csrf
        
        <label for="procesador">Procesador:</label>
        <select name="procesador" required>
            <option value="">Seleccione un procesador</option>
            @foreach ($procesadores as $procesador)
                <option value="{{ $procesador->id }}">{{ $procesador->name }}</option>
            @endforeach
        </select>

        <label for="gpu">GPU:</label>
        <select name="gpu" required>
            <option value="">Seleccione una GPU</option>
            @foreach ($gpus as $gpu)
                <option value="{{ $gpu->id }}">{{ $gpu->name }}</option>
            @endforeach
        </select>

        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <button type="submit" class="btn-submit">Crear</button>
    </form>
@endsection
