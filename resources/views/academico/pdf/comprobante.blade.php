    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        {{-- Base Meta Tags --}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Comprobante de Inscripción</title>

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

        <div class="col-12">
            <header class="text-center mt-2 mb-2">
                <h6 style="font-size: 1.1rem; font-weight: 400">República Bolivariana de Venezuela</h6>
                <h6 style="font-size: 1.1rem; font-weight: 400">
                    Ministerio del Poder Popular para la Educación Universitaria
                </h6>
                <h6 style="font-size: 1.1rem; font-weight: 400">
                    Universidad Politécnica Territorial del Estado Aragua “Federico Brito Figueroa”
                </h6>
                <h6 style="font-size: 1.1rem; font-weight: 400">La Victoria - Estado Aragua</h6>
                <h6 class="my-5" style="font-size: 2rem">Comprobante de Inscripción</h6>
            </header>

            <main class="px-5">
                @php
                    $nombreEstudiante = datosUsuario($estudiante, 'EstudianteInscrito', 'nombreCompleto');
                    $CI = datosUsuario($estudiante, 'EstudianteInscrito', 'CI');
                    $pnf = datosUsuario($estudiante, 'EstudianteInscrito', 'pnfNombre');
                    $trayecto = datosUsuario($estudiante, 'EstudianteInscrito', 'trayectoNumero');
                    $profesor = materia($materia, 'profesor') ?? 'Sin asignar';
                    $codigoEstudiante = datosUsuario($estudiante, 'Estudiante', 'codigo');
                    $fecha = \Carbon\Carbon::parse($estudiante->created_at)->locale('es')->isoFormat('ll');
                @endphp

                <h6 style="font-size: 1.1rem">Datos del estudiante</h6>

                <table>
                    <tbody>
                        <tr>
                            {{-- Nombre y apellido --}}
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Estudiante
                                </h6>
                            </th>
                            <th style="padding-left: 9rem">
                                <h6 style="font-size: 1.1rem; font-weight: 400;">
                                    {{ $nombreEstudiante }}
                                </h6>
                            </th>
                        </tr>

                        {{-- Cédula --}}
                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Cédula
                                </h6>
                            </th>
                            <td style="padding-left: 9rem">
                                <h6 style="font-size: 1.1rem; font-weight: 400;">
                                    {{ $CI }}
                                </h6>
                            </td>
                        </tr>

                        {{-- Datos académicos --}}
                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    PNF
                                </h6>
                            </th>
                            <td style="padding-left: 9rem">
                                <h6 style="font-size: 1.1rem; font-weight: 400;">
                                    {{ $pnf }}
                                </h6>
                            </td>
                        </tr>

                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Trayecto
                                </h6>
                            </th>
                            <td style="padding-left: 9rem">
                                <h6 style="font-size: 1.1rem; font-weight: 400;">
                                    {{ $trayecto }}
                                </h6>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h6 style="margin-top: 3rem; font-size: 1.1rem">Datos de inscripción</h6>

                <table>
                    <tbody>
                        {{-- Nombre de la acreditable --}}
                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Acreditable
                                </h6>
                            </th>
                            <td>
                                <h6 style="font-weight: 400;">
                                    {{ $materia->nom_materia }}
                                </h6>
                            </td>
                        </tr>

                        {{-- Quien la dicta --}}
                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Encargado
                                </h6>
                            </th>
                            <td>
                                <h6
                                    style="{{ !empty(materia($materia, 'tieneProf')) ? 'font-weight: 400' : 'font-weight: 700' }}">
                                    {{ $profesor }}
                                </h6>
                            </td>
                        </tr>

                        {{-- Código de validación --}}
                        <tr>
                            <th width="14rem" style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Código de validación
                                </h6>
                            </th>
                            <td>
                                <h6 style="font-weight: 400;">
                                    {{ $codigoEstudiante }}
                                </h6>
                            </td>
                        </tr>

                        {{-- Período --}}
                        <tr>
                            <th width="14rem" style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Período académico
                                </h6>
                            </th>
                            <td>
                                <h6 style="font-weight: 400;">
                                    {{ periodo() ?? 'No definido' }}
                                </h6>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </main>

            <footer class="mt-5 px-5">
                <h6 class="font-weight-bold" style="font-size: 1rem;">
                    Notas importantes
                </h6>

                <div class="row px-5">
                    @if (!empty(datosUsuario($estudiante, 'EstudianteInscrito', 'profEncargado')))
                        <h6 class="text-justify" style="font-weight: 400; font-size: 0.9rem"> Este comprobante certifica
                            al estudiante <span class="font-weight-bold">
                                {{ $nombreEstudiante }}, </span> cédula <span
                                class="font-weight-bold">
                                {{ $CI }} </span> de haber solicitado una
                            inscripción en la acreditable de <span
                                class="font-weight-bold">{{ $materia->nom_materia }}</span> el día <span
                                class="font-weight-bold">{{ $fecha }}</span>,
                            para la formación integral del participante dentro de la institución.
                        </h6>
                        <h6 class="mt-4 text-justify" style="font-weight: 400; font-size: 0.9rem">
                            Para la validación de este comprobante, llevarse a la coordinación de Acreditables para ser
                            firmado y avalado.
                        </h6>
                    @else
                        <h6 class="text-justify" style="font-weight: 700; font-size: 0.9rem">
                            Por la ausencia de un encargado capacitado para dictar esta acreditable, este comprobante
                            queda invalidado indefinidamente hasta que un profesor sea asignado a la materia.
                        </h6>
                    @endif
                </div>

                <div class="row my-5 pt-5 text-center" style="padding: 2rem 8rem 0">
                    @if (!empty(datosUsuario($estudiante, 'Estudiante', 'profEncargado')))
                        <h4 class="px-5 pt-4 border-top border-dark" style="width: 80%">Firma del Coordinador de
                            Acreditables</h4>
                    @endif
                </div>
            </footer>
        </div>

    </body>

    </html>
