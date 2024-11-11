@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('Agregar GPU') }}</h1>

        <form action="{{ route('gpus.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('Nombre de la GPU') }}</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        </form>
    </div>
@endsection
