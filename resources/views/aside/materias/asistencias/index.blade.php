@extends('adminlte::page')

@section('title', 'Acreditables | Asistencias')

@section('content_header')
    <div class="row">
        <div class="col-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Asistencias</a></li>
            </ol>
        </div>

        <x-tipografia.periodo fase="{{ !empty($periodo->fase) ? $periodo->fase : '' }}"
            fecha="{{ !empty($periodo->inicio) ? explode('-', explode(' ', $periodo->inicio)[0])[0] : 'Sin asignar' }}" />
    </div>

    <x-tipografia.titulo>Asistencias</x-tipografia.titulo>
@stop

@section('content')
    {{-- @dd($asistenciaEstudiantes[0]) --}}
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
                    @if (!empty(Auth::user()->profesor)
                        ? Auth::user()->profesor->usuario_id === $estudiante->preinscrito->materia->info->profesor->usuario_id
                        : '')
                        <tr>
                            @if (!empty($estudiante->preinscrito->materia->nom_materia))
                                <td
                                    class="font-weight-bold {{ $asistenciaEstudiantes[$index] < 9 ? 'text-danger' : 'text-success' }}">
                                    {{ $asistenciaEstudiantes[$index] < 9 ? 'Reprobado' : 'Aprobado' }}</td>
                                <td>{{ number_format($asistenciaEstudiantes[$index] * (100 / 12), 0, ',', '') }}</td>
                            @else
                                <td></td>
                                <td></td>
                            @endif
                            <td>{{ 'V-' . number_format($estudiante->usuarios->cedula, 0, ',', '.') }}</td>
                            <td>{{ $estudiante->usuarios->nombre }}</td>
                            <td>{{ $estudiante->usuarios->apellido }}</td>
                            <td>{{ $estudiante->preinscrito->materia->nom_materia }}</td>
                            <td>
                                <a href="{{ route('asistencia-ver', $estudiante->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Ver') }}>
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @elseif (Auth::user()->getRoleNames()[0] === 'Coordinador')
                        <tr>
                            @if (!empty($estudiante->preinscrito->materia->nom_materia))
                                <td
                                    class="font-weight-bold {{ $asistenciaEstudiantes[$index] < 9 ? 'text-danger' : 'text-success' }}">
                                    {{ $asistenciaEstudiantes[$index] < 9 ? 'Reprobado' : 'Aprobado' }}</td>
                                <td>{{ number_format($asistenciaEstudiantes[$index] * (100 / 12), 0, ',', '') }}</td>
                            @else
                                <td></td>
                                <td></td>
                            @endif
                            <td>{{ 'V-' . number_format($estudiante->usuarios->cedula, 0, ',', '.') }}</td>
                            <td>{{ $estudiante->usuarios->nombre }}</td>
                            <td>{{ $estudiante->usuarios->apellido }}</td>
                            <td
                                class="{{ !empty($estudiante->preinscrito->materia->nom_materia) ? '' : 'font-weight-bold' }}">
                                {{ !empty($estudiante->preinscrito->materia->nom_materia) ? $estudiante->preinscrito->materia->nom_materia : 'No inscrito' }}
                            </td>
                            <td>
                                @if (!empty($estudiante->preinscrito->materia->nom_materia))
                                    <a href="{{ route('asistencia-ver', $estudiante->id) }}" class="btn btn-primary"
                                        {{ Popper::arrow()->pop('Ver') }}>
                                        <i class="fas fa-eye"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('/js/tablas.js') }}"></script>
    <script>
        @if ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia registrada!',
                html: 'Se ha actualizado la asistencia del estudiante.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
