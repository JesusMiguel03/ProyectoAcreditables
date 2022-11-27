    <!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        {{-- Base Meta Tags --}}
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

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

    <body style="background: url({{ asset('vendor/img/comprobante.png') }}) no-repeat fixed 50% 50%; background-color: rgba(255, 255, 255, 0.6); background-blend-mode: lighten; font-family: 'Times New Roman'">

        <div class="col-12">
            <header class="text-center mt-2 mb-2">
                <h6 style="font-size: 1.1rem; font-weight: 400">República Bolivariana de Venezuela</h6>
                <h6 style="font-size: 1.1rem; font-weight: 400">Ministerio del Poder Popular para la Educación Universitaria</h6>
                <h6 style="font-size: 1.1rem; font-weight: 400">Universidad Politécnica Territorial del Estado Aragua “Federico Brito Figueroa”</h6>
                <h6 style="font-size: 1.1rem; font-weight: 400">La Victoria - Estado Aragua</h6>

                <h6 class="my-5" style="font-size: 2rem">Comprobante de Preinscripción</h6>
            </header>

            <main class="px-5">

                <h6 style="font-size: 1.1rem">Datos del estudiante</h6>

                <table>
                    <tbody>
                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Estudiante
                                </h6>
                            </th>
                            <th style="padding-left: 1rem">
                                <h6 style="font-size: 1.1rem; font-weight: 400;">
                                    {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}
                                </h6>
                            </th>
                        </tr>
                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Cédula
                                </h6>
                            </th>
                            <td style="padding-left: 1rem">
                                <h6 style="font-size: 1.1rem; font-weight: 400;">
                                    {{ number_format(Auth::user()->cedula, 0, ',', '.') }}
                                </h6>
                            </td>
                        </tr>
                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    PNF
                                </h6>
                            </th>
                            <td style="padding-left: 1rem">
                                <h6 style="font-size: 1.1rem; font-weight: 400;">
                                    {{ Auth::user()->estudiante->pnf->nom_pnf }}
                                </h6>
                            </td>
                        </tr>
                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Trayecto
                                </h6>
                            </th>
                            <td style="padding-left: 1rem">
                                <h6 style="font-size: 1.1rem; font-weight: 400;">
                                    {{ Auth::user()->estudiante->trayecto->num_trayecto }}
                                </h6>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <h6 style="margin-top: 3rem; font-size: 1.1rem">Datos de preinscripción</h6>

                <table>
                    <tbody>
                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Acreditable
                                </h6>
                            </th>
                            <td>
                                <h6 style="font-weight: 400;">
                                {{ Auth::user()->estudiante->preinscrito->materia->nom_materia }}</td>
                            </h6>
                        </tr>
                        <tr>
                            <th style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Encargado
                                </h6>
                            </th>
                            <td>
                                <h6 style="font-weight: 400;">
                                    {{ Auth::user()->estudiante->preinscrito->materia->info->profesor->usuario->nombre }}
                                    {{ Auth::user()->estudiante->preinscrito->materia->info->profesor->usuario->apellido }}
                                </h6>
                            </td>
                        </tr>
                        <tr>
                            <th width="14rem" style="padding-left: 3rem">
                                <h6 style="font-size: 1.1rem">
                                    Código de validación
                                </h6>
                            </th>
                            <td>
                                <h6 style="font-weight: 400;">
                                    {{ Auth::user()->estudiante->preinscrito->codigo }}
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
                    <h6 class="text-justify" style="font-weight: 400; font-size: 0.9rem">
                        Este comprobante certifica al estudiante <span
                            class="text-dark font-weight-bold">{{ Auth::user()->nombre }}
                            {{ Auth::user()->apellido }},</span>
                        cédula <span
                            class="text-dark font-weight-bold">{{ number_format(Auth::user()->cedula, 0, ',', '.') }}</span>
                        de
                        haber solicitado
                        una preinscripción en la acreditable de <span
                            class="text-dark font-weight-bold">{{ Auth::user()->estudiante->preinscrito->materia->nom_materia }}</span>
                        el día 23 de octubre de 2022, para la formación integral del participante dentro de la
                        institución.
                    </h6>
                    <h6 class="mt-4 text-justify" style="font-weight: 400; font-size: 0.9rem">
                        Para la validación de este comprobante, llevarse a la coordinación de Acreditables para ser
                        firmado y avalado.
                    </h6>
                </div>

                <div class="row my-5 pt-5 text-center" style="padding: 2rem 8rem 0">
                    <h4 class="px-5 pt-4 border-top border-dark" style="width: 80%">Firma del Coordinador de Acreditables</h4>
                </div>
            </footer>
        </div>

    </body>

    </html>
