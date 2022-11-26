@extends('adminlte::page')

@section('title', 'Acreditables | PNF')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Listado de PNF</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">PNF</a></li>
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
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pnf">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Añadir pnf') }}
                    </button>
                </div>
            </div>

            <x-botones.volver />
        </div>

        {{-- Modal para crear --}}
        <div class="modal fade" id="pnf" tabindex="-1" role="dialog" aria-labelledby="campopnf" aria-hidden="true">
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
                                <input type="text" name="nom_pnf" id="nom_pnf"
                                    class="form-control @error('nom_pnf') is-invalid @enderror" value="{{ old('nom_pnf') }}"
                                    placeholder="{{ __('Nombre del pnf') }}" autofocus>

                                @error('nom_pnf')
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

        <div class="row mt-3">
            <div class="col-12 mt-4">
                <div class="card table-responsive-sm p-3 mb-4">
                    <table id='tabla' class="table table-striped">
                        <thead>
                            <tr class="bg-secondary">
                                <th>Nombre</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($pnfs as $pnf)
                                <tr>
                                    <th>{{ $pnf->nom_pnf }}</th>
                                    <th><a href="{{ route('pnf.edit', $pnf->id) }}" class="btn btn-primary">Editar</a>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>
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
                title: '¡PNF registrado!',
                html: 'Ya se puede seleccionar este PNF.',
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
                html: 'Uno de los parámetros parece estar mal, has clic en el boton de añadir para ver el campo incorrecto.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('registrada'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'PNF no disponible',
                html: 'Parece que el PNF a asignar ya se encuentra registrado.',
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
                html: 'El PNF ahora posee otro nombre.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
