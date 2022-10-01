@section('description', 'Página de Cursos, Coordinación de Acreditables.')
@section('title', 'Cursos')
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
                    @for ($i = 0; $i < 7; $i++)
                        <div class="slide">
                            <div class="card mt-3">
                                <img src="/img/banners/img{{ $i }}.png" class="card-img-top rounded" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Curso X</h5>
                                    <p class="card-text">Aprende a (--- x ---).</p>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

<x-layouts.app />

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
<!-- Slick CSS -->
<link href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" rel="stylesheet" />
<!-- Slick jQuery min -->
<script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
<link rel="stylesheet" href="{{ asset('/carousel.css') }}">
<script src="{{ asset('/carousel.js') }}"></script>
