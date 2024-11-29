@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/configuraciones.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1 class="title">{{ __('Lista de Configuraciones') }}</h1>
        <a href="{{ route('configuracion.create') }}" class="btn primary-btn">{{ __('Agregar Nueva Configuración') }}</a>
        
        <div class="table-container">
            <table class="config-table mt-3">
                <thead>
                    <tr>
                        <th>{{ __('Resolución') }}</th>
                        <th>{{ __('Preset') }}</th>
                        <th>{{ __('RTX') }}</th>
                        <th>{{ __('Acciones') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($configuraciones as $configuracion)
                        <tr>
                            <td>{{ $configuracion->resolucion }}</td>
                            <td>{{ $configuracion->preset }}</td>
                            <td>{{ $configuracion->rtx }}</td>
                            <td class="action-buttons">
                                <a href="{{ route('configuracion.edit', $configuracion->id) }}" class="btn btn-edit">{{ __('Editar') }}</a>
                                <form action="{{ route('configuracion.destroy', $configuracion->id) }}" method="POST" class="inline-form">
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
