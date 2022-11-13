@extends('adminlte::page')

@section('title', 'Acreditables | Inicio')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div id="slick" class="px-5 mb-5">
                <div class="slide">
                    <div class="card mt-3 text-black" style="height: 17rem;">
                        <div class="card-body">
                            <h5 class="text-center fw-bold">¡Curso añadido!</h5>
                            <h6 class="text-muted">[Panaderia]</h6>
                            <p class="card-text text-justify">Ahora el curso de Panaderia se encuentra disponible para
                                todos los estudiantes pertenecientes al trayecto 2.</p>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('Cursos.show', 1) }}">Ver curso</a>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <div class="card mt-3" style="height: 17rem;">
                        <div class="card-body">
                            <h5 class="text-center fw-bold">¡Comunicado!</h5>
                            <h6 class="mb-2 text-muted">[09-11-2022]</h6>
                            <p class="card-text text-justify">Se prevee para la próxima semana, el día martes, se añadan
                                nuevos cursos prácticos, que sean de provecho para toda la comunidad estudiantil.</p>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <div class="card mt-3" style="height: 17rem;">
                        <div class="card-body">
                            <h5 class="text-center fw-bold">¡Posibles Cambios!</h5>
                            <h6 class="mb-2 text-muted">[09-11-2022]</h6>
                            <p class="card-text text-justify">En vista de la gran demanda que han tenido los cursos de:
                                <strong>Ajedrez y Fútbol</strong>, se plantea aumentar los cupos disponibles para el
                                siguiente trimestre.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <div class="card mt-3" style="height: 17rem;">
                        <div class="card-body">
                            <h5 class="text-center fw-bold">¡Aviso!</h5>
                            <h6 class="mb-2 text-muted">[10-11-2022]</h6>
                            <p class="card-text text-justify">Por temas personales los encargados de las acreditables de:
                                <strong>Primeros Auxilios y Baloncesto</strong> no podrán asistir a la universidad
                                durante la semana del 14-11 al 18-11.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="slide">
                    <div class="card mt-3" style="height: 17rem;">
                        <div class="card-body">
                            <h5 class="text-center fw-bold">¡Curso no disponible!</h5>
                            <h6 class="mb-2 text-muted">[11-11-2022]</h6>
                            <p class="card-text text-justify">El facilitador encargado del curso de
                                <strong>Coral</strong> que nos acompañó este periodo académico 2021-2022 no
                                podrá apoyarnos a causa de problemas de salud, esperamos se recupere pronto.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <section class="container mt-4">
                <h2>Enlaces Directos:</h2>
                <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <a href="{{ route('Cursos.index') }}" class="small-box-footer">
                            <div class="info-box bg-secondary">
                                <span class="info-box-icon"><i class="fas fa-th-large"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Cursos</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <a href="{{ route('faq') }}" class="small-box-footer">
                            <div class="info-box bg-secondary">
                                <span class="info-box-icon"><i class="fas fa-question"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Consultas</span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-3">
                        <a href="user/profile" class="small-box-footer">
                            <div class="info-box bg-secondary">
                                <span class="info-box-icon"><i class="fas fa-cog"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Perfil</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </section>
        </div>
    </section>
@stop

@section('footer')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/carousel/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/carousel.css') }}">
    <style>
        .info-box:hover {
            background-color: #007bff!important;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/carousel/slick.min.js') }}"></script>
    <script src="{{ asset('vendor/carousel/carousel.js') }}"></script>
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
