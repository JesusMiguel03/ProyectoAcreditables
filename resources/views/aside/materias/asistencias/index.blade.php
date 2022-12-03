@extends('adminlte::page')

@section('title', 'Acreditables | Asistencias')

@section('content_header')
    <div class="col-6">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
            <li class="breadcrumb-item active"><a href="">Asistencias</a></li>
        </ol>
    </div>
@stop

@section('content')
    <div class="card col-12 table-responsive-sm p-3 mt-1 mb-3">
        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cédula</th>
                    <th>Materia</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($estudiantes as $estudiante)
                    @if (!empty(Auth::user()->profesor)
                        ? Auth::user()->profesor->usuario_id === $estudiante->preinscrito->materia->info->profesor->usuario_id
                        : '')
                        <tr>
                            <td>{{ $estudiante->usuarios->nombre }}</td>
                            <td>{{ $estudiante->usuarios->apellido }}</td>
                            <td>{{ 'V-' . number_format($estudiante->usuarios->cedula, 0, ',', '.') }}</td>
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
                            <td>{{ $estudiante->usuarios->nombre }}</td>
                            <td>{{ $estudiante->usuarios->apellido }}</td>
                            <td>{{ 'V-' . number_format($estudiante->usuarios->cedula, 0, ',', '.') }}</td>
                            <td>{{ !empty($estudiante->preinscrito->materia->nom_materia) ? $estudiante->preinscrito->materia->nom_materia : 'No inscrito' }}</td>
                            <td>
                                <a href="{{ route('asistencia-ver', $estudiante->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Ver') }}>
                                    <i class="fas fa-eye"></i>
                                </a>
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
    <style>
        .form-group.required .control-label:after {
            color: #d00;
            content: "*";
            position: absolute;
            margin-left: 6px;
            margin-top: 3px;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('/js/tablas.js') }}"></script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Categoria registrada!',
                html: 'Ahora la categoria se encuentra disponible.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('existente'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Categoria existente!',
                html: 'La categoria a añadir ya se encuentra registrada.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡La categoria se ha actualizado!',
                html: 'La categoria se puede encontrar con el nuevo nombre.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Hubo un problema!',
                html: 'Parece que uno de los campos no cumple los requisitos.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
