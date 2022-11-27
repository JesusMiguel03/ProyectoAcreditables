@extends('adminlte::page')

@section('title', 'Acreditables | Trayectos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Trayecto</h1>
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
    <div class="container-fluid">

        <x-botones.volver />

        <div class="row mt-5">
            @foreach ($trayectos as $trayecto)
                <div class="col-md-3 col-sm-12">
                    <div class="card">
                        <header class="card-header bg-secondary">
                            <h4 class="text-center">Trayecto {{ $trayecto->num_trayecto }}</h4>
                        </header>
                        <footer class="card-footer">
                            <a href="{{ route('trayecto.edit', $trayecto->id) }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-edit mr-2"></i>
                                Editar
                            </a>
                        </footer>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- <div class="row mt-3">
            <div class="col-12 mt-4">
                <div class="card table-responsive-sm p-3 mb-4">
                    <table id='tabla' class="table table-striped">
                        <thead>
                            <tr class="bg-secondary">
                                <th>Trayectos</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($trayectos as $trayecto)
                                <tr>
                                    <th>{{ $trayecto->num_trayecto }}</th>
                                    <th><a href="{{ route('trayecto.edit', $trayecto->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit mr-2"></i>
                                            Editar
                                        </a>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div> --}}

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
                title: 'Trayecto registrado!',
                html: 'Ahora se podran agrupar los estudiantes.',
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
                html: 'Algo parece andar mal con los campos.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('registrada'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: 'Trayecto no disponible',
                html: 'Este trayecto ya fue registrado.',
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
                html: 'El trayecto ha sido modificado.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
