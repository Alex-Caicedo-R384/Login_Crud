@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('Editar Procesador') }}</h1>

        <form action="{{ route('processors.update', $processor->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">{{ __('Nombre del Procesador') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $processor->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Actualizar') }}</button>
        </form>
    </div>
@endsection
