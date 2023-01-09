<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Listado de estudiantes</title>

    {{-- Font --}}
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">

    {{-- Base Stylesheets --}}
    @if (!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">

        {{-- Configured Stylesheets --}}
        @include('adminlte::plugins', ['type' => 'css'])

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif

</head>

<body
    style="background: url({{ asset('vendor/img/comprobante.png') }}) no-repeat fixed 50% 50%; background-color: rgba(255, 255, 255, 0.6); background-blend-mode: lighten; font-family: 'Times New Roman'">

    <header>
        <h2 class="text-center">Listado de estudiantes</h2>
        <h4 class="text-center">(Acreditable: {{ $materia->nom_materia }})</h5>
            <p>
                <span class="font-weight-bold">Fecha de emisión:</span>
                {{ date('d') . ' de ' . ('Illuminate\Support\Carbon')::now()->locale('es')->monthName . ' de ' . date('Y') }}
            </p>
            <p style="margin-top: -1rem">
                <span class="font-weight-bold">Período académico:</span>
                {{ !empty(periodo()) ? periodo() : 'No definido' }}
            </p>
    </header>

    <main>
        <table class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>PNF</th>
                    <th>Trayecto</th>
                    <th>Estado</th>
                    <th>Cod. Validación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estudiantes as $estudiante)
                    <tr>
                        <td>{{ parsearCedula(estudiante_materia($estudiante, 'cedula')) }}</td>
                        <td>{{ estudiante_materia($estudiante, 'nombre') }}</td>
                        <td>{{ estudiante_materia($estudiante, 'apellido') }}</td>
                        <td>{{ estudiante($estudiante->esEstudiante, 'pnfNombre') }}</td>
                        <td>{{ estudiante($estudiante->esEstudiante, 'trayectoNumero') }}</td>
                        <td
                            class="{{ estudiante_materia($estudiante, 'estaValidado') ? 'text-success' : 'text-danger' }}">
                            {{ estudiante_materia($estudiante, 'estaValidado') ? 'V' : 'NV' }}
                        </td>
                        <td>{{ estudiante($estudiante->esEstudiante, 'codigo') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

</body>

</html>
