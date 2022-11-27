@extends('adminlte::page')

@section('title', 'Acreditables | Inicio')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Inicio</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="container-fluid">

        @if ($noticias->isEmpty())
            <div class="col-4 mx-auto">
                <div class="card mt-3 shadow" style="height: 17rem;">
                    <div class="card-header bg-secondary">
                        <h5 class="text-center fw-bold">. . . Esperando noticias . . .</h5>
                    </div>
                    <div class="card-body border-bottom border-primary">
                        <h6 class="mb-2 pl-3 py-1 text-muted" style="border-left: 5px solid #007bff">
                            [ Sin fecha ]
                        </h6>
                        <p class="card-text text-justify">Parece que no han añadidos ninguna noticia, aviso o notificación, puede que en otro momento lo hagan...</p>
                    </div>
                </div>
            </div>
        @else
            <div id="slick" class="px-5 mb-5">
                @foreach ($noticias as $noticia)
                    @if ($noticia->mostrar === 1)
                        <div class="slide">
                            <div class="card mt-3 shadow" style="height: 17rem;">
                                <div class="card-header bg-secondary">
                                    <h5 class="text-center fw-bold">{{ $noticia->encabezado }}</h5>
                                </div>
                                <div class="card-body border-bottom border-primary">
                                    <h6 class="mb-2 pl-3 py-1 text-muted" style="border-left: 5px solid #007bff">
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

    </div>
@stop

@section('footer')

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
    {{-- Para limitar la longitud del texto a ver --}}
    {{-- <script>
        // Paragraph max length
        const truncate = 170
        const cards = document.querySelectorAll('.card-text')
        cards.forEach(card => {
            card.innerText.length >= truncate ?
                card.innerText = `${card.innerText.slice(0, truncate - 20)}...` :
                window.innerWidth < 400 ? card.innerText = `${card.innerText.slice(0, truncate - 60)}...` : ""
        })
    </script> --}}
@stop
