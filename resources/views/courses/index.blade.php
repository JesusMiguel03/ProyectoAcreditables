@extends('adminlte::page')

@section('title', 'Acreditables | Cursos')

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
    {{-- Page content --}}
    <a href="{{ route('Cursos.create') }}" class="btn btn-primary">Crear cursos</a>
    <section class="content">
        <div class="container-fluid">

            <div id="slick" class="px-5">
                @foreach ($courses as $course)
                    <div class="slide">
                        <div class="card mt-3">
                            <img src="{{ asset('storage/' . $course['image']) }}" class="card-img-top rounded"
                                alt="...">
                            <div class="card-body">
                                <h5 class="card-title mb-2 h2 fw-bold">{{ $course['name'] }}</h5>
                                <h6 class="card-text text-secondary">Cupos disponibles:
                                    <span class="text-primary">{{ $course['quotas_available'] }}
                                    </span>
                                </h6>
                                <p class="card-text text-truncate">{{ $course['description'] }}</p>
                                <a href="{{ route('Cursos.show', $course['id']) }}" class="btn btn-primary d-block">
                                    Ver curso
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@stop

@section('footer')

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/carousel/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <style>
        .card-img-top {
            max-height: 9rem;
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('vendor/carousel/slick.min.js') }}"></script>
    <script src="{{ asset('vendor/carousel/carousel.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        document.querySelectorAll('p').forEach(item => {
            item.innerText === 'Cursos' ?
                item.parentNode.classList.add('active') : ""
        })
    </script>
    <script>
        @if ($message = session('update'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Cambio exitoso!',
                html: 'Curso editado correctamente.',
                timer: 3000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {}, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            })
        @elseif ($message = session('create'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Curso añadido!',
                html: 'Curso creado correctamente.',
                timer: 3000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {}, 100)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
            })
        @endif
    </script>
@stop
