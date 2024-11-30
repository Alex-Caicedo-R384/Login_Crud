@extends('layouts.app')

@section('content')
    <h1>Ajustes Recomendados</h1>
    <a href="{{ route('ajustes.create') }}" class="btn btn-primary">Crear Nuevo Ajuste</a>
    <table class="table">
        <thead>
            <tr>
                <th>Categoría</th>
                <th>FPS Mínimos</th>
                <th>FPS Máximos</th>
                <th>Resolución Recomendada</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($ajustes as $ajuste)
                <tr>
                    <td>{{ $ajuste->categoria }}</td>
                    <td>{{ $ajuste->min_fps }}</td>
                    <td>{{ $ajuste->max_fps }}</td>
                    <td>{{ $ajuste->recommended_resolution }}</td>
                    <td>
                        <a href="{{ route('ajustes.edit', $ajuste) }}" class="btn btn-warning">Editar</a>
                        <form action="{{ route('ajustes.destroy', $ajuste) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
