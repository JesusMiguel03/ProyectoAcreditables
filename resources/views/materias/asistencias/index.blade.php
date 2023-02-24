@extends('adminlte::page')

@section('title', 'Acreditables | Asistencias')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Asistencias</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Asistencias</x-tipografia.titulo>
@stop

@section('content')
    <div class="card col-12 table-responsive-sm p-3 mt-1 mb-3">
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
                                    <a href="{{ route('asistencias.edit', $estudiante->id) }}"
                                        class="btn btn-primary" {{ Popper::arrow()->pop('Ver') }}>
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
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('/js/tablas.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('registrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia registrada!',
                html: 'Se ha actualizado la asistencia del estudiante.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('no puede participar'))
            Swal.fire({
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
        @endif
    </script>
@stop
