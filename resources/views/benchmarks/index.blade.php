@extends('layouts.app')

@section('content')
<section class="container">
    <h1 class="text-center mb-4">Explorar Juegos</h1>

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
                            <img src="{{ asset('images/' . $images[$benchmark->juego->id]) }}" class="card-img-top" alt="{{ $benchmark->juego->name }}">
                            <figcaption class="fps-badge">{{ $benchmark->avg_fps }} FPS</figcaption> <!-- FPS Badge -->
                        </figure>
                        <section class="card-body">
                            <h5 class="card-title text-center">{{ $benchmark->juego->nombre }}</h5>
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
                    
                    <h4>Mejor Gráfica con:</h4>
                    <ul>
                        <li><strong>Gráfica recomendada:</strong> {{ $selectedBenchmark->gpu->name }}</li>
                    </ul>
                </section>
            </section>
        </article>
    </section>
    @endif
</section>
@endsection
