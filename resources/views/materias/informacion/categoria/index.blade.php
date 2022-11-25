@extends('adminlte::page')

@section('title', 'Acreditables | Categoria')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Categorias</a></li>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#categoria">
                            <i class="fas fa-plus mr-2"></i>
                            {{ __('Añadir categoria') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- Modal para crear --}}
            <div class="modal fade" id="categoria" tabindex="-1" role="dialog" aria-labelledby="campoCategoria"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="campoCategoria">Agregar categoria</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('categoria.store') }}" method="post">
                                @csrf

                                {{-- Campo de nombre --}}
                                <div class="input-group mb-3">
                                    <input type="text" name="nom_categoria" id="nom_categoria"
                                        class="form-control @error('nom_categoria') is-invalid @enderror"
                                        value="{{ old('nom_categoria') }}"
                                        placeholder="{{ __('Nombre de la categoria de curso') }}" autofocus>

                                    @error('nom_categoria')
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

            <h4 class="mt-3">Lista de Categorias</h4>
            <div class="row mt-3">

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
                                @foreach ($categorias as $categoria)
                                    <tr>
                                        <th>{{ $categoria->id }}</th>
                                        <th>{{ $categoria->nom_categoria }}</th>
                                        <th><a href="{{ route('categoria.edit', $categoria->id) }}"
                                                class="btn btn-primary">Editar</a></th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </section>
@stop

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
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
                title: '¡Categoria de curso registrada!',
                html: 'Ahora la categoria de curso se encuentra disponible.',
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
                title: '¡Categoria de curso existente!',
                html: 'La categoria de curso a añadir ya se encuentra registrada.',
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
                title: '¡La categoria de curso se ha actualizado!',
                html: 'La categoria de curso se puede encontrar con el nuevo nombre.',
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
