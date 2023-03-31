<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Acreditable - {{ $materia->nom_materia }} {{ $materia->trayecto->num_trayecto }}</title>

    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/fonts/fonts.css') : asset('vendor/fonts/fonts.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/comprobante.css') : asset('css/comprobante.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/adminlte/dist/css/adminlte.min.css') : asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>

<body>
    <header class="encabezado">
        <img src="{{ request()->secure() ? secure_asset('vendor/img/logo.png') : asset('vendor/img/logo.png') }}"
            class="logo">

        <p class="membrete"> República Bolivariana de Venezuela </p>
        <p class="membrete"> Ministerio del Poder Popular para la Educación Universitaria </p>
        <p class="membrete"> Universidad Politécnica Territorial del Estado Aragua “Federico Brito Figueroa” </p>
        <p class="membrete"> La Victoria - Estado Aragua </p>
    </header>

    <section class="sub__encabezado">
        <h3 class="titulo">Listado de estudiantes</h3>
        <h5>(Acreditable - {{ $materia->nom_materia }} {{ $materia->trayecto->num_trayecto }})</h5>
    </section>

    <section>
        <p class="emision">
            <span class="font-weight-bold">Fecha de emisión: </span>
            {{ date('d') . ' de ' . ('Illuminate\Support\Carbon')::now()->locale('es')->monthName . ' de ' . date('Y') }}
        </p>
        <p>
            <span class="font-weight-bold">Período académico: </span>
            {{ $periodo->formato() }}
        </p>
    </section>

    <main>
        <table style="min-width: 100vw;" class="table">
            <thead>
                <tr style="font-size: 0.9rem;" class="table-primary text-center">
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>PNF</th>
                    <th>Trayecto</th>
                    <th>Estado</th>
                    <th>Validación</th>
                    <th>Nota</th>
                    <th>Asistencia</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($estudiantes as $estudiante)
                    @php
                        $CI = $estudiante->inscritoCI() ?? null;
                        $nombre = $estudiante->inscritoSoloNombre() ?? null;
                        $apellido = $estudiante->inscritoSoloApellido() ?? null;
                        $pnf = $estudiante->inscritoPNF()->nom_pnf ?? null;
                        $trayecto = $estudiante->inscritoTrayecto()->num_trayecto ?? null;
                        $estaValidado = $estudiante->validado ?? null;
                        $codigo = $estudiante->codigo ?? null;
                        $nota = $estudiante->nota ?? null;
                        $asistencia = $estudiante->aprobo()[1] ?? null;
                    @endphp

                    <tr style="font-size: 0.9rem;" class="table-active text-center">
                        <td style="width: 40%; font-size: 0.8rem">{{ $CI }}</td>
                        <td>{{ $nombre }} {{ $apellido }}</td>
                        <td>{{ $pnf }}</td>
                        <td>{{ $trayecto }}</td>
                        <td class="{{ $estaValidado ? 'text-success' : 'text-danger' }}">
                            <strong> {{ $estaValidado ? 'V' : 'NV' }} </strong>
                        </td>
                        <td>{{ $codigo }}</td>
                        <td>{{ $nota }}</td>
                        <td>{{ $asistencia }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <footer class="nota">
        <section class="firma__area">
            <h6 class="firma">
                Firma Coordinador de Acreditables
            </h6>
        </section>
    </footer>
</body>

</html>
