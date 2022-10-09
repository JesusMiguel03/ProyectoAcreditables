@section('description', 'Página de Cursos, Coordinación de Acreditables.')
@section('title', 'Cursos')

@section('links')
    {{-- Slick CSS --}}
    <link rel="stylesheet" href="{{ asset('/assets/carousel/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('/assets/carousel/carousel.css') }}">
@endsection

@section('content')
    {{-- Page top --}}
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Coordinación de Acreditables</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="cursos">Cursos</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Page content --}}
        <section class="content">
            <div class="container-fluid">
                <div id="slick" class="px-5">
                    @foreach ($courses as $index => $course)
                        <div class="slide">
                            <div class="card mt-3">
                                <img src="{{ asset('/assets/img/banners/img' . $index . '.png') }}" class="card-img-top rounded"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title mb-2 h2 fw-bold">{{ $course['name'] }}</h5>
                                    <h6 class="card-text text-secondary">Cupos disponibles:
                                        <span class="text-primary">{{ $course['quotes'] }}
                                        </span>
                                    </h6>
                                    <p class="card-text text-truncate">{{ $course['description'] }}</p>
                                    <a href="{{ route('cursos.show', $course['name']) }}"
                                        class="btn btn-primary d-block">Ver curso</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
@endsection

@section('scripts')
    {{-- Slick jQuery --}}
    <script src="{{ asset('/assets/carousel/slick.min.js') }}"></script>
    <script src="{{ asset('/assets/carousel/carousel.js') }}"></script>
@endsection

<x-layouts.app />
