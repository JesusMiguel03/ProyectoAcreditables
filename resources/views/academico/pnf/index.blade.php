@extends('adminlte::page')

@section('title', 'Acreditables | Pnf')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Pnf's</a></li>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pnf">
                            <i class="fas fa-plus mr-2"></i>
                            {{ __('Añadir pnf') }}
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Modal para crear --}}
            <div class="modal fade" id="pnf" tabindex="-1" role="dialog" aria-labelledby="campopnf"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="campopnf">Agregar pnf</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('pnf.store') }}" method="post">
                                @csrf
            
                                {{-- Campo nombre --}}
                                    <div class="form-group mb-3">
                                        <input type="text" name="nombre" id="nombre"
                                            class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                                            placeholder="{{ __('Nombre del pnf') }}" autofocus>
            
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
                                            {{ __('Añadir pnf') }}
                                        </button>
                                    </div>
                                </div>
            
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <h4 class="mt-3">Lista de Pnf's</h4>
            <div class="row mt-3">

                @if ($pnfs->isEmpty())
                    <div class="col-12">
                        <div class="card p-4 text-center">
                            <h2 class="text-muted">No hay datos guardados</h2>
                            <h5>Para ver información pruebe a agregar uno en el botón de "Añadir pnf"</h5>
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
                                    @foreach ($pnfs as $pnf)
                                        <tr>
                                            <th>{{ $pnf->id }}</th>
                                            <th>{{ $pnf->nombre }}</th>
                                            <th><a href="{{ route('pnf.edit', $pnf->id) }}"
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
                title: '¡Aula registrada!',
                html: 'Ya se puede dictar un curso en esa aula.',
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
                title: 'Error de registro',
                html: 'Uno de los parámetros parece estar mal, has clic en el boton "Gestionar aula" para ver el campo incorrecto.',
                timer: 5000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {}, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            })
        @elseif ($message = session('registrada'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Aula no disponible',
                html: 'Parece que el aula a asignar ya se encuentra registrada.',
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
                title: '¡Datos actualizados!',
                html: 'El aula ahora se encuentra en un edificio o número diferente.',
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
