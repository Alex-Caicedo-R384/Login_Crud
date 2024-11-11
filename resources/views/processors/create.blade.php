@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('Agregar Procesador') }}</h1>

        <form action="{{ route('processors.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('Nombre del Procesador') }}</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        </form>
    </div>
@endsection
