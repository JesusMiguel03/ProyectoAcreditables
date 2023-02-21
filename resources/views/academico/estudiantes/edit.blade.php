@extends('adminlte::page')

@section('title', 'Acreditables | Editar estudiante')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('estudiantes.index') }}" class="link-muted">Estudiantes</a></li>
    <li class="breadcrumb-item active"><a href="">{{ $usuario->nombre }} {{ $usuario->apellido }}</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de estudiantes</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <section class="card">
            <header class="card-header bg-primary">
                <h5>Editar credenciales</h5>
            </header>

            <main class="card-body">

                <x-formularios.editar-estudiante :usuario="$usuario" :trayectos="$trayectos" :pnfs="$pnfs" :pnfsNoDisponibles="$pnfsNoDisponibles" />
            </main>
        </section>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>
        @if ($message = session('pnfLimite'))
            Swal.fire({
                icon: 'info',
                title: '¡Hubo un problema!',
                html: "{{ session('pnfLimite') }}",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @endif
    </script>
@stop
