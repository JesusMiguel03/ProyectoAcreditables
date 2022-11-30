@extends('adminlte::page')

@section('title', 'Acreditables | Especialidad')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Áreas de conocimiento</a></li>
            </ol>
        </div>
        <div class="col-6">
            <div class="card float-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#especialidad">
                    <i class="fas fa-plus mr-2"></i>
                    {{ __('Añadir área de conocimiento') }}
                </button>
            </div>

            <div class="modal fade" id="especialidad" tabindex="-1" role="dialog" aria-labelledby="campoespecialidad"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <header class="modal-header bg-primary">
                            <h5 class="modal-title" id="campoespecialidad">Agregar área de conocimiento</h5>
                        </header>
                        <main class="modal-body">
                            <form action="{{ route('especialidad.store') }}" method="POST">
                                @csrf

                                {{-- Campo de nombre --}}
                                <div class="form-group required mb-3">
                                    <label for="nom_especialidad" class="control-label">Nombre</label>
                                    <input type="text" name="nom_especialidad" id="nom_especialidad"
                                        class="form-control @error('nom_especialidad') is-invalid @enderror"
                                        value="{{ old('nom_especialidad') }}"
                                        placeholder="{{ __('Nombre del área') }}" autofocus required>

                                    @error('nom_especialidad')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Campo de descripción --}}
                                <div class="form-group required mb-3">
                                    <label for="desc_especialidad" class="control-label">Descripción</label>
                                    <textarea name="desc_especialidad" class="form-control @error('desc_especialidad') is-invalid @enderror"
                                        placeholder="{{ __('Descripción') }}" autofocus style="min-height: 9rem; resize: none" required>{{ old('desc_especialidad') }}</textarea>

                                    @error('desc_especialidad')
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
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($especialidades as $especialidad)
                    <tr>
                        <th>{{ $especialidad->nom_especialidad }}</th>
                        <th>{{ $especialidad->desc_especialidad }}</th>
                        <th><a href="{{ route('especialidad.edit', $especialidad->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit mr-2"></i>
                                Editar
                            </a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
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
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script>
        @if ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: 'Registro exitoso!',
                html: 'Una nueva área de conocimiento se puede asignar a los profesores.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: 'Registro actualizado!',
                html: 'El área de conocimiento ahora se encuentra con otro nombre.',
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
