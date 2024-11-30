@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
@endsection

@section('content')
<section class="dashboard-container">
    <header class="dashboard-header">
        <h1>{{ __('Bienvenido, ') . Auth::user()->name }}</h1>
        <p>{{ __('Esta es el área donde puedes navegar.') }}</p>
    </header>

    <section class="dashboard-content">
        @if (session('status'))
            <div class="dashboard-alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="dashboard-actions">
            @if (Auth::user()->is_admin)
                <div class="dashboard-action-card admin-card">
                    <h2><i class="fas fa-user-shield"></i> {{ __('Administración') }}</h2>
                    <p>{{ __('Eres administrador. Puedes Gestionar las siguientes secciones.') }}</p>
                    <a href="{{ route('gpus.index') }}" class="dashboard-action-btn"><i class="fas fa-microchip"></i> {{ __('GPUs') }}</a>
                    <a href="{{ route('processors.index') }}" class="dashboard-action-btn"><i class="fas fa-microchip"></i> {{ __('CPU') }}</a>
                    <a href="{{ route('juegos.index') }}" class="dashboard-action-btn"><i class="fas fa-gamepad"></i> {{ __('Juegos') }}</a>
                    <a href="{{ route('configuracion.index') }}" class="dashboard-action-btn"><i class="fas fa-cogs"></i> {{ __('Configuración') }}</a>
                    <a href="{{ route('ajustes.index') }}" class="dashboard-action-btn"><i class="fas fa-cogs"></i> {{ __('Ajustes Recomendados') }}</a>
                </div>
            @else
                <div class="dashboard-action-card user-card">
                    <h2><i class="fas fa-user"></i> {{ __('Usuario') }}</h2>
                    <p>{{ __('No tienes acceso administrativo.') }}</p>
                </div>
            @endif

            <div class="dashboard-action-card used-card">
                <p>{{ __('Explora los Benchmark registrados en el sistema y crea benchmark para que los demas los vean.') }}</p>
                <a href="{{ route('benchmarks.index') }}" class="dashboard-action-btn"><i class="fas fa-desktop"></i> {{ __('Benchmarks') }}</a>
                <a href="{{ route('benchmark.index') }}" class="dashboard-action-btn"><i class="fas fa-chart-line"></i> {{ __('Crear Benchmark') }}</a>
            </div>
        </div>
    </section>
</section>
@endsection
