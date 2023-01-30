@extends('adminlte::page')

@section('title', 'Acreditables | Editar noticia')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}" class="link-muted">Noticias</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Noticias</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar noticia</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('noticias.update', $noticia) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.noticias :noticia="$noticia" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buscar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
@stop

@section('js')
    <script src="{{ asset('js/previsualizacion.js') }}"></script>
    {{-- <script src="{{ asset('js/mensajeMostrarLimite.js') }}"></script> --}}
@stop
