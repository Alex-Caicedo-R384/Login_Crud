@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<section class="container">
    <h2 class="text-center">{{ __('Registrarse') }}</h2>

    <form method="POST" action="{{ route('register') }}" class="register-form">
        @csrf

        <!-- Nombre -->
        <div class="form-group">
            <label for="name" class="form-label">{{ __('Nombre') }}</label>
            <input id="name" 
                   type="text" 
                   class="form-input @error('name') is-invalid @enderror" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required 
                   autocomplete="name" 
                   autofocus>
            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Correo -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('Correo Electrónico') }}</label>
            <input id="email" 
                   type="email" 
                   class="form-input @error('email') is-invalid @enderror" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autocomplete="email">
            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Contraseña -->
        <div class="form-group">
            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
            <input id="password" 
                   type="password" 
                   class="form-input @error('password') is-invalid @enderror" 
                   name="password" 
                   required 
                   autocomplete="new-password">
            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <!-- Confirmar Contraseña -->
        <div class="form-group">
            <label for="password-confirm" class="form-label">{{ __('Confirmar Contraseña') }}</label>
            <input id="password-confirm" 
                   type="password" 
                   class="form-input" 
                   name="password_confirmation" 
                   required 
                   autocomplete="new-password">
        </div>

        <!-- Botón de Enviar -->
        <div class="form-group">
            <button type="submit" class="btn submit-btn">
                {{ __('Registrarse') }}
            </button>
        </div>
    </form>
</section>
@endsection
