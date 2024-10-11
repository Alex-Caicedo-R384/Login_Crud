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
        </section>
    </article>
</section>
@endsection
