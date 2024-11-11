@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('Lista de Procesadores') }}</h1>
        <a href="{{ route('processors.create') }}" class="btn btn-primary">{{ __('Agregar Procesador') }}</a>
        
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Nombre') }}</th>
                    <th>{{ __('Acciones') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($processors as $processor)
                    <tr>
                        <td>{{ $processor->name }}</td>
                        <td>
                            <a href="{{ route('processors.edit', $processor->id) }}" class="btn btn-warning">{{ __('Editar') }}</a>
                            <form action="{{ route('processors.destroy', $processor->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">{{ __('Eliminar') }}</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
