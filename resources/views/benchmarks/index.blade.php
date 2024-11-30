@extends('layouts.app')

@section('content')
<section class="container">
    <h1 class="text-center mb-4">Explorar Juegos</h1>

    <!-- Seleccionar GPU -->
    <section class="select-gpu-section">
        <h2>Seleccionar GPU</h2>
        <form action="{{ route('benchmarks.index') }}" method="GET">
            <label for="gpu">Elige una GPU:</label>
            <select name="gpu_id" id="gpu">
                <option value="">Mostrar todas las gráficas</option>
                @foreach ($gpus as $gpu)
                    <option value="{{ $gpu->id }}" {{ request('gpu_id') == $gpu->id ? 'selected' : '' }}>
                        {{ $gpu->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit">Filtrar</button>
        </form>

        @if (isset($benchmarks))
            @if ($benchmarks->isEmpty())
                <p class="error-message">No se encontraron benchmarks para la GPU seleccionada.</p>
            @endif
        @endif
    </section>


    <!-- Lista de Juegos -->
    <section class="row" id="juegos">
        @foreach ($groupedByCategory as $categoria => $benchmarksInCategory)
            <h2 class="category-title">{{ $categoria }}</h2>

            @php
                $bestConfigData = $bestConfigsByCategory[$categoria] ?? null;
            @endphp

            <div class="best-gpu-message">
                @if ($bestConfigData)
                    <p class="fps-message">
                        <strong>Validación de FPS:</strong> {{ $bestConfigData['message'] }}
                    </p>
                    @if ($bestConfigData['bestGpu'])
                        <p><strong>La mejor gráfica para esta categoría:</strong> {{ $bestConfigData['bestGpu']->name }}.</p>
                        <p><strong>FPS promedio:</strong> {{ $bestConfigData['bestFps'] }} FPS.</p>
                        <p><strong>Resolución recomendada:</strong> {{ $bestConfigData['bestConfig'] ? $bestConfigData['bestConfig']->resolucion : 'No disponible' }}.</p>
                        @if ($bestConfigData['bestConfig'] && $bestConfigData['bestConfig']->rtx == 'Sí')
                            <p><strong>La configuración cuenta con RTX.</strong></p>
                        @endif
                    @else
                        <p>No se encontró una configuración recomendada para esta categoría.</p>
                    @endif
                @else
                    <p>No se encontró información para esta categoría.</p>
                @endif
            </div>

            <section class="row">
                @foreach ($benchmarksInCategory as $benchmark)
                    <article class="col-md-4 mb-4">
                        <article class="card juego-card" style="cursor: pointer;">
                            <form action="{{ route('benchmarks.index') }}" method="GET">
                                @csrf
                                <input type="hidden" name="benchmark_id" value="{{ $benchmark->id }}">
                                <button type="submit" class="btn-card">
                                    <figure class="card-img-container">
                                        <img src="{{ asset('images/' . $images[$benchmark->juego->id]) }}" class="card-img-top" alt="{{ $benchmark->juego->nombre }}">
                                        <figcaption class="fps-badge">{{ $benchmark->avg_fps }} FPS</figcaption>
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
                            <th>Uso de CPU</th>
                            <th>Diferencia en CPU</th>
                            <th>Uso de GPU</th>
                            <th>Diferencia en GPU</th>
                            <th>Gráfica</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comparisonData as $data)
                            @php
                                $isSelected = $data['benchmark']->id == $selectedBenchmark->id;
                            @endphp
                            <tr class="{{ $isSelected ? 'selected-row' : '' }}">
                                <td>
                                    {{ $data['config']->resolucion ?? 'N/A' }} - 
                                    {{ $data['config']->preset ?? 'N/A' }} - 
                                    {{ $data['config']->rtx ?? 'N/A' }}
                                </td>
                                <td>{{ $data['benchmark']->avg_fps }} FPS</td>
                                <td class="fps-improvement">
                                    {{ number_format($data['fps_improvement'], 2) }}%
                                </td>
                                <td>
                                    {{ number_format($data['benchmark']->cpu_usage, 2) }}% 
                                </td>
                                <td class="cpu-usage-diff">
                                    {{ number_format($data['cpu_usage_diff'], 2) }}%
                                </td>
                                <td>
                                    {{ number_format($data['benchmark']->gpu_usage, 2) }}%
                                </td>
                                <td class="gpu-usage-diff">
                                    {{ number_format($data['gpu_usage_diff'], 2) }}%
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
