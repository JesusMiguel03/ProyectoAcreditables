@extends('adminlte::page')

@section('title', 'Acreditables | ¿Sabías que?')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Preguntas frecuentes</a></li>
            </ol>
        </div>
        <div class="col-6">
            @can('preguntas.create')
                <div class="card float-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pregunta">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Añadir pregunta') }}
                    </button>
                </div>

                <div class="modal fade" id="pregunta" tabindex="-1" role="dialog" aria-labelledby="campopregunta"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <header class="modal-header bg-primary">
                                <h5 class="modal-title" id="campopregunta">Nueva pregunta</h5>
                            </header>

                            <main class="modal-body">
                                <div class="label-group mb-3">
                                    <form action="{{ route('preguntas.store') }}" method="post">
                                        @csrf

                                        {{-- Campo de nombre --}}
                                        <div class="form-group required mb-3">
                                            <label for="titulo" class="control-label">Pregunta</label>
                                            <input type="text" name="titulo" id="titulo"
                                                class="form-control @error('titulo') is-invalid @enderror"
                                                value="{{ old('titulo') }}"
                                                placeholder="{{ __('Titulo de la pregunta sin signos') }}" autofocus required>

                                            @error('titulo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Campo de nombre --}}
                                        <div class="form-group required mb-3">
                                            <label for="explicacion" class="control-label">Respuesta</label>
                                            <textarea name="explicacion" class="form-control @error('explicacion') is-invalid @enderror"
                                                placeholder="{{ __('Explicacion de la pregunta') }}" autofocus style="min-height: 9rem; resize: none" required>{{ old('explicacion') }}</textarea>

                                            @error('explicacion')
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
                                </div>
                            </main>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        @if (Auth::user()->getRoleNames()[0] !== 'Coordinador')
            <div class="col-sm-12 col-md-3">
                <div class="card">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <h4 class="text-secondary">¡Bienvenido!</h4>
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('vendor/img/users/avatar.png') }}" alt="User profile picture">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-9">
                <div class="card">
                    <div class="card-body" style="height: 11rem">
                        <div class="text-center">
                            <h4>Responderé a tus posibles dudas</h4>
                            <p class="text-justify">A continuación tendrás una lista de opciones donde consideramos
                                aquellas preguntas que son muy frecuentes o pueden ser algo complicadas de entender y
                                las explicamos lo más práctico y sencillo posible, esperamos aclare todas tus dudas 😅
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- Preguntas --}}
        @if (Auth::user()->getRoleNames()[0] === 'Coordinador')
            <div class="col-12">
                <div class="card table-responsive-sm p-3 my-3">
                    <table id='tabla' class="table table-striped">
                        <thead>
                            <tr class="bg-secondary">
                                <th>Pregunta</th>
                                <th>Respuesta</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($preguntas as $pregunta)
                                <tr>
                                    <td>{{ $pregunta->titulo }}</td>
                                    <td>{{ $pregunta->explicacion }}</td>
                                    <td><a href="{{ route('preguntas.edit', $pregunta->id) }}" class="btn btn-primary" {{ Popper::arrow()->pop('Editar') }}>
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row" id="accordion">
                                    @foreach ($preguntas as $pregunta)
                                        <div class="col-4">

                                            <div class="card">

                                                <div class="card-header bg-secondary" id="{{ $pregunta->id }}">
                                                    <button class="btn btn-block text-left" data-toggle="collapse"
                                                        data-target="#colapsar-{{ $pregunta->id }}" aria-expanded="true"
                                                        aria-controls="colapsar-{{ $pregunta->id }}">
                                                        <h5 class="mb-0 text-white">
                                                            <strong>{{ $pregunta->titulo }}</strong>
                                                        </h5>
                                                    </button>
                                                </div>

                                                <div id="colapsar-{{ $pregunta->id }}"
                                                    class="collapse {{ $loop->first ? ' show' : '' }}"
                                                    aria-labelledby="{{ $pregunta->id }}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        {{ $pregunta->explicacion }}
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
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
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: 'Pregunta registrada!',
                html: 'Una nueva pregunta ha sido añadido.',
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
            $('#pregunta').modal('show')
        @elseif ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'info',
                title: 'Ya fue registrado',
                html: 'La pregunta ya se encuentra registrada.',
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
                html: 'La pregunta ha sido actualizada.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
