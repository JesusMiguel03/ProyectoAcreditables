@extends('adminlte::page')

@section('title', 'Acreditables | Editar pregunta')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('preguntas.index') }}" class="link-muted">Preguntas frecuentes</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Preguntas frecuentes</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Cambiar datos</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('preguntas.update', $pregunta->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.preguntas :pregunta="$pregunta->titulo" :descripcion="$pregunta->explicacion" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
@stop

@section('js')
    {{-- <script src="{{ asset('js/mensajeMostrarLimite.js') }}"></script> --}}
@stop
