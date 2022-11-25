@extends('adminlte::page')

@section('title', 'Acreditables | Noticias')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Noticias</a></li>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#noticia">
                            <i class="fas fa-plus mr-2"></i>
                            {{ __('Añadir noticia') }}
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="noticia" tabindex="-1" role="dialog" aria-labelledby="camponoticia"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="camponoticia">Nueva noticia</h5>
                        </div>
                        <div class="modal-body">
                            <div class="label-group mb-3">
                                <form action="{{ route('noticias.store') }}" method="post">
                                    @csrf

                                    {{-- Campo de encabezado --}}
                                    <div class="input-group mb-3">
                                        <input type="text" name="encabezado" id="encabezado"
                                            class="form-control @error('encabezado') is-invalid @enderror"
                                            value="{{ old('encabezado') }}" placeholder="{{ __('Nombre de la noticia') }}"
                                            autofocus>

                                        @error('encabezado')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Campo de descripcion --}}
                                    <div class="input-group mb-3">
                                        <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" placeholder="{{ __('Descripción') }}" autofocus
                                            style="min-height: 9rem; resize: none">{{ old('descripcion') }}</textarea>

                                        @error('descripcion')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Campo para mostrar o no la noticia --}}
                                    <div class="input-group mb-3">
                                        <select name="mostrar" class="form-control">
                                            <option>¿Desea mostrar la noticia?</option>
                                            <option value="1">Si</option>
                                            <option value="0">No</option>
                                        </select>

                                        @error('mostrar')
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
                                            <button id="actualizar" class="btn btn-block btn-success">
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

                @if ($noticias->isEmpty())
                    <div class="col-12">
                        <div class="card p-4 text-center">
                            <h2 class="text-muted">No hay datos guardados</h2>
                            <h5>Para ver información pruebe a agregar uno en el botón de "Agregar noticia"</h5>
                        </div>
                    </div>
                @else
                    <div class="col-12 mt-4">
                        <div class="card table-responsive-sm p-3 mb-4">
                            <table id='tabla' class="table table-striped">
                                <thead>
                                    <tr class="bg-secondary">
                                        <th>ID</th>
                                        <th>Encabezado</th>
                                        <th>Descripcion</th>
                                        <th>Estado</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($noticias as $noticia)
                                        <tr>
                                            <th>{{ $noticia->id }}</th>
                                            <th>{{ $noticia->encabezado }}</th>
                                            <th>{{ $noticia->descripcion }}</th>
                                            <th>{{ $noticia->mostrar === 0 ? 'Inactivo' : 'Activo' }}</th>
                                            <th><a href="{{ route('noticias.edit', $noticia->id) }}"
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
                title: '¡Noticia registrada!',
                html: 'Una nueva noticia aparecera en la vista de estudiante.',
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
                title: '¡Noticia actualizada!',
                html: 'La noticia ha cambiado sus datos.',
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
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Noticia no guardada!',
                html: 'Uno de los campos es incorrecto, verifique que los campos cumplan las condiciones.',
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
