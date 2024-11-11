@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('Editar GPU') }}</h1>

        <form action="{{ route('gpus.update', $gpu->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">{{ __('Nombre de la GPU') }}</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $gpu->name }}" required>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Actualizar') }}</button>
        </form>
    </div>
@endsection
