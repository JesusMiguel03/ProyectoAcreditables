@extends('adminlte::page')

@section('title', 'Acreditables | Inicio')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('student.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('courses.index') }}">Cursos</a></li>
                <li class="breadcrumb-item active"><a href="">{{ $course['name'] }}</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}

    <div class="row">
        <div class="col-sm-12 col-md-3">
            <div class="card">
                @if ($course['professor'] !== 'Sin asignar')
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{ asset('/vendor/img/profs/user0.jpg') }}" alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center">{{ $course['professor'] }}</h3>

                        <a href="" class="btn btn-primary d-block">Ver perfil</a>
                    </div>
                @else
                <div class="card-body text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('/vendor/img/profs/user.webp') }}"
                        alt="User profile picture">
                </div>
                    <div class="card-footer" style="min-height: 4.77rem">
                        <h6 class="text-muted text-justify">Actualmente no hay un profesor asignado.</h6>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-sm-12 col-md-9">
            <div class="card">
                <div class="card-body" style="min-height: 9.65rem">

                    <h2 class="d-none d-md-block">Cupos disponibles
                        [ <span class="text-info">{{ $course['quotas_available'] }}</span> /
                        <span class="text-info">{{ $course['quotas'] }}</span> ]
                    </h2>
                    <h2 class="d-md-none">Cupos disponibles</h2>
                    <h2 class="d-md-none">[ <span class="text-info">{{ $course['quotas_available'] }}</span> / <span
                            class="text-info">{{ $course['quotas'] }}</span>]</h2>

                    <p class="text-justify text-muted">{{ $course['description'] }}</p>
                </div>


                <div class="card-footer">
                    @can('courses.edit')
                        <div class="row">
                            <h5 class="text-muted my-auto mr-2">Opciones de curso</h5>
                            <form action="{{ route('courses.destroy', $course['id']) }}" method="post">
                                <a href="{{ route('courses.edit', $course['id']) }}" class="btn btn-primary mr-3"
                                    style="width: 5.5rem">Editar</a>
                                @csrf
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-outline-danger" style="width: 5.5rem">Eliminar</button>
                            </form>
                        </div>
                    @endcan
                    @can('courses.show')
                        @if (Auth::user()->getRoleNames()[0] === 'Estudiante')
                            <div class="text-center">
                                <form action="" method="post">
                                    @csrf
                                    {{ method_field('DELETE') }}
                                    <button type="button" class="btn btn-outline-primary">Preinscribirme</button>
                                </form>
                            </div>
                        @endif
                    @endcan
                </div>

            </div>
        </div>

        <section class="col-12 border-bottom">
            <div class="row">
                <div class="col-sm-12 col-md-2">
                    <div class="card pt-2 text-center">
                        <strong>Modalidad</strong>
                        <p>[ <span class="text-info">Presencial</span> ]</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div
                        class="card {{ $course['type'] === 'Sin asignar' ? 'border border-warning' : '' }} pt-2 text-center">
                        <strong>Tipo</strong>
                        <p>[ <span
                                class="{{ $course['type'] === 'Sin asignar' ? 'text-muted' : 'text-info' }}">{{ $course['type'] }}</span>
                            ]</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div
                        class="card {{ $course['category'] === 'Sin asignar' ? 'border border-warning' : '' }} pt-2 text-center">
                        <strong>Categoria</strong>
                        <p>[ <span
                                class="{{ $course['category'] === 'Sin asignar' ? 'text-muted' : 'text-info' }}">{{ $course['category'] }}</span>
                            ]</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="card pt-2 text-center">
                        <strong>Hora</strong>
                        <p>[ <span class="text-info">11: 45 am</span> ]</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="card pt-2 text-center">
                        <strong>Lugar</strong>
                        <p>[ <span class="text-info">Aula B5</span> ]</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="card pt-2 text-center">
                        <strong>Semana</strong>
                        <p>[ <span class="text-info">10</span> / <span class="text-info">12</span> ]</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Students table --}}
        <div class="col-12 mt-4">
            <div class="card table-responsive-sm p-3 mb-4">
                <table id='users' class="table table-striped">
                    <thead>
                        <tr class="bg-secondary">
                            <th>#</th>
                            <th>Nombre y Apellido</th>
                            <th>Fecha de ingreso</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th>{{ $user->id }}</th>
                                <th>{{ $user->name }}</th>
                                <th>{{ $user->created_at }}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@stop

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
