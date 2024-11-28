@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ __('Agregar Procesador') }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('processors.store') }}" method="POST" id="processor-form">
            @csrf
            <div class="form-group">
                <label for="base">{{ __('Tipo de Procesador') }}</label>
                <select name="base" id="base" class="form-control" required>
                    <option value="" disabled selected>Selecciona una categoria</option>
                    <option value="R3">R3</option>
                    <option value="R5">R5</option>
                    <option value="R7">R7</option>
                    <option value="R9">R9</option>
                    <option value="I3">I3</option>
                    <option value="I5">I5</option>
                    <option value="I7">I7</option>
                    <option value="I9">I9</option>
                </select>
            </div>

            <div class="form-group">
                <label for="suffix">{{ __('Modelo del Procesador') }}</label>
                <input type="text" name="suffix" id="suffix" class="form-control" placeholder="Ingesa el procesador" required>
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Guardar') }}</button>
        </form>
    </div>

    <script>
        document.getElementById('processor-form').addEventListener('submit', function (event) {
            const base = document.getElementById('base').value;
            const suffix = document.getElementById('suffix').value;

            const forbiddenWords = ['R3', 'R5', 'R7', 'R9', 'I3', 'I5', 'I7', 'I9'];
            for (const word of forbiddenWords) {
                if (suffix.toUpperCase().includes(word)) {
                    event.preventDefault();
                    alert('El modelo no puede contener las palabras R3, R5, R7, R9, I3, I5, I7 o I9.');
                    return;
                }
            }

            if (!base) {
                event.preventDefault();
                alert('Selecciona un tipo de procesador.');
            }
        });
    </script>
@endsection
