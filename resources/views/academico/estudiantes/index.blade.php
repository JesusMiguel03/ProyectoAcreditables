@extends('adminlte::page')

@section('title', 'Acreditables | Estudiantes')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Estudiantes</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de estudiantes</x-tipografia.titulo>

    {{-- Registrar usuario --}}
    <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="camporegistrar" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="camporegistrar">Registrar usuario como estudiante</h5>
                </header>

                <main class="modal-body">
                    <form action="{{ route('registrar.usuario', 'Estudiante') }}" method="post">
                        @csrf

                        <x-formularios.usuario />
                    </form>
                </main>
            </div>
        </div>
    </div>

    {{-- Comprobantes --}}
    <div class="modal fade" id="comprobantes" tabindex="-1" role="dialog" aria-labelledby="campoComprobantes"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <header class="modal-header bg-primary">
                    <h5 class="modal-title" id="campoComprobantes">Comprobantes del estudiante</h5>
                </header>

                <main class="modal-body">
                    <section id="seccionComprobantes" class="row"></section>
                </main>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="col-12 card table-responsive-sm p-3 my-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nueva estudiante') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Cédula</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>PNF</th>
                    <th>Trayecto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)

                @php
                    $CI = $usuario->nacionalidad . '-' . number_format($usuario->cedula, 0, '', '.');
                    $nombre = $usuario->nombre;
                    $apellido = $usuario->apellido;
                    $pnf = $usuario->estudiante->pnf->nom_pnf ?? 'Sin asignar';
                    $trayecto = $usuario->estudiante->trayecto->num_trayecto ?? 'Sin asignar';
                    $inscrito = $usuario->estudiante->inscrito ?? null;
                    $estudianteID = $usuario->estudiante->id ?? null;
                @endphp
                    <tr>
                        <td>{{ $CI }}</td>
                        <td>{{ $nombre }}</td>
                        <td>{{ $apellido }}</td>
                        <td>{{ $pnf }}</td>
                        <td>{{ $trayecto }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('estudiantes.edit', $usuario) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar perfil') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if (!empty($inscrito))
                                    @if (count($inscrito) === 1)
                                        <a href="{{ route('comprobante', $estudianteID) }}"
                                            class="btn btn-danger mr-2"
                                            {{ Popper::arrow()->pop('Comprobante de inscripción') }}>
                                            <i class="fas fa-file-pdf" style="width: 15px"></i>
                                        </a>
                                    @else
                                        <button class="btn btn-danger mr-2" data-listarComprobantes="true"
                                            data-estudiante="{{ $estudianteID }}"
                                            data-comprobantes="{{ count($inscrito) }}"
                                            data-toggle="modal" data-target="#comprobantes"
                                            {{ Popper::arrow()->pop('Comprobante de inscripción') }}>
                                            <i class="fas fa-file-pdf" style="width: 15px"></i>
                                        </button>
                                    @endif
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
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/listadoComprobantes.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('usuarioRegistradoEstudiante'))
            Swal.fire({
                icon: 'success',
                title: '¡Estudiante registrado!',
                html: 'Un nuevo estudiante ha sido añadido, a continuación vaya a la acción editar para asignarle su perfil académico para cursar una acreditable.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('mostrarModalUsuario'))
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
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'info',
                title: '¡Ya registrado!',
                html: 'El estudiante se encuentra registrado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('academico'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'Los datos del estudiante han sido actualizados.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @endif
    </script>
@stop
