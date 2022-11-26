@extends('adminlte::page')

@section('title', 'Acreditables | Especialidad')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Especialidad</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Especialidad</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="card">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#especialidad">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Añadir especialidad') }}
                    </button>
                </div>
            </div>

            <x-botones.volver />
        </div>

        <div class="modal fade" id="especialidad" tabindex="-1" role="dialog" aria-labelledby="campoespecialidad"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="campoespecialidad">Asignar hora disponible</h5>
                    </div>
                    <div class="modal-body">
                        <div class="label-group mb-3">
                            <form action="{{ route('especialidad.store') }}" method="post">
                                @csrf

                                {{-- Campo de nombre --}}
                                <div class="input-group mb-3">
                                    <input type="text" name="nom_especialidad" id="nom_especialidad"
                                        class="form-control @error('nom_especialidad') is-invalid @enderror"
                                        value="{{ old('nom_especialidad') }}" placeholder="{{ __('Nombre de la especialidad') }}"
                                        autofocus>

                                    @error('nom_especialidad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Botón de registrar --}}
                                <div class="row">
                                    <x-botones.cancelar />

                                    <x-botones.guardar />
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">

            <div class="col-12 card table-responsive-sm p-3 mb-4">
                <table id='tabla' class="table table-striped">
                    <thead>
                        <tr class="bg-secondary">
                            <th>Nombre</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($especialidades as $especialidad)
                            <tr>
                                <th>{{ $especialidad->nom_especialidad }}</th>
                                <th><a href="{{ route('especialidad.edit', $especialidad->id) }}"
                                        class="btn btn-primary">Editar</a></th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Especialidad registrada!',
                html: 'Una nueva especialidad se puede asignar a los profesores.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Especialidad actualizada!',
                html: 'La especialidad ahora se encuentra con otro nombre.',
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
