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
                                    <label for="num_trayecto" class="control-label">Nombre</label>
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
                    <th>Opciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($trayectos as $trayecto)
                    <tr>
                        <th>{{ $trayecto->num_trayecto }}</th>
                        <th><a href="{{ route('trayecto.edit', $trayecto->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                        </th>
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
                html: 'Ahora se podran agrupar los estudiantes.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Error de registro',
                html: 'Algo parece andar mal con los campos.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('registrada'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Trayecto no disponible',
                html: 'Este trayecto ya fue registrado.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Datos actualizados!',
                html: 'El trayecto ha sido modificado.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
