<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Listado de Estudiantes</title>

    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/comprobante.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>

<body>
    @php
        $fecha = date('d') . ' de ' . ('Illuminate\Support\Carbon')::now()->locale('es')->monthName . ' de ' . date('Y');
    @endphp

    <header class="encabezado">
        <img src="{{ asset('vendor/img/logo.png') }}" class="logo">

        <p class="membrete"> República Bolivariana de Venezuela </p>
        <p class="membrete"> Ministerio del Poder Popular para la Educación Universitaria </p>
        <p class="membrete"> Universidad Politécnica Territorial del Estado Aragua “Federico Brito Figueroa” </p>
        <p class="membrete"> La Victoria - Estado Aragua </p>
    </header>

    <section class="sub__encabezado">
        <h3 class="titulo">Listado de estudiantes</h3>
        <h4 class="subtitulo">Acreditable ({{ $materia->nom_materia }})</h4>
    </section>

    <section>
        <p class="emision">
            <span class="font-weight-bold">Fecha de emisión: </span>
            {{ $fecha }}
        </p>
        <p>
            <span class="font-weight-bold">Período académico: </span>
            {{ periodo() }}
        </p>
    </section>

    <main>
        <table class="table">
            <thead>
                <tr class="table-primary">
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

                @php
                    $CI = datosUsuario($estudiante, 'EstudianteInscrito', 'CI');
                    $nombre = datosUsuario($estudiante, 'EstudianteInscrito', 'nombre');
                    $apellido = datosUsuario($estudiante, 'EstudianteInscrito', 'apellido');
                    $pnf = datosUsuario($estudiante, 'EstudianteInscrito', 'pnfNombre');
                    $trayecto = datosUsuario($estudiante, 'EstudianteInscrito', 'trayectoNumero');
                    $estaValidado = datosUsuario($estudiante, 'EstudianteInscrito', 'validado');
                    $codigo = datosUsuario($estudiante, 'EstudianteInscrito', 'codigo');
                @endphp

                    <tr class="table-active">
                        <td>{{ $CI }}</td>
                        <td>{{ $nombre }}</td>
                        <td>{{ $apellido }}</td>
                        <td>{{ $pnf }}</td>
                        <td>{{ $trayecto }}</td>
                        <td class="{{ $estaValidado ? 'text-success' : 'text-danger' }}">
                            <strong> {{ $estaValidado ? 'V' : 'NV' }} </strong>
                        </td>
                        <td>{{ $codigo }}</td>
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
