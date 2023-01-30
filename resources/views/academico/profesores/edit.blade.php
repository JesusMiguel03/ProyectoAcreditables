@extends('adminlte::page')

@section('title', 'Acreditables | Profesores')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('profesores.index') }}" class="link-muted">Profesores</a></li>
    <li class="breadcrumb-item active">
        <a href="">
            {{ datosUsuario($profesor, 'Profesor', 'nombreCompleto') }}
        </a>
    </li>
@stop

@section('content_header')
    <x-tipografia.titulo>Listado de profesores</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar perfil de profesor</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('profesores.update', $profesor->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.registrar-profesor :profesor="$profesor" :activo="datosUsuario($profesor, 'Profesor', 'activo')" :departamentos="$departamentos"
                        :conocimientos="$conocimientos" />

                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    {{-- <script src="{{ asset('js/mensajeMostrarLimite.js') }}"></script> --}}
@stop
