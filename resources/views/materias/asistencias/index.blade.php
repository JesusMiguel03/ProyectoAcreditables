@extends('adminlte::page')

@section('title', 'Acreditables | Asistencias')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>

    @if (Route::is('asistencias.show'))
        <li class="breadcrumb-item"><a href="{{ route('asistencias.index') }}" class="link-muted">Asistencias</a></li>
        <li class="breadcrumb-item active"><a href="">Periodo {{ $periodoSeleccionado->formato() }}</a></li>
    @else
        <li class="breadcrumb-item active"><a href="">Asistencias</a></li>
    @endif
@stop

@section('content_header')
    <x-tipografia.titulo>Asistencias</x-tipografia.titulo>
@stop

@section('content')
    <div class="card col-12 table-responsive-sm p-3 mt-1 mb-3">

        <div class="col-6 mb-4">
            <form id="form" action="" method="get">
                @csrf

                <div class="form-row">
                    <label for="periodo">Periodo</label>
                </div>

                <div class="form-row">
                    <div class="col">
                        <select id="periodo" name="perido" class="form-control">
                            <option value="0" readonly>Seleccione uno...</option>

                            @if (Route::is('asistencias.show'))
                                @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->id }}"
                                        {{ $periodoSeleccionado->id === $periodo->id ? 'selected' : '' }}>
                                        {{ $periodo->formato() }}</option>
                                @endforeach
                            @else
                                @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->id }}">
                                        {{ $periodo->formato() }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col">
                        <button id="enviar" class="btn btn-block btn-primary" disabled>Buscar</button>
                    </div>
                </div>

            </form>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Asistencia</th>
                    <th>%</th>
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Materia</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($estudiantes as $index => $estudiante)
                    @php
                        $acreditable = $estudiante->inscritoAcreditable('nro');
                        $inscrito = $estudiante->materia->nom_materia ?? null;
                    @endphp
                    <tr>
                        @if (!empty($inscrito))
                            <td
                                class="font-weight-bold {{ $asistenciaEstudiantes[$index] < 9 ? 'text-danger' : 'text-success' }}">
                                {{ $asistenciaEstudiantes[$index] < 9 ? 'Reprobado' : 'Aprobado' }}
                            </td>
                            <td>{{ number_format($asistenciaEstudiantes[$index] * (100 / 12), 0, ',', '') }}</td>
                        @else
                            <td></td>
                            <td></td>
                        @endif
                        <td>{{ $estudiante->inscritoCI() }}</td>
                        <td>{{ $estudiante->inscritoSoloNombre() }}</td>
                        <td>{{ $estudiante->inscritoSoloApellido() }}</td>
                        <td class="{{ !empty($inscrito) ? '' : 'font-weight-bold' }}">
                            {{ !empty($inscrito) ? "(#A{$acreditable}) {$inscrito}" : 'No inscrito' }}
                        </td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                @if (!empty($inscrito))
                                    <a href="{{ route('asistencias.edit', $estudiante->id) }}" class="btn btn-primary"
                                        {{ Popper::arrow()->pop('Ver') }}>
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('/js/tablas.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const inputPeriodos = document.getElementById('periodo');
        const boton = document.getElementById('enviar')
        const form = document.getElementById('form')

        const url = "{{ route('asistencias.show') }}"

        let periodo = inputPeriodos.options[inputPeriodos.selectedIndex].value || 0;
        let periodoSeleccionado = inputPeriodos.options[inputPeriodos.selectedIndex].value

        // Cuando se selecciona un periodo x
        inputPeriodos.addEventListener('change', (e) => {
            periodo = e.currentTarget.options[inputPeriodos.selectedIndex].value;

            // Si es valido o mayor a 0 se puede buscar
            periodo > 0 && periodo !== periodoSeleccionado ?
                boton.removeAttribute('disabled') :
                boton.disabled = true
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault()

            // Si el periodo es mayor a 0 busca el historial por periodo
            if (periodo > 0 && periodo !== periodoSeleccionado) {
                form.action = `${url}/${periodo}`
                form.submit()
            }
        })
    </script>

    {{-- Mensajes --}}
    <script>
        @if (session('registrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia registrada!',
                html: 'Se ha actualizado la asistencia del estudiante.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif (session('no puede participar'))
            Swal.fire({
                width: '40rem',
                icon: 'warning',
                title: '¡No puede cursar!',
                @if (rol('Coordinador'))
                    html: 'Este estudiante no se encuentra validado, en caso de que haya traído su comprobante por favor valídelo en la lista, hasta entonces no podrá tener asistencia o lo que es igual, no contará la acreditable.',
                @else
                    html: 'Este estudiante no se encuentra validado, para validarse debe llevar su respectivo comprobante a la Coordinación de Acreditables para ser firmado, hasta entonces no podrá tener asistencia o lo que es igual, no contará la acreditable.',
                @endif
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
        @elseif (session('asistencia'))
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia actualizada!',
                html: "{{ session('asistencia') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @endif
    </script>
@stop
