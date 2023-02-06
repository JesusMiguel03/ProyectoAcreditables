<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Comprobante de Inscripción</title>

    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/comprobante.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
</head>

<body>
    <header class="encabezado">
        <img src="{{ asset('vendor/img/logo.png') }}" class="logo">

        <p class="membrete"> República Bolivariana de Venezuela </p>
        <p class="membrete"> Ministerio del Poder Popular para la Educación Universitaria </p>
        <p class="membrete"> Universidad Politécnica Territorial del Estado Aragua “Federico Brito Figueroa” </p>
        <p class="membrete"> La Victoria - Estado Aragua </p>

        <h2 class="titulo">Comprobante de Inscripción</h6>
    </header>

    <main class="informacion">
        @php
            $nombreEstudiante = datosUsuario($estudiante, 'EstudianteInscrito', 'nombreCompleto');
            $CI = datosUsuario($estudiante, 'EstudianteInscrito', 'CI');
            $pnf = datosUsuario($estudiante, 'EstudianteInscrito', 'pnfNombre');
            $trayecto = datosUsuario($estudiante, 'EstudianteInscrito', 'trayectoNumero');
            $profesor = materia($materia, 'profesor') ?? 'Sin asignar';
            $codigoEstudiante = datosUsuario($estudiante, 'EstudianteInscrito', 'codigo');
            $fecha = \Carbon\Carbon::parse($estudiante->created_at)
                ->locale('es')
                ->isoFormat('ll');
        @endphp

        {{-- Perfil estudiante --}}
        <section>
            <header class="nombre__seccion">
                <h5>Datos del estudiante</h5>
            </header>

            <main class="datos__estudiante">
                <table class="table table-borderless">
                    <tbody>
                        <tr class="fila table-active">
                            <td class="celda-vacia-izq"></td>
                            <td class="celda__titulo"> Estudiante </td>
                            <td> {{ $nombreEstudiante }} </td>
                            <td class="celda-vacia-izq"></td>
                        </tr>
                        <tr class="table-active">
                            <td class="celda-vacia-izq"></td>
                            <td class="celda__titulo"> Cédula </td>
                            <td> {{ $CI }} </td>
                            <td class="celda-vacia-izq"></td>
                        </tr>
                        <tr class="table-active">
                            <td class="celda-vacia-izq"></td>
                            <td class="celda__titulo"> PNF </td>
                            <td> {{ $pnf }} </td>
                            <td class="celda-vacia-izq"></td>
                        </tr>
                        <tr class="table-active">
                            <td class="celda-vacia-izq"></td>
                            <td class="celda__titulo"> Trayecto </td>
                            <td> {{ $trayecto }} </td>
                            <td class="celda-vacia-izq"></td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </section>

        {{-- Inscripción --}}
        <section>
            <header class="nombre__seccion">
                <h5>Datos de inscripción</h5>
            </header>

            <main class="datos__inscripcion">
                <table class="table table-borderless">
                    <tbody>
                        <tr class="fila table-active">
                            <td class="celda-vacia-izq"></td>
                            <td class="celda__titulo"> Acreditable </td>
                            <td> {{ $materia->nom_materia }} </td>
                            <td class="celda-vacia-der"></td>
                        </tr>
                        <tr class="table-active">
                            <td class="celda-vacia-izq"></td>
                            <td class="celda__titulo"> Encargado </td>
                            <td class="{{ $profesor === 'Sin asignar' ? 'text-danger negrita' : '' }}">
                                {{ $profesor }}
                            </td>
                            <td class="celda-vacia-der"></td>
                        </tr>
                        <tr class="table-active">
                            <td class="celda-vacia-izq"></td>
                            <td class="celda__titulo"> Código de validación </td>
                            <td> {{ $codigoEstudiante }} </td>
                            <td class="celda-vacia-der"></td>
                        </tr>
                        <tr class="table-active">
                            <td class="celda-vacia-izq"></td>
                            <td class="celda__titulo"> Período académico </td>
                            <td> {{ periodo() ?? 'No definido' }} </td>
                            <td class="celda-vacia-der"></td>
                        </tr>
                    </tbody>
                </table>
            </main>
        </section>
    </main>

    <footer class="nota">
        <h6 class="nota__titulo"> Notas importantes </h6>

        <section class="nota__mensaje">
            @if (!empty(datosUsuario($estudiante, 'EstudianteInscrito', 'profEncargado')))
                <p class="nota_1">
                    Este comprobante certifica al estudiante
                    <span class="negrita">{{ $nombreEstudiante }}</span>, cédula
                    <span class="negrita">{{ $CI }}</span> de haber solicitado una
                    inscripción en la acreditable de
                    <span class="negrita">{{ $materia->nom_materia }}</span>
                    el día
                    <span class="negrita">{{ $fecha }}</span>,
                    para la formación integral del participante dentro de la institución.
                </p>
                <p class="nota_2">
                    Para la validación de este comprobante, llevarse a la coordinación de Acreditables para ser
                    firmado y avalado.
                </p>
            @else
                <p>
                    Este comprobante requiere de una actualización de estatus de encargado para ratificar la inscripción del estudiante.
                </p>
            @endif
        </section>

        <section class="firma__area">
            <h6 class="firma">
                Firma Coordinador de Acreditables
            </h6>
        </section>
    </footer>

</body>

</html>
