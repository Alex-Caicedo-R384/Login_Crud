@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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
                    <h2>{{ __('Administración') }}</h2>
                    <p>{{ __('Eres administrador. Gestiona las secciones de GPUs y CPUs.') }}</p>
                    <a href="{{ route('gpus.index') }}" class="btn action-btn">{{ __('GPUs') }}</a>
                    <a href="{{ route('processors.index') }}" class="btn action-btn">{{ __('CPUs') }}</a>
                </div>
            @else
                <div class="action-card user-card">
                    <h2>{{ __('Usuario') }}</h2>
                    <p>{{ __('No tienes acceso administrativo.') }}</p>
                </div>
            @endif

            <div class="action-card">
                <h2>{{ __('Computadoras') }}</h2>
                <p>{{ __('Explora las computadoras registradas en el sistema.') }}</p>
                <a href="{{ route('computers.index') }}" class="btn action-btn">{{ __('Computadoras') }}</a>
            </div>
        </div>
    </section>
</section>
@endsection
