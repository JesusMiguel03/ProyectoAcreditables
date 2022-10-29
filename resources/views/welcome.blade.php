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
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body" style="height: 21.7rem;">
                            <div class="text-center">
                                <h3>¡Curso de Panadería añadido!</h3>
                                <img class="img-fluid rounded" src="{{ asset('vendor/img/banners/Panaderia.png') }}" alt="Imágen de Panadería">
                                <a href="/Cursos/Panadería"
                                    class="btn btn-primary d-block mt-3 font-weight-bold">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body" style="height: 21.7rem;">
                            <div>
                                <h3 class="text-center">¡Comunicado!</h3>
                                <p class="text-justify">Se prevee para la próxima semana, el día martes, se añadan
                                    nuevos cursos prácticos, que sean de provecho para toda la comunidad estudiantil.</p>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body" style="height: 21.7rem;">
                            <div>
                                <h3 class="text-center">¡Posibles cambios!</h3>
                                <p class="text-justify">En vista de la gran demanda que han tenido los cursos de:
                                    <strong>Ajedrez y Fútbol</strong>, se plantea aumentar los cupos disponibles para el
                                    siguiente trimestre.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div style="height: 13rem;">
                                <h3 class="text-center">¡Aviso!</h3>
                                <p class="text-justify">Por temas personales los encargados de las acreditables de:
                                    <strong>Primeros Auxilios y Baloncesto</strong> no podrán asistir a la universidad
                                    durante la semana del 27-09 al 08-10.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div style="height: 13rem;">
                                <h3 class="text-center">¡Curso no disponible!</h3>
                                <p class="text-justify">El facilitador encargado previamente del curso de
                                    <strong>Coral</strong> que nos acompañó durante este periodo académico 2021-2022 no
                                    podrá apoyarnos durante el siguiente trimestre a causa de problemas de salud,
                                    esperamos se recupere pronto y el estudiantado pueda optar por otros cursos
                                    disponibles.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('footer')

@section('css')
@stop

@section('js')
@stop
