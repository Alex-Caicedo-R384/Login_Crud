@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<section class="container">
    <h2>{{ __('Registrarse') }}</h2>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <article class="form-group">
            <input id="name" type="text" class="form-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" placeholder="{{ __('Nombre') }}" autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </article>

        <article class="form-group">
            <input id="email" type="email" class="form-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="{{ __('Correo') }}">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </article>

        <article class="form-group">
            <input id="password" type="password" class="form-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Contraseña') }}">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </article>

        <article class="form-group">
            <input id="password-confirm" type="password" class="form-input" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirmar Contraseña') }}">
        </article>

        <article class="form-group">
            <button type="submit" class="btn submit-btn">
                {{ __('Registrarse') }}
            </button>
        </article>
    </form>
</section>
@endsection
