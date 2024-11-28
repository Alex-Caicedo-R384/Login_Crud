@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('Agregar GPU') }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('gpus.store') }}" method="POST" id="gpu-form">
            @csrf
            <div class="form-group">
                <label for="base">{{ __('Marca de GPU') }}</label>
                <select name="base" id="base" class="form-control" required>
                    <option value="" disabled selected>Selecciona un tipo</option>
                    <option value="RTX">RTX</option>
                    <option value="RX">RX</option>
                    <option value="ARC">ARC</option>
                </select>
            </div>

            <div class="form-group">
                <label for="suffix">{{ __('Modelo de la GPU') }}</label>
                <input type="text" name="suffix" id="suffix" class="form-control" placeholder="Ingrese su GPU" required>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        </form>
    </div>

    <script>
        document.getElementById('gpu-form').addEventListener('submit', function (event) {
            const base = document.getElementById('base').value;
            const suffix = document.getElementById('suffix').value;

            const forbiddenWords = ['RTX', 'RX', 'ARC'];
            for (const word of forbiddenWords) {
                if (suffix.toUpperCase().includes(word)) {
                    event.preventDefault();
                    alert('El modelo no puede contener las palabras RTX, RX o ARC.');
                    return;
                }
            }

            if (!base) {
                event.preventDefault();
                alert('Selecciona un tipo de GPU.');
            }
        });
    </script>
@endsection
