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
            <li class="breadcrumb-item active"><a href="">Cursos</a></li>
        </ol>
    </div>
</div>
@stop

@section('content')

@dd($course)
    
    {{-- Page content --}}
    {{-- @dd($courses['name']) --}}
    <section class="content">
        <div class="container-fluid">
            <div id="slick" class="px-5">
                    <div class="slide">
                        <div class="card mt-3">
                            <img src="{{ asset('/assets/img/banners/img' . $course['name'] . '.png') }}" class="card-img-top rounded"
                                alt="...">
                            <div class="card-body">
                                <h5 class="card-title mb-2 h2 fw-bold">{{ $course['name'] }}</h5>
                                <h6 class="card-text text-secondary">Cupos disponibles:
                                    <span class="text-primary">{{ $course['quotes'] }}
                                    </span>
                                </h6>
                                <p class="card-text text-truncate">{{ $course['description'] }}</p>
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