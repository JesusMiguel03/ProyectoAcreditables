@section('description', 'Página de Cursos, Coordinación de Acreditables.')
@section('title', 'Cursos')

@section('links')
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <!-- Slick CSS -->
    <link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('/carousel/carousel.css') }}">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Cursos</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="cursos">Cursos</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div id="slick" class="px-5">
                    @foreach ($courses as $index => $course)
                        <div class="slide">
                            <div class="card mt-3">
                                <img src="{{ asset('/img/banners/img'.$index.'.png') }}" class="card-img-top rounded"
                                    alt="...">
                                <div class="card-body">
                                    <h5 class="card-title mb-2 h2 fw-bold">{{ $course['name'] }}</h5>
                                    <h6 class="card-text text-secondary">Cupos disponibles:
                                        <span class="text-primary">{{ $course['quotes'] }}
                                        </span>
                                    </h6>
                                    <p class="card-text text-truncate">{{ $course['description'] }}</p>
                                    <a href="{{ route('cursos.show', $course['name']) }}" class="btn btn-primary d-block">Ver curso</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('scripts')
    <!-- Slick jQuery min -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('/carousel/carousel.js') }}"></script>
@endsection

<x-layouts.app />
