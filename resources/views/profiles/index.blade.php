@section('description', 'Página de perfil de profesores, Coordinación de Acreditables.')
@section('title', 'Profesores')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Perfiles de profesores</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="">Perfiles</a></li>
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
                    @foreach ($professors as $index => $professor)
                        <div class="col-sm-12 col-md-3 mb-3">
                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle"
                                            src="{{ asset('/dist/img/user' . ($index + 1) . '-128x128.jpg') }}"
                                            alt="User profile picture">
                                    </div>
                                    <h3 class="profile-username text-center">{{ $professor['name'] }}</h3>
                                    <p class="text-muted text-center">{{ $professor['title'] }}</p>
                                    <a href="{{ route('perfiles.show', $professor['name']) }}"
                                        class="btn btn-primary d-block">{{ $professor['name'] }}</a>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- About Me Box -->
                            <div class="card card-primary">
                                <div class="card-body">
                                    <strong><i class="fas fa-book mr-1"></i> Educación</strong>
                                    <p class="text-muted">
                                        {{ $professor['education'] }}.
                                    </p>
                                    <hr>
                                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Ubicación</strong>
                                    <p class="text-muted">{{ $professor['ubication'] }}</p>
                                    <hr>
                                    <strong><i class="fas fa-pencil-alt mr-1"></i> Habilidades</strong>
                                    <p class="text-muted">
                                        <span>{{ $professor['skills'] }}</span>
                                    </p>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    @endforeach
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
<x-layouts.app />
