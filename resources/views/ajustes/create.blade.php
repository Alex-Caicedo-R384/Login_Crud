@extends('layouts.app')

@section('content')
    <h1>Crear Ajuste Recomendado</h1>

    {{-- Mostrar errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ajustes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="categoria">Categoría</label>
            <select name="categoria" id="categoria" class="form-control" required>
                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->categoria }}">{{ $categoria->categoria }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="min_fps">FPS Mínimos</label>
            <input type="number" name="min_fps" id="min_fps" class="form-control" value="{{ old('min_fps') }}">
        </div>
        <div class="form-group">
            <label for="max_fps">FPS Máximos</label>
            <input type="number" name="max_fps" id="max_fps" class="form-control" value="{{ old('max_fps') }}">
        </div>
        <div class="form-group">
            <label for="recommended_resolution">Resolución Recomendada</label>
            <input type="text" name="recommended_resolution" id="recommended_resolution" class="form-control" value="{{ old('recommended_resolution') }}" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
    </form>
@endsection
