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
                <li class="breadcrumb-item active"><a href="{{ route('Cursos.index') }}">Cursos</a></li>
                <li class="breadcrumb-item active"><a href="">{{ $course['name'] }}</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- Course card --}}
                <div class="col-sm-12 col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    {{-- src="{{ asset('/vendor/img/profs/user' . $course['id'] . '.jpg') }}" --}}
                                    alt="User profile picture">
                            </div>
                            <h3 class="profile-username text-center">{{ $course['professor'] }}</h3>
                            {{-- <p class="text-muted text-center">{{ $course['title'] }}</p> --}}
                            <a href="" class="btn btn-primary d-block">Ver perfil</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-9">
                    <h2>Cupos disponibles:
                        [<span class="text-info">{{ $course['quotas_available'] }}</span>
                        /
                        <span class="text-info">{{ $course['quotas'] }}</span>]
                        <form action="{{ route('Cursos.destroy', $course['id']) }}" method="post">
                            <a href="{{ route('Cursos.edit', $course['id']) }}" class="btn btn-warning">✏</a> | 
                            @csrf
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger">❌</button>
                        </form>
                    </h2>
                    <p class="text-justify text-muted">{{ $course['description'] }}</p>
                </div>
                {{-- Students table --}}
                <div class="col-sm-12 col-md-12">
                    <div class="table-responsive-sm mb-4">
                        <table id='users' class="table table-striped">
                            <thead>
                                <tr class="bg-secondary">
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre y Apellido</th>
                                    <th scope="col">PNF</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @for ($i = 1; $i < 100; $i++)
                                    <tr>
                                        <th scope="col">{{ $i }}</th>
                                        <th scope="col">Lucas Gómez</th>
                                        <th scope="col">Mecánica</th>
                                    </tr>
                                @endfor --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <section class="content">
        <div class="container-fluid">
            <div id="slick" class="px-5">
                    <div class="slide">
                        <div class="card mt-3">
                            <img src="{{ asset('/vendor/img/banners/' . $course['name'] . '.webp') }}" class="card-img-top rounded"
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
    </section> --}}
@stop

@section('footer')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
@stop

@section('js')
    <script>
        document.querySelectorAll('p').forEach(item => {
            item.innerText === 'Cursos' ?
                item.parentNode.classList.add('active') : ""
        })
    </script>
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#users').DataTable({
                "lengthMenu": [
                    [10, 20, 30, -1],
                    [10, 20, 30, 'Todos']
                ],
                "language": {
                    "lengthMenu": "Mostrar _MENU_",
                    "zeroRecords": "No se encontraron datos",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay datos disponibles",
                    "infoFiltered": "(filtrado de _MAX_ todos los registros)",
                    "search": "Buscar",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
@stop
