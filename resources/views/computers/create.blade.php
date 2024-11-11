@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/computers.css') }}">
@endsection

@section('content')
    <h1>Crear Computadora</h1>

    <form action="{{ route('computers.store') }}" method="POST">
        @csrf

        <label for="processor_name">Selecciona el procesador</label>
        <select name="processor_name" id="processor_name" class="form-control">
            <option value="">Seleccione un procesador</option>
            @foreach ($processors as $processor)
                <option value="{{ $processor->name }}">{{ $processor->name }}</option>
            @endforeach
        </select>

        <label for="gpu_name">Selecciona la GPU</label>
        <select name="gpu_name" id="gpu_name" class="form-control">
            <option value="">Seleccione una GPU</option>
            @foreach ($gpus as $gpu)
                <option value="{{ $gpu->name }}">{{ $gpu->name }}</option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-primary">Crear Computadora</button>
    </form>
@endsection
