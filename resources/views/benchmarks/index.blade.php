@extends('layouts.app')

@section('content')
<section class="container">
    <h1 class="text-center mb-4">Explorar Juegos</h1>

    <!-- Seleccionar GPU -->
    <section class="container">
        <h2>Seleccionar GPU</h2>
        <form action="{{ route('benchmarks.index') }}" method="GET">
            <label for="gpu">Elige una GPU:</label>
            <select name="gpu_id" id="gpu" class="form-control">
                @foreach ($gpus as $gpu)
                    <option value="{{ $gpu->id }}">{{ $gpu->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary mt-2">Filtrar</button>
        </form>

        @if (isset($benchmarks))
            @if ($benchmarks->isEmpty())
                <p class="error-message">No se encontraron benchmarks para la GPU seleccionada.</p>
            @else
            @endif
        @endif
    </section>

    <!-- Lista de Juegos -->
    <section class="row" id="juegos">
        @foreach ($benchmarks as $benchmark)
        <article class="col-md-4 mb-4">
            <article class="card juego-card" style="cursor: pointer;">
                <form action="{{ route('benchmarks.index') }}" method="GET">
                    @csrf
                    <input type="hidden" name="benchmark_id" value="{{ $benchmark->id }}">
                    <button type="submit" class="btn-card">
                        <figure class="card-img-container">
                            <img src="{{ asset('images/' . $images[$benchmark->juego->id]) }}" class="card-img-top" alt="{{ $benchmark->juego->nombre }}">
                            <figcaption class="fps-badge">{{ $benchmark->avg_fps }} FPS</figcaption> <!-- FPS Badge -->
                        </figure>
                        <section class="card-body">
                            <h5 class="card-title text-center">{{ $benchmark->juego->nombre }}</h5>
                            <ul class="list-group">
                                <li class="list-group-item"><strong>Gráfica:</strong> {{ $benchmark->gpu->name }}</li>
                                <li class="list-group-item"><strong>Resolución:</strong> {{ $benchmark->configuracion->resolucion }}</li>
                                <li class="list-group-item"><strong>Preset:</strong> {{ $benchmark->configuracion->preset }}</li>
                                <li class="list-group-item"><strong>RTX:</strong> {{ $benchmark->configuracion->rtx }}</li>
                            </ul>
                        </section>
                    </button>
                </form>
            </article>
        </article>
        @endforeach
    </section>

    <!-- Modal para Detalles -->
    @if(isset($selectedBenchmark))
    <section class="modal" id="detailsModal" style="display: block;">
        <article class="modal-content">
            <button class="close-btn" onclick="this.closest('.modal').style.display='none'">×</button>
            <section class="modal-body-content">
                <img src="{{ asset('images/' . $images[$selectedBenchmark->juego->id]) }}" alt="Imagen del Juego" class="game-image">
                <section id="detailsContent">
                    <h2>{{ $selectedBenchmark->juego->nombre }}</h2>
                    <p><strong>FPS Promedio:</strong> {{ $selectedBenchmark->avg_fps }}</p>
                    <p><strong>GPU:</strong> {{ $selectedBenchmark->gpu->name }} ({{ $gpu_brand }})</p>
                    <p><strong>CPU:</strong> {{ $selectedBenchmark->processor->name }} ({{ $cpu_brand }})</p>

                    <h4>Configuración:</h4>
                    <ul>
                        <li><strong>Resolución:</strong> {{ $resolucion }}</li>
                        <li><strong>Preset:</strong> {{ $preset }}</li>
                        <li><strong>RTX:</strong> {{ $rtx }}</li>
                    </ul>
                </section>
                <section>
                <h4 class="comparativa-title">Comparativa de Configuraciones:</h4>
                <table class="table comparativa-table">
                    <thead>
                        <tr>
                            <th>Configuración</th>
                            <th>FPS</th>
                            <th>Mejora en FPS</th>
                            <th>Gráfica</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparisonData as $data)
                            @php
                                $isSelected = $data['benchmark']->id == $selectedBenchmark->id;
                            @endphp
                            <tr class="{{ $isSelected ? 'selected-row' : '' }}">
                                <td>{{ $data['config']->resolucion }} - {{ $data['config']->preset }} - {{ $data['config']->rtx }}</td>
                                <td>{{ $data['benchmark']->avg_fps }} FPS</td>
                                <td class="fps-improvement">
                                    {{ number_format($data['fps_improvement'], 2) }}%
                                </td>
                                <td class="gpu-brand {{ strpos($data['benchmark']->gpu->name, 'RX') !== false ? 'gpu-amd' : (strpos($data['benchmark']->gpu->name, 'RTX') !== false ? 'gpu-nvidia' : '') }}">
                                    {{ $isSelected ? 'Gráfica Seleccionada' : $data['benchmark']->gpu->name }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>

            </section>
        </article>
    </section>
    @endif
</section>
@endsection
