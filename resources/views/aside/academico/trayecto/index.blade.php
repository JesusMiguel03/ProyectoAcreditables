@extends('adminlte::page')

@section('title', 'Acreditables | Trayectos')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Trayectos</a></li>
            </ol>
        </div>
        <div class="col-6">
            <div class="card float-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#trayecto">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Añadir trayecto') }}
                </button>
            </div>

            {{-- Modal para crear --}}
            <div class="modal fade" id="trayecto" tabindex="-1" role="dialog" aria-labelledby="campotrayecto"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <header class="modal-header bg-primary">
                            <h5 class="modal-title" id="campotrayecto">Agregar trayecto</h5>
                        </header>
                        <main class="modal-body">
                            <form action="{{ route('trayecto.store') }}" method="post">
                                @csrf

                                {{-- Campo de nombre --}}
                                <div class="form-group required mb-3">
                                    <label for="num_trayecto" class="control-label">Número</label>
                                    <input type="number" name="num_trayecto" id="num_trayecto"
                                        class="form-control @error('num_trayecto') is-invalid @enderror"
                                        value="{{ old('num_trayecto') }}" placeholder="{{ __('Número del trayecto') }}"
                                        autofocus required>

                                    @error('num_trayecto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group" style="margin-bottom: -10px">
                                    <p class="pl-2 text-danger"><strong>Nota:</strong> (*) Indica los campos que
                                        son obligatorios.
                                    </p>
                                </div>

                                {{-- Botón de registrar --}}
                                <div class="row">
                                    <x-botones.cancelar />

                                    <x-botones.guardar />
                                </div>

                            </form>
                        </main>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card table-responsive-sm p-3 mb-3">
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
                        <td><a href="{{ route('trayecto.edit', $trayecto->id) }}" class="btn btn-primary" {{ Popper::arrow()->pop('Editar') }}>
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
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
            $('#trayecto').modal('show')
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
        @endif
    </script>
@stop
