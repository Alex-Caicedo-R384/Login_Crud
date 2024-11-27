@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Lista de Configuraciones</h1>
        <a href="{{ route('configuracion.create') }}" class="btn btn-primary">Agregar Nueva Configuración</a>
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Resolución</th>
                    <th>Preset</th>
                    <th>RTX</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($configuraciones as $configuracion)
                    <tr>
                        <td>{{ $configuracion->resolucion }}</td>
                        <td>{{ $configuracion->preset }}</td>
                        <td>{{ $configuracion->rtx }}</td>
                        <td>
                            <a href="{{ route('configuracion.edit', $configuracion->id) }}" class="btn btn-warning">Editar</a>
                            <form action="{{ route('configuracion.destroy', $configuracion->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
