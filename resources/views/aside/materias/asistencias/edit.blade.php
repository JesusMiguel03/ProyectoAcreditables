@extends('adminlte::page')

@section('title', 'Acreditables | Asistencia')

@section('content_header')
    <div class="col-6">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('asistencia') }}" class="link-muted">Asistencias</a></li>
            <li class="breadcrumb-item active"><a href="">{{ $estudiante->usuarios->nombre }}
                    {{ $estudiante->usuarios->apellido }}</a></li>
        </ol>
    </div>

    <x-tipografia.titulo>Asistencias</x-tipografia.titulo>
@stop

@section('content')
    <div class="card col-12 table-responsive-sm p-3 mt-1 mb-3">
        <form action="{{ route('asistencia-actualizar') }}" method="post">
            @csrf

            <input type="text" name="id" value="{{ $estudiante->id }}" class="d-none" hidden>

            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Semana</th>
                        @for ($i = 1; $i <= 12; $i++)
                            <th>{{ $i }}</th>
                        @endfor
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Presente</td>
                        @for ($i = 1; $i <= 12; $i++)
                            @php($sem = 'sem' . $i)
                            <td>
                                <div class="icheck-primary">
                                    <input type="checkbox" name="{{ $sem }}" id="{{ $sem }}"
                                        {{ $estudiante->asistencia->$sem === 1 ? 'checked' : '' }}>

                                    <label for="{{ $sem }}">
                                        {{ __('') }}
                                    </label>
                                </div>
                            </td>
                        @endfor
                    </tr>
                </tbody>
            </table>

            <div class="row">
                <div class="col-6">
                    <p>
                        Lleva un <span
                            class="font-weight-bold text-info">{{ number_format($asistencias * (100 / 12), 0, ',', '.') }}%</span>
                        / <span class="font-weight-bold text-info">75%</span> de asistencia para aprobar la acreditable.
                    </p>
                    <p>
                        Estado: <span
                            class="font-weight-bold {{ $asistencias < 9 ? 'text-danger' : 'text-success' }}">{{ $asistencias < 9 ? 'reprobado por inasistencias' : 'aprobado' }}</span>
                    </p>
                </div>

                <div class="col-6">
                    <button type="submit" class="btn btn-success float-right px-5 ml-3"
                        {{ Popper::arrow()->size('large')->pop('Si ha guardado debe hacer clic 2 veces en volver para ir a esa vista, caso contrario solo 1') }}>
                        <i class="fas fa-save mr-2"></i>
                        Guardar
                    </button>
                    <a onclick="history.back()" class="btn btn-secondary float-right px-5">
                        <i class="fas fa-arrow-circle-left mr-2"></i>
                        Volver
                    </a>
                </div>
            </div>

        </form>
    </div>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Asistencia registrada!',
                html: 'La asistencia del estudiante ha sido actualizada.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
