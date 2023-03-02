@extends('adminlte::page')

@section('title', 'Acreditables | Editar categoria')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}" class="link-muted">Categorias</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Categorías</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar categoria</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('categorias.update', $categoria) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.categorias :nombre="$categoria->nom_categoria" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    {{-- <script src="{{ asset('js/mensajeMostrarLimite.js') }}"></script> --}}
@stop
