@extends('adminlte::page')

@section('title', 'Acreditables | Trayectos')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Trayectos</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Trayectos</x-tipografia.titulo>

    @can('academico')
        {{-- Modal para crear --}}
        <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="campotrayecto" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="campotrayecto">Agregar trayecto</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('trayectos.store') }}" method="post">
                            @csrf

                            <div class="form-group required mb-3">
                                <label for="num_trayecto" class="control-label">Número</label>
                                <div class="input-group">
                                    <input type="number" name="num_trayecto" id="num_trayecto"
                                        class="form-control @error('num_trayecto') is-invalid @enderror"
                                        value="{{ old('num_trayecto') }}" placeholder="{{ __('Número del trayecto') }}"
                                        autofocus required>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-sort-numeric-down"></span>
                                        </div>
                                    </div>

                                    @error('num_trayecto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <x-modal.mensaje-obligatorio />

                            {{-- Botón de registrar --}}
                            <x-modal.footer-aceptar />

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
                    {{ Popper::arrow()->pop('Nuevo trayecto') }}>
                    <i class="fas fa-plus mr-2"></i>
                    {{ 'Añadir' }}
                </button>
            </div>
        </div>

        <table id='tabla' class="table table-striped">
            <thead>
                <tr class="bg-secondary">
                    <th>Trayectos</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($trayectos as $trayecto)
                    <tr>
                        <td>{{ $trayecto->num_trayecto }}</td>
                        <td>
                            <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                <a href="{{ route('trayectos.edit', $trayecto->id) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Editar') }}>
                                    <i class="fas fa-edit"></i>
                                </a>

                                <button id="{{ $trayecto->id }}" class="btn btn-danger borrar"
                                    {{ Popper::arrow()->pop('Borrar') }} data-type="Trayecto"
                                    data-name="{{ $trayecto->num_trayecto }}">
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

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('js/borrar.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: 'Trayecto registrado!',
                html: 'Un nuevo trayecto ha sido añadido.',
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
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El trayecto ha sido actualizado.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('borrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Trayecto borrado exitosamente!',
                html: 'El trayecto ha sido borrado.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'info',
                title: 'Ya fue registrado',
                html: 'El trayecto ya se encuentra registrado.',
                confirmButtonColor: '#17a2b8',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
            $('#registrar').modal('show')
        @elseif ($message = session('no encontrado'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Trayecto no encontrado!',
                html: 'El trayecto que desea buscar o editar no se encuentra disponible.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
