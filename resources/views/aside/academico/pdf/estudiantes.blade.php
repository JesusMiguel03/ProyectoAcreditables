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

    <h2 class="text-center">Listado de estudiantes</h2>

    <br>

    <h5>[Acreditable {{ $estudiantes[0]->materia->nom_materia }}]</h5>
    <p>
        <span class="font-weight-bold">Fecha de emisión:</span>
        {{ date('d') . ' de ' . ('Illuminate\Support\Carbon')::now()->locale('es')->monthName . ' de ' . date('Y') }}
    </p>
    <p style="margin-top: -1rem">
        <span class="font-weight-bold">Período académico</span>
        @if (!empty($periodo))
            @php
                $inicio = explode('-', explode(' ', $periodo->inicio)[0]);
                $inicioDia = $inicio[2];
                $inicioMes = $inicio[1];
                $inicioFecha = $inicio[0];
                $inicio = $inicioDia . '-' . $inicioMes . '-' . $inicioFecha;
                
                $fin = explode('-', explode(' ', $periodo->fin)[0]);
                $finDia = $fin[2];
                $finMes = $fin[1];
                $finFecha = $fin[0];
                $fin = $finDia . '-' . $finMes . '-' . $finFecha;
            @endphp
            [{{ $inicio }}] -
            [{{ $fin }}]
        @else
            No definido
        @endif
    </p>

    <br>

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
                    <td>V-{{ number_format($estudiante->estudiante[0]->usuarios->cedula, 0, ',', '.') }}</td>
                    <td>{{ $estudiante->estudiante[0]->usuarios->nombre }}</td>
                    <td>{{ $estudiante->estudiante[0]->usuarios->apellido }}</td>
                    <td>{{ $estudiante->estudiante[0]->pnf->nom_pnf }}</td>
                    <td>{{ $estudiante->estudiante[0]->trayecto->num_trayecto }}</td>
                    <td>{{ $estudiante->estudiante[0]->preinscrito->validacion_estudiante === 0 ? 'NV' : 'V' }}
                    </td>
                    <td style="font-size: 0.8rem">{{ $estudiante->estudiante[0]->preinscrito->codigo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
