@extends('adminlte::page')

@section('title', 'Acreditables | Materias')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item active"><a href="">Materias</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Materias</x-tipografia.titulo>

    @can('materias.modificar')
        <div class="modal fade" id="registrar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar materia</h5>
                    </header>

                    <main class="modal-body">
                        <form action="{{ route('materias.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <x-formularios.acreditables />
                        </form>
                    </main>
                </div>
            </div>
        </div>

        <x-formularios.borrar />
    @endcan
@stop

@section('content')
    @if (rol('Estudiante'))

        {{-- No tiene perfil academico --}}
        @if (!datosUsuario(Auth::user(), 'Estudiante', 'academico'))

            <x-elementos.perfil-incompleto />

            {{-- Esta inscrito --}}
        @elseif (datosUsuario(Auth::user(), 'Estudiante', 'inscrito'))
            <div id="slick" class="px-5">
                <div class="slide">

                    <x-elementos.card-materia :materia="$materias" />

                </div>
            </div>

            {{-- No esta inscrito --}}
        @else
            @if ($materias->isEmpty())
                <x-elementos.card-materia :existe="true" />
            @else
                <div id="slick" class="px-5">

                    @foreach ($materias as $materia)
                        @if ($loop->index < config('variables.carrusel'))
                            <div class="slide">

                                <x-elementos.card-materia :materia="$materia" />
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @endif
    @endif

    @if (empty(datosUsuario(Auth::user(), 'Estudiante', 'materia')) || !rol('Estudiante'))
        <div class="card table-responsive-sm p-3 {{ rol('Estudiante') ? 'mt-5' : 'mt-1' }} mb-3 col-12">

            @if (rol('Estudiante'))
                <div class="w-100 row mx-auto my-2">
                    <p class="px-5 text-muted">
                        <strong>Nota:</strong>
                        El carrusel solo mostrará las primeras {{ config('variables.carrusel') }} acreditables activas para
                        no sobrecargar la vista del usuario, el resto de acreditables estarán disponibles en la tabla pero
                        no visibles.
                    </p>
                </div>
            @endif

            @if (rol('Profesor'))
                <div class="w-100 row mx-auto my-2">
                    <p class="px-5 text-muted">
                        <strong>Nota:</strong>
                        Cuando sea asignado a una o varias acreditables se mostrarán en la tabla.
                    </p>
                </div>
            @endif

            @can('materias.modificar')
                <div class="w-100 row mx-auto">
                    <div class="col-md-2 col">
                        <button class="btn btn-block btn-primary my-2" data-toggle="modal" data-target="#registrar"
                            {{ Popper::arrow()->pop('Nueva materia') }}>
                            <i class="fas fa-plus mr-2"></i>
                            {{ 'Añadir' }}
                        </button>
                    </div>
                </div>
            @endcan

            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Nombre</th>
                        <th>Cupos</th>
                        <th>Categoría</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                        <th>Acreditable</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materias as $materia)
                        <tr>
                            <td>{{ $materia->nom_materia }}</td>
                            <td {{ Popper::arrow()->pop('Cupos disponibles') }}>{{ $materia->cupos_disponibles }}</td>
                            <td>
                                {{ !empty($materia->info->categoria->nom_categoria) ? $materia->info->categoria->nom_categoria : 'Sin categoría' }}
                            </td>
                            <td>{{ $materia->estado_materia }}</td>
                            <td class="text-justify">{{ $materia->desc_materia }}</td>
                            <td>{{ $materia->num_acreditable }}</td>
                            <td>
                                <div class="btn-group mx-1" role="group" aria-label="Acciones">
                                    @can('materias.modificar')
                                        <a href="{{ route('materias.edit', $materia) }}" class="btn btn-primary"
                                            {{ Popper::arrow()->pop('Editar materia') }}>
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan
                                    <a href="{{ route('materias.show', $materia) }}" class="btn btn-primary"
                                        {{ Popper::arrow()->pop('Ver materia') }}>
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    @can('materias.modificar')
                                        <a href="{{ route('inscribir', $materia->id) }}"
                                            class="btn btn-primary {{ $materia->cupos_disponibles === 0 ? 'disabled' : '' }}"
                                            {{ Popper::arrow()->pop('Inscribir estudiantes') }}>
                                            <i class="fas fa-id-badge"></i>
                                        </a>

                                        <button id="{{ $materia->id }}" class="btn btn-danger borrar"
                                            {{ Popper::arrow()->pop('Borrar') }} data-type="Acreditable"
                                            data-name="{{ $materia->nom_materia }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/carousel/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/carousel/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buscar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/carousel/slick.min.js') }}"></script>
    <script src="{{ asset('vendor/carousel/carousel.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    @if (rol('Coordinador'))
        <script src="{{ asset('js/previsualizacion.js') }}"></script>
        <script src="{{ asset('js/borrar.js') }}"></script>
        <script src="{{ asset('js/mensajeMostrarLimite.js') }}"></script>
    @endif

    <script src="{{ asset('js/tablas.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('actualizado'))
            Swal.fire({
                icon: 'success',
                title: '¡Registro actualizado!',
                html: 'La materia ha sido actualizada correctamente.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('creado'))
            Swal.fire({
                icon: 'success',
                title: '¡Materia registrada!',
                html: 'Una nueva materia ha sido añadida.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-sucess px-5'
                },
            })
        @elseif ($message = session('error'))
            Swal.fire({
                icon: 'error',
                title: '¡Error al registrar!',
                html: 'Uno de los campos parece estar mal.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger px-5'
                },
            })
            $('materias').modal('show')
        @elseif ($message = session('inexistente'))
            Swal.fire({
                icon: 'error',
                title: '¡Materia no encontrada!',
                html: 'La materia a la que intenta acceder no existe.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif ($message = session('registrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Te has inscrito exitosamente!',
                html: 'Ahora podrá cursar la materia inscrita, pero recuerda llevar su comprobante de inscripción a la Coordinación de Acreditables para ser validado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('borrado'))
            Swal.fire({
                icon: 'success',
                title: '¡Acreditable borrada exitosamente!',
                html: 'La acreditable ha sido borrada.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-success px-5'
                },
            })
        @elseif ($message = session('no encontrado'))
            Swal.fire({
                icon: 'error',
                title: '¡Acreditable no encontrada!',
                html: 'La acreditable que desea buscar no se encuentra disponible.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @endif
    </script>
@stop
