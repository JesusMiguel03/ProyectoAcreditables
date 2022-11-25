@extends('adminlte::page')

@section('title', 'Acreditables | Especialidad')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Horario</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-3">
                    <div class="card">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#especialidad">
                            <i class="fas fa-plus mr-2"></i>
                            {{ __('Añadir especialidad') }}
                        </button>
                    </div>
                </div>
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
                                        <input type="text" name="nombre" id="nombre"
                                            class="form-control @error('nombre') is-invalid @enderror"
                                            value="{{ old('nombre') }}" placeholder="{{ __('Nombre de la especialidad') }}"
                                            autofocus>

                                        @error('nombre')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Botón de registrar --}}
                                    <div class="row">
                                        <div class="col-6">
                                            <button type="button" class="btn btn-block btn-secondary"
                                                data-dismiss="modal">{{ __('Cancelar') }}</button>
                                        </div>
                                        <div class="col-6">
                                            <button id="actualizar" class="btn btn-block btn-primary">
                                                {{ __('Guardar') }}
                                            </button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3">

                @if ($especialidades->isEmpty())
                    <div class="col-12">
                        <div class="card p-4 text-center">
                            <h2 class="text-muted">No hay datos guardados</h2>
                            <h5>Para ver información pruebe a agregar uno en el botón de "Agregar especialidad"</h5>
                        </div>
                    </div>
                @else
                    <div class="col-12 mt-4">
                        <div class="card table-responsive-sm p-3 mb-4">
                            <table id='tabla' class="table table-striped">
                                <thead>
                                    <tr class="bg-secondary">
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($especialidades as $especialidad)
                                        <tr>
                                            <th>{{ $especialidad->id }}</th>
                                            <th>{{ $especialidad->nombre }}</th>
                                            <th><a href="{{ route('especialidad.edit', $especialidad->id) }}"
                                                    class="btn btn-primary">Editar</a></th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Especialidad registrada!',
                html: 'Una nueva especialidad se puede asignar a los profesores.',
                timer: 3000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {}, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Especialidad actualizada!',
                html: 'La especialidad ahora se encuentra con otro nombre.',
                timer: 3000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {}, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            })
        @endif
    </script>
@stop
