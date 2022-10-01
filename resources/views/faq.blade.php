@section('description', 'Página de preguntas frecuentes, Coordinación de Acreditables.')
@section('title', 'Preguntas frecuentes')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Preguntas Frecuentes</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="">Preguntas Frecuentes</a></li>
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
                    <div class="col-12">
                        <div class="card card-info card-outline">
                            <div class="card-body box-profile">
                                <div class="row">
                                    <div class="col-sm-12 col-md-4">
                                        <div class="list-group" id="list-tab" role="tablist">
                                            <a class="list-group-item list-group-item-action active" id="option-1-list"
                                                data-toggle="list" href="#option-1" role="tab"
                                                aria-controls="home">Opción 1</a>
                                            <a class="list-group-item list-group-item-action" id="option-4-list"
                                                data-toggle="list" href="#option-4" role="tab"
                                                aria-controls="how-work">Opción 2</a>
                                            <a class="list-group-item list-group-item-action" id="option-2-list"
                                                data-toggle="list" href="#option-2" role="tab"
                                                aria-controls="study">Opción 3</a>
                                            <a class="list-group-item list-group-item-action" id="option-3-list"
                                                data-toggle="list" href="#option-3" role="tab"
                                                aria-controls="options">Opción 4</a>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-8">
                                        <div class="tab-content text-justify" id="nav-tabContent">
                                            <div class="tab-pane fade show active" id="option-1" role="tabpanel"
                                                aria-labelledby="option-1-list">
                                                Lorem ipsum 1
                                            </div>
                                            <div class="tab-pane fade" id="option-2" role="tabpanel"
                                                arial-labelledby="option-2-list">
                                                Lorem ipsum 2
                                            </div>
                                            <div class="tab-pane fade" id="option-3" role="tabpanel"
                                                aria-labelledby="option-3-list">
                                                Lorem ipsum 3
                                            </div>
                                            <div class="tab-pane fade" id="option-4" role="tabpanel"
                                                aria-labelledby="option-4-list">
                                                Lorem ipsum 4
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
