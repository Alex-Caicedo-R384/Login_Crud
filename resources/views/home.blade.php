@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<section class="container">
    <header class="card-header">{{ __('Inicio') }}</header>

    <article class="card">
        <section class="card-body">
            @if (session('status'))
                <article class="alert" role="alert">
                    {{ session('status') }}
                </article>
            @endif

            @if (Auth::user()->is_admin)
                <a href="{{ route('gpus.index') }}" class="btn btn-primary">{{ __('GPUS') }}</a>
                <a href="{{ route('processors.index') }}" class="btn btn-primary">{{ __('CPUS') }}</a>
            @else
                <p>{{ __('No eres administrador') }}</p>
            @endif

            <a href="{{ route('computers.index') }}" class="btn">{{ __('COMPUTADORAS') }}</a>
        </section>
    </article>
</section>
@endsection
