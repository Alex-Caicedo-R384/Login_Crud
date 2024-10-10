@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endsection

@section('content')
<section class="container">
    <header class="card-header">{{ __('Dashboard') }}</header>

    <article class="card">
        <section class="card-body">
            @if (session('status'))
                <article class="alert" role="alert">
                    {{ session('status') }}
                </article>
            @endif

            <p>{{ __('You are logged in!') }}</p>

            <!-- Botón para eliminar el usuario -->
            <form method="POST" action="{{ route('user.destroy', Auth::user()->id) }}" onsubmit="return confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn submit-btn">
                    {{ __('Eliminar Cuenta') }}
                </button>
            </form>
        </section>
    </article>
</section>
@endsection
