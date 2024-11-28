@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<section class="dashboard-container">
    <header class="dashboard-header">
        <h1>{{ __('Bienvenido, ') . Auth::user()->name }}</h1>
        <p>{{ __('Esta es el área donde puedes ver los CRUDS.') }}</p>
    </header>

    <section class="dashboard-content">
        @if (session('status'))
            <div class="dashboard-alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="dashboard-actions">
            @if (Auth::user()->is_admin)
                <div class="action-card admin-card">
                    <h2><i class="fas fa-user-shield"></i> {{ __('Administración') }}</h2>
                    <p>{{ __('Eres administrador. Puedes Gestionar las siguientes secciones.') }}</p>
                    <a href="{{ route('gpus.index') }}" class="btn action-btn"><i class="fas fa-microchip"></i> {{ __('GPUs') }}</a>
                    <a href="{{ route('processors.index') }}" class="btn action-btn"><i class="fas fa-microchip"></i> {{ __('CPU') }}</a>
                    <a href="{{ route('juegos.index') }}" class="btn action-btn"><i class="fas fa-gamepad"></i> {{ __('Juegos') }}</a>
                    <a href="{{ route('configuracion.index') }}" class="btn action-btn"><i class="fas fa-cogs"></i> {{ __('Configuración') }}</a>
                    <a href="{{ route('benchmark.index') }}" class="btn action-btn"><i class="fas fa-chart-line"></i> {{ __('Benchmark') }}</a>
                </div>
            @else
                <div class="action-card user-card">
                    <h2><i class="fas fa-user"></i> {{ __('Usuario') }}</h2>
                    <p>{{ __('No tienes acceso administrativo.') }}</p>
                </div>
            @endif

            <div class="action-card used-card">
                <h2><i class="fas fa-desktop"></i> {{ __('Computadoras') }}</h2>
                <p>{{ __('Explora las computadoras registradas en el sistema.') }}</p>
                <a href="{{ route('computers.index') }}" class="btn action-btn"><i class="fas fa-desktop"></i> {{ __('Computadoras') }}</a>
                <a href="{{ route('benchmarks.index') }}" class="btn action-btn"><i class="fas fa-desktop"></i> {{ __('Benchmarks') }}</a>
            </div>
        </div>
    </section>
</section>
@endsection
