@extends('adminlte::page')

@section('title', 'Acreditables | Trayectos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Trayectos</a></li>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#trayecto">
                            <i class="fas fa-plus mr-2"></i>
                            {{ __('Añadir trayecto') }}
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Modal para crear --}}
            <div class="modal fade" id="trayecto" tabindex="-1" role="dialog" aria-labelledby="campotrayecto"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="campotrayecto">Agregar trayecto</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('trayecto.store') }}" method="post">
                                @csrf
            
                                {{-- Campo numero --}}
                                    <div class="form-group mb-3">
                                        <input type="number" name="numero" id="numero"
                                            class="form-control @error('numero') is-invalid @enderror" value="{{ old('numero') }}"
                                            placeholder="{{ __('Número del trayecto') }}" autofocus>
            
                                        @error('numero')
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
                                            {{ __('Añadir trayecto') }}
                                        </button>
                                    </div>
                                </div>
            
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            

            <h4 class="mt-3">Lista de Trayectos</h4>
            <div class="row mt-3">

                @if ($trayectos->isEmpty())
                    <div class="col-12">
                        <div class="card p-4 text-center">
                            <h2 class="text-muted">No hay datos guardados</h2>
                            <h5>Para ver información pruebe a agregar uno en el botón de "Añadir trayecto"</h5>
                        </div>
                    </div>
                @else
                    <div class="col-12 mt-4">
                        <div class="card table-responsive-sm p-3 mb-4">
                            <table id='tabla' class="table table-striped">
                                <thead>
                                    <tr class="bg-secondary">
                                        <th>ID</th>
                                        <th>Trayectos</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($trayectos as $trayecto)
                                        <tr>
                                            <th>{{ $trayecto->id }}</th>
                                            <th>{{ $trayecto->numero }}</th>
                                            <th width="10"><a href="{{ route('trayecto.edit', $trayecto->id) }}"
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
                title: 'Trayecto registrado!',
                html: 'Ahora se podran agrupar los estudiantes.',
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
                html: 'Algo parece andar mal con los campos.',
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
                title: 'Trayecto no disponible',
                html: 'Este trayecto ya fue registrado.',
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
                html: 'El trayecto ha sido modificado.',
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
