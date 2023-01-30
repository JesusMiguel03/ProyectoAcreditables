@extends('adminlte::page')

@section('title', 'Acreditables | Horarios')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Horarios</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Horarios</x-tipografia.titulo>

    @can('academico')
        {{-- Modal para crear --}}
        <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="campohora" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="campohora">Agregar hora</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('horarios.store') }}" method="post">
                            @csrf

                            <x-formularios.horarios />
                        </form>
                    </main>
                </div>
            </div>
        </div>

        <x-formularios.borrar />
    @endcan
@stop

@section('content')
    <div class="card table-responsive-sm p-3 mb-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nuevo horario') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Espacio</th>
                    <th>Edificio número</th>
                    <th>Día</th>
                    <th>Hora</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($horarios as $horario)
                    <tr>
                        <td>{{ $horario->espacio }}</td>
                        <td>{{ $horario->edificio }}</td>
                        <td>{{ diaSemana($horario->dia) }}</td>
                        <td>{{ \Carbon\Carbon::parse($horario->hora)->format('g:i A') }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('horarios.edit', $horario->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button id="{{ $horario->id }}" class="btn btn-danger borrar"
                                    {{ Popper::arrow()->pop('Borrar') }} data-type="Horario"
                                    data-name="{{ $horario->espacio }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $(function() {
            $('#hora').datetimepicker({
                format: 'h:mm a'
            });
        });
    </script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/borrar.js') }}"></script>
    {{-- <script src="{{ asset('js/mensajeMostrarLimite.js') }}"></script> --}}

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Hora registrada!',
                html: 'Una nueva hora ha sido añadida.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al registrar!',
                html: 'Uno de los parámetros parece estar mal.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El horario ha sido actualizado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('borrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Hora borrada!',
                html: 'La hora ha sido borrada exitosamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'info',
                title: '¡Ya registrada!',
                html: 'La hora se encuentra registrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Hora no encontrada!',
                html: 'La hora que desea buscar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @endif
    </script>
@stop
