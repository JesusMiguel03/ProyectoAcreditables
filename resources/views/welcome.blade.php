@extends('adminlte::page')

@section('title', 'Acreditables | Inicio')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Página principal</x-tipografia.titulo>
@stop

@section('content')
    @if ($noticias->isEmpty())
        <x-elementos.noticia />
    @else
        <div id="slick" class="px-5 mb-5">
            @foreach ($noticias as $noticia)
                @if ($loop->index < config('variables.carrusel'))
                    <x-elementos.noticia :noticia="$noticia" />
                @endif
            @endforeach
        </div>
    @endif

    <x-elementos.acceso-directo />
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/carousel/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/carousel.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/noticia.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/carousel/slick.min.js') }}"></script>
    <script src="{{ asset('vendor/carousel/carousel.js') }}"></script>
@stop
