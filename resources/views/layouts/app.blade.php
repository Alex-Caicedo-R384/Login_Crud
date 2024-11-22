<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    @vite([
        'resources/sass/app.scss', 
        'resources/js/app.js', 
        'resources/css/login.css', 
        'resources/css/register.css', 
        'resources/css/dashboard.css',
        'resources/css/index.css',
        'resources/css/create-computer.css',
        'resources/css/edit-computer.css',
        'resources/css/create-cpu-gpu.css',
        'resources/css/header.css'
    ]) <!-- Incluir aquí más css-->
</head>

<body>
    <div id="app">
            <header class="navbar">
                <div class="container">
                    <span class="navbar-brand" href="{{ route('home') }}">
                        {{ config('app.name', 'Laravel') }}
                    </span>

                    <nav class="navbar-links">
                        <ul class="nav-menu">
                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar Sesión') }}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button">
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('home') }}">{{ __('CRUDS') }}</a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('logout') }}" 
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Cerrar Sesión') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endguest
                        </ul>
                    </nav>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <button class="navbar-toggler" id="menuToggle">
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                        <span class="toggler-icon"></span>
                    </button>
                </div>
            </header>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
