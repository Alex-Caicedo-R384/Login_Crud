@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/index-benchmark.css') }}">
@endsection

@section('content')
    <h1 class="title">Listado de Benchmarks</h1>

    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <section class="alert alert-success" role="alert">
            {{ session('success') }}
        </section>
    @endif

    <section class="actions">
        <a href="{{ route('benchmark.create') }}" class="primary-btn">Agregar Benchmark</a>
    </section>

    {{-- Tabla de datos --}}
    @if ($benchmarks->isEmpty())
        <p class="no-data">No hay benchmarks registrados en el sistema.</p>
    @else
        <table class="benchmark-table">
            <thead>
                <tr>
                    <th scope="col">Juego</th>
                    <th scope="col">Configuración</th>
                    <th scope="col">GPU</th>
                    <th scope="col">CPU</th>
                    <th scope="col">Avg FPS</th>
                    <th scope="col">Min FPS</th>
                    <th scope="col">CPU Usage</th>
                    <th scope="col">GPU Usage</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($benchmarks as $benchmark)
                    <tr>
                        <td>{{ $benchmark->juego->nombre }}</td>
                        <td>{{ $benchmark->configuracion->resolucion }}</td>
                        <td>{{ $benchmark->gpu->name }}</td>
                        <td>{{ $benchmark->processor->name }}</td>
                        <td>{{ $benchmark->avg_fps }}</td>
                        <td>{{ $benchmark->min_fps }}</td>
                        <td>{{ $benchmark->cpu_usage }}%</td>
                        <td>{{ $benchmark->gpu_usage }}%</td>
                        <td class="action-buttons">
                            {{-- Botón de edición --}}
                            <a class="btn-edit" href="{{ route('benchmark.edit', $benchmark) }}">Editar</a>

                            {{-- Botón de eliminación --}}
                            <form action="{{ route('benchmark.destroy', $benchmark) }}" method="POST" class="inline-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete" onclick="return confirm('¿Estás seguro de eliminar este benchmark?')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
