@section('description', 'Página de Inicio, Coordinación de Acreditables.')
@section('title', 'Inicio')

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Profesor</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                    <div class="col-sm-12 col-md-3">
                        <div class="card card-secondary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <h4 class="text-secondary">¡Bienvenido!</h4>
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('/dist/img/avatar.png') }}" alt="User profile picture">
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-9">
                        <div class="card card-secondary card-outline">
                            <div class="card-body box-profile">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="list-group" id="list-tab" role="tablist">
                                            <a class="list-group-item list-group-item-action active" id="list-home-list"
                                                data-toggle="list" href="#list-home" role="tab"
                                                aria-controls="home">¿Qué son?</a>
                                            <a class="list-group-item list-group-item-action" id="list-how-work-list"
                                                data-toggle="list" href="#list-how-work" role="tab"
                                                aria-controls="how-work">¿Cómo funcionan?</a>
                                            <a class="list-group-item list-group-item-action" id="list-study-list"
                                                data-toggle="list" href="#list-study" role="tab"
                                                aria-controls="study">¿Cómo me afectan?</a>
                                            <a class="list-group-item list-group-item-action" id="list-options-list"
                                                data-toggle="list" href="#list-options" role="tab"
                                                aria-controls="options">¿Cuales son las opciones?</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-8">
                                        <div class="tab-content text-justify" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="list-home" role="tabpanel"
                                                aria-labelledby="list-home-list">
                                                <span class="font-weight-bold">Acreditable</span> es según el Ministerio
                                                popular para la Educación universitaria como una formación con enfoque
                                                curricular asumido por los diferentes programas nacionales de formación a
                                                ser impartidos en las instituciones de educación universitaria, comprende el
                                                acercamiento de sus participantes a todas las manifestaciones artísticas y
                                                culturales, así como su riqueza.
                                            </div>
                                            <div class="tab-pane fade" id="list-study" role="tabpanel"
                                                aria-labelledby="list-study-list">
                                                Para optar por tu título de TSU debes cursar (2) acreditables en cualquiera
                                                de los
                                                (3) trimestres que componen el año académico y otras (2) acreditables para
                                                culminar
                                                la carrera.
                                            </div>
                                            <div class="tab-pane fade" id="list-options" role="tabpanel"
                                                aria-labelledby="list-options-list">
                                                Las acreditables se aperturan al inicio de cada trimestre y tienen una
                                                duración de
                                                (3) meses. Las opciones varían por trayecto.
                                                <ul class="list-group mt-3">
                                                    @foreach ($data as $el)
                                                        <a href="{{ route('cursos.show', $el['name']) }}"
                                                            class="list-group-item">{{ $el['name'] }}</a>
                                                    @endforeach
                                                    <ul>
                                            </div>
                                            <div class="tab-pane fade" id="list-how-work" role="tabpanel"
                                                aria-labelledby="list-how-work-list">
                                                Estas se consideran como cualquier otra unidad curricular, pueden ser tanto
                                                prácticas, teóricas o ambas, en base a la metodología que desee emplear el
                                                profesor encargado.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
<x-layouts.app />
