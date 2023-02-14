<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Horario</title>

    <link rel="stylesheet" href="{{ asset('vendor/fonts/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/comprobante.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/horarios.css') }}">

    <style>
        td {
            max-width: 80px;
            max-height: 80px;
        }

        .firma::before {
            content: '';
            position: absolute;
            top: -5;
            left: 200;
            width: 400px;
            border-top: 1px solid #343a40 !important;
        }
    </style>
</head>

<body>
    <header class="encabezado">
        <img src="{{ asset('vendor/img/logo.png') }}" class="logo">

        <p class="membrete"> República Bolivariana de Venezuela </p>
        <p class="membrete"> Ministerio del Poder Popular para la Educación Universitaria </p>
        <p class="membrete"> Universidad Politécnica Territorial del Estado Aragua “Federico Brito Figueroa” </p>
        <p class="membrete"> La Victoria - Estado Aragua </p>
    </header>

    <section class="sub__encabezado">
        <h3 class="titulo">Horario de Acreditable</h3>
    </section>

    <main style="width: 100px !important">
        @php
            $horas = [['7:30', '8:15'], ['8:15', '9:00'], ['9:00', '9:50'], ['9:50', '10:35'], ['10:35', '11:25'], ['11:25', '12:10'], ['12:10', '1:00']];
        @endphp

        <table class="table table-striped table-bordered">
            <thead>
                <tr class="table-active">
                    <th class="hora align-middle">Hora</th>
                    <th class="align-middle">Lunes</th>
                    <th class="align-middle">Martes</th>
                    <th class="align-middle">Miércoles</th>
                    <th class="align-middle">Jueves</th>
                    <th class="align-middle">Viernes</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($horas as $index => $hora)
                    @php
                        $color = ['A' => 'primary', 'B' => 'success', 'C' => 'info', 'Laboratorio' => 'dark'];
                    @endphp

                    <tr>
                        <td>
                            <div class="text-center">
                                <p class="mb-n2">{{ $hora[0] }}</p>
                                <p class="mb-n1">a</p>
                                <p>{{ $hora[1] }}</p>
                            </div>
                        </td>
                        <td>
                            @foreach ($horarios as $horario)
                                @if (!empty($horario) && $horario->campo === "lu${index}")
                                    <span
                                        class="materia badge badge-{{ $color[$horario->espacio] ?? 'secondary' }}">{{ $horario->materia->nom_materia }}
                                        ({{ "$horario->espacio $horario->aula" }})
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($horarios as $horario)
                                @if (!empty($horario) && $horario->campo === "ma${index}")
                                    <span
                                        class="materia badge badge-{{ $color[$horario->espacio] ?? 'secondary' }}">{{ $horario->materia->nom_materia }}
                                        ({{ "$horario->espacio $horario->aula" }})
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($horarios as $horario)
                                @if (!empty($horario) && $horario->campo === "mi${index}")
                                    <span
                                        class="materia badge badge-{{ $color[$horario->espacio] ?? 'secondary' }}">{{ $horario->materia->nom_materia }}
                                        ({{ "$horario->espacio $horario->aula" }})
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($horarios as $horario)
                                @if (!empty($horario) && $horario->campo === "ju${index}")
                                    <span
                                        class="materia badge badge-{{ $color[$horario->espacio] ?? 'secondary' }}">{{ $horario->materia->nom_materia }}
                                        ({{ "$horario->espacio $horario->aula" }})
                                    </span>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach ($horarios as $horario)
                                @if (!empty($horario) && $horario->campo === "vi${index}")
                                    <span
                                        class="materia badge badge-{{ $color[$horario->espacio] ?? 'secondary' }}">{{ $horario->materia->nom_materia }}
                                        ({{ "$horario->espacio $horario->aula" }})
                                    </span>
                                @endif
                            @endforeach
                        </td>
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
