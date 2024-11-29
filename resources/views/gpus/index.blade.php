@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/processors.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="title">{{ __('GPU List') }}</h1>
        <a href="{{ route('gpus.create') }}" class="btn primary-btn">{{ __('Agregar GPU') }}</a>
        
        <div class="table-container">
            <table class="computer-table mt-3">
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
                            <td class="action-buttons">
                                <a href="{{ route('gpus.edit', $gpu->id) }}" class="btn btn-edit">{{ __('Editar') }}</a>
                                <form action="{{ route('gpus.destroy', $gpu->id) }}" method="POST" class="inline-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete">{{ __('Eliminar') }}</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
