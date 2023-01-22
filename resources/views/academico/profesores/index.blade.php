@extends('adminlte::page')

@section('title', 'Acreditables | Profesores')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Profesores</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de profesores</x-tipografia.titulo>

    @can('registrar')
        {{-- Perfil de profesor --}}
        <div class="modal fade" id="profesor" tabindex="-1" role="dialog" aria-labelledby="campoprofesor" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="campoprofesor">Asignar profesor</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('profesores.store') }}" method="post">
                            @csrf

                            <x-formularios.registrar-profesor :usuarios="$usuarios" :departamentos="$departamentos" :conocimientos="$conocimientos" />
                        </form>
                    </main>
                </div>
            </div>
        </div>

        {{-- Registrar usuario --}}
        <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="camporegistrar"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="camporegistrar">Registrar usuario como profesor</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('registrar.usuario', 'Profesor') }}" method="post">
                            @csrf

                            <x-formularios.usuario />
                        </form>
                    </main>
                </div>
            </div>
        </div>
    @endcan
@stop

@section('content')
    <div class="col-12 card table-responsive-sm p-3 mb-3">

        <div class="w-100 row mx-auto">
            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                    {{ Popper::arrow()->pop('Nuevo usuario') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Usuario' }}
                </button>
            </div>

            <div class="col-md-2 col">
                <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#profesor"
                    {{ Popper::arrow()->pop('Registrar usuario como profesor') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Profesor' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th {{ Popper::arrow()->pop('Cédula') }}>CI</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th {{ Popper::arrow()->pop('Área de conocimiento') }}>Conocimiento</th>
                    <th {{ Popper::arrow()->pop('Teléfono') }}>Tlf.</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profesores as $profesor)
                    <tr>
                        <td>{{ datosUsuario($profesor, 'Profesor', 'CI') }}</td>
                        <td>{{ datosUsuario($profesor, 'Profesor', 'nombre') }}</td>
                        <td>{{ datosUsuario($profesor, 'Profesor', 'apellido') }}</td>
                        <td>{{ datosUsuario($profesor, 'Profesor', 'conocimiento') }}</td>
                        <td>{{ datosUsuario($profesor, 'Profesor', 'tlf') }}</td>
                        <td>{{ datosUsuario($profesor, 'Profesor', 'activo') === 1 ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('profesores.edit', $profesor) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('profesores.show', $profesor) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Ver perfil') }}>
                                    <i class="fas fa-eye"></i>
                                </a>
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
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/input.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $(function() {
            $('#fecha_nacimiento').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
        $(function() {
            $('#fecha_ingreso').datetimepicker({
                format: 'YYYY-MM-DD'
            });
        });
    </script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/mensajeMostrarLimite.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Profesor registado!',
                html: 'Un nuevo perfil de profesor ha sido añadido.',
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
            $('#profesor').modal('show')
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
                html: 'El profesor ya se encuentra registrado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('usuarioRegistradoProfesor'))
            Swal.fire({
                icon: 'success',
                title: '¡Usuario registrado!',
                html: 'Un perfil de profesor ha sido registrado, para completar su perfil académico vaya al botón "Profesor".',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'Los datos del profesor han sido actualizados.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'info',
                title: '¡Ya registrado!',
                html: 'El usuario ya se encuentra registrado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Usuario no encontrado!',
                html: 'El usuario que desea buscar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @endif
    </script>
@stop
