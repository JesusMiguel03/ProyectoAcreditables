@extends('adminlte::page')

@section('title', 'Acreditables | Noticias')

@section('content_header')
    <div class="row">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Noticias</a></li>
            </ol>
        </div>
        <div class="col-6">
            @can('noticias.create')
                <div class="card float-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#noticia">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Añadir noticia') }}
                    </button>
                </div>

                <div class="modal fade" id="noticia" tabindex="-1" role="dialog" aria-labelledby="camponoticia"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <header class="modal-header bg-primary">
                                <h5 class="modal-title" id="camponoticia">Nueva noticia</h5>
                            </header>
                            <main class="modal-body">
                                <div class="label-group mb-3">
                                    <form action="{{ route('noticias.store') }}" method="post">
                                        @csrf

                                        {{-- Campo de encabezado --}}
                                        <div class="form-group required mb-3">
                                            <label for="encabezado" class="control-label">Encabezado</label>
                                            <input type="text" name="encabezado" id="encabezado"
                                                class="form-control @error('encabezado') is-invalid @enderror"
                                                value="{{ old('encabezado') }}" placeholder="{{ __('Nombre de la noticia') }}"
                                                autofocus required>

                                            @error('encabezado')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Campo de descripcion --}}
                                        <div class="form-group required mb-3">
                                            <label for="desc_noticia" class="control-label">Descripción</label>
                                            <textarea name="desc_noticia" class="form-control @error('desc_noticia') is-invalid @enderror"
                                                placeholder="{{ __('Descripción') }}" autofocus style="min-height: 9rem; resize: none" required>{{ old('desc_noticia') }}</textarea>

                                            @error('desc_noticia')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Campo para mostrar o no la noticia --}}
                                        <div class="form-group required mb-3">
                                            <label for="mostrar" class="control-label">¿Mostrar noticia?</label>
                                            <select name="mostrar" class="form-control @error('mostrar') is-invalid @enderror">
                                                <option disabled>¿Desea mostrar la noticia?</option>
                                                <option value="1">Si</option>
                                                <option value="0">No</option>
                                            </select>

                                            @error('mostrar')
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
        <div class="col-12 mt-4">
            <div class="card table-responsive-sm p-3 mb-4">
                <table id='tabla' class="table table-striped">
                    <thead>
                        <tr class="bg-secondary">
                            <th>Encabezado</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($noticias as $noticia)
                            <tr>
                                <th>{{ $noticia->encabezado }}</th>
                                <th>{{ $noticia->desc_noticia }}</th>
                                <th>{{ $noticia->mostrar === 0 ? 'Inactivo' : 'Activo' }}</th>
                                <th><a href="{{ route('noticias.edit', $noticia->id) }}" class="btn btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </th>
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
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}">
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
                title: '¡Noticia registrada!',
                html: 'Una nueva noticia aparecera en la vista de estudiante.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Noticia actualizada!',
                html: 'La noticia ha cambiado sus datos.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Noticia no guardada!',
                html: 'Uno de los campos es incorrecto, verifique que los campos cumplan las condiciones.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
