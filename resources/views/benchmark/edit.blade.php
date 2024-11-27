@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Benchmark</h1>
        <form action="{{ route('benchmark.update', $benchmark->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="juego_id" class="form-label">Juego</label>
                <select name="juego_id" id="juego_id" class="form-control" required>
                    @foreach($juegos as $juego)
                        <option value="{{ $juego->id }}" {{ $benchmark->juego_id == $juego->id ? 'selected' : '' }}>
                            {{ $juego->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="configuracion_id" class="form-label">Configuración</label>
                <select name="configuracion_id" id="configuracion_id" class="form-control" required>
                    @foreach($configuraciones as $configuracion)
                        <option value="{{ $configuracion->id }}" {{ $benchmark->configuracion_id == $configuracion->id ? 'selected' : '' }}>
                            {{ $configuracion->resolucion }} / {{ $configuracion->preset }} / {{ $configuracion->rtx }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="gpu_id" class="form-label">GPU</label>
                <select name="gpu_id" id="gpu_id" class="form-control" required>
                    @foreach($gpus as $gpu)
                        <option value="{{ $gpu->id }}" {{ $benchmark->gpu_id == $gpu->id ? 'selected' : '' }}>
                            {{ $gpu->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="cpu_id" class="form-label">CPU</label>
                <select name="cpu_id" id="cpu_id" class="form-control" required>
                    @foreach($processors as $processor)
                        <option value="{{ $processor->id }}" {{ $benchmark->cpu_id == $processor->id ? 'selected' : '' }}>
                            {{ $processor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="avg_fps" class="form-label">Avg FPS</label>
                <input type="number" step="any" name="avg_fps" id="avg_fps" class="form-control" value="{{ $benchmark->avg_fps }}" required>
            </div>

            <div class="mb-3">
                <label for="min_fps" class="form-label">Min FPS</label>
                <input type="number" step="any" name="min_fps" id="min_fps" class="form-control" value="{{ $benchmark->min_fps }}" required>
            </div>

            <div class="mb-3">
                <label for="cpu_usage" class="form-label">CPU Usage (%)</label>
                <input type="number" step="any" name="cpu_usage" id="cpu_usage" class="form-control" value="{{ $benchmark->cpu_usage }}" required>
            </div>

            <div class="mb-3">
                <label for="gpu_usage" class="form-label">GPU Usage (%)</label>
                <input type="number" step="any" name="gpu_usage" id="gpu_usage" class="form-control" value="{{ $benchmark->gpu_usage }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Benchmark</button>
        </form>
    </div>
@endsection
