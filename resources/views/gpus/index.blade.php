@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('GPU List') }}</h1>
        <a href="{{ route('gpus.create') }}" class="btn btn-primary">{{ __('Agregar GPU') }}</a>
        
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('Nombre') }}</th>
                    <th>{{ __('Acciones') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($gpus as $gpu)
                    <tr>
                        <td>{{ $gpu->name }}</td>
                        <td>
                            <a href="{{ route('gpus.edit', $gpu->id) }}" class="btn btn-warning">{{ __('Editar') }}</a>
                            <form action="{{ route('gpus.destroy', $gpu->id) }}" method="POST" style="display:inline;">
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
