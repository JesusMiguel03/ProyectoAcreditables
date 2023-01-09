@extends('adminlte::page')

@section('title', 'Acreditables | Estudiantes')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Estudiantes</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de estudiantes</x-tipografia.titulo>

    @can('registrar')
        {{-- Registrar usuario --}}
        <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="camporegistrar" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="camporegistrar">Registrar usuario como estudiante</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('estudiante.store') }}" method="post">
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
                @foreach ($estudiantes as $estudiante)
                    <tr>
                        <td>{{ 'V-' . number_format($estudiante->cedula, 0, ',', '.') }}</td>
                        <td>{{ $estudiante->nombre }}</td>
                        <td>{{ $estudiante->apellido }}</td>
                        <td>
                            {{ !empty($estudiante->estudiante->pnf) ? $estudiante->estudiante->pnf->nom_pnf : 'Sin asignar' }}
                        </td>
                        <td>
                            {{ !empty($estudiante->estudiante->trayecto) ? $estudiante->estudiante->trayecto->num_trayecto : 'Sin asignar' }}
                        </td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('estudiantes.edit', $estudiante) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar perfil') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                @if (!empty($estudiante->inscrito))
                                    <a href="{{ route('comprobante', $estudiante->id) }}" class="btn btn-danger mr-2"
                                        {{ Popper::arrow()->pop('Comprobante de inscripción') }}>
                                        <i class="fas fa-file-pdf" style="width: 15px"></i>
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
    <link rel="stylesheet" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Estudiante registrado!',
                html: 'Un nuevo estudiante ha sido añadido.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Error al registrar',
                html: 'Uno de los parámetros parece estar mal.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'info',
                title: 'Ya fue registrado',
                html: 'El estudiante ya se encuentra registrado.',
                confirmButtonColor: '#17a2b8',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('academico'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'Los datos del estudiante han sido actualizados.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
