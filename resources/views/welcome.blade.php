@extends('adminlte::page')

@section('title', 'Acreditables | Inicio')

@section('content_header')
    <div class="row">
        <div class="col-sm-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
            </ol>
        </div>
    </div>

    <x-tipografia.titulo>Página principal</x-tipografia.titulo>
@stop

@section('content')
    @if ($noticias->isEmpty())
        <div class="col-4 mx-auto">
            <div class="card mt-3 shadow" style="height: 17rem;">
                <div class="card-header bg-secondary">
                    <h5 class="text-center fw-bold">. . . Esperando noticias . . .</h5>
                </div>
                <div class="card-body border-bottom border-primary rounded-bottom">
                    <h6 class="mb-2 pl-3 py-1 text-muted" style="border-left: 5px solid #007bff">
                        [ Sin fecha ]
                    </h6>
                    <p class="card-text text-justify text-muted">
                        Parece que no hay novedades aún, puede que en otro momento haya alguna noticia...
                    </p>
                </div>
            </div>
        </div>
    @else
        <div id="slick" class="px-5 mb-5">
            @foreach ($noticias as $noticia)
                @if ($noticia->mostrar === 1)
                    <div class="slide">
                        <div class="card mt-3 shadow" style="height: 17rem;">
                            <img src="{{ asset('vendor/img/defecto/noticias.png') }}"
                                class="card-img-top rounded border border-outline-secondary" style="filter:brightness(0.8)"
                                alt="Imagen de noticia">
                            <h5 class="text-center py-2 text-white fw-bold"
                                style="margin-top: -5rem; z-index: 100; background-color:rgba(0, 0, 0, 0.5)">
                                {{ $noticia->encabezado }}</h5>
                            <div class="card-body border-bottom border-primary rounded-bottom">
                                <h6 class="my-3 pl-3 py-1 text-muted" style="border-left: 5px solid #007bff">
                                    [ {{ explode('-', explode(' ', $noticia->created_at)[0])[2] }}
                                    -{{ explode('-', explode(' ', $noticia->created_at)[0])[1] }}
                                    -{{ explode('-', explode(' ', $noticia->created_at)[0])[0] }} ]
                                </h6>
                                <p class="card-text text-justify">{{ $noticia->desc_noticia }}.</p>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif

    <section class="mt-4">

        <h2>Acceso rápido</h2>
        <div class="row">

            <div class="col-sm-12 col-md-4">
                <a href="{{ route('materias.index') }}" class="small-box-footer">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-th-large"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text font-weight-bold">Materias</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-12 col-md-4">
                <a href="{{ route('preguntas.index') }}" class="small-box-footer">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-question"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text font-weight-bold">Consultas</span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-12 col-md-4">
                <a href="{{ route('perfil.index') }}" class="small-box-footer">
                    <div class="info-box bg-primary">
                        <span class="info-box-icon"><i class="fas fa-cog"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text font-weight-bold">Perfil</span>
                        </div>
                    </div>
                </a>
            </div>

        </div>

    </section>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/carousel/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/carousel.css') }}">
    <style>
        .info-box:hover {
            background-color: #6c757d !important;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/carousel/slick.min.js') }}"></script>
    <script src="{{ asset('vendor/carousel/carousel.js') }}"></script>
@stop
