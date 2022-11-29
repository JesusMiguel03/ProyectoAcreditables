@extends('adminlte::page')

@section('title', 'Acreditables | Materias')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Materias</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Materias</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Boton para crear cursos - Modal --}}
    @can('materias.gestion')
        <div class="row">
            <div class="col-md-3 col-sm-12">
                <div class="card">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#materias">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Añadir materia') }}
                    </button>
                </div>
            </div>
        </div>

        {{-- Modal para crear --}}
        <div class="modal fade" id="materias" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">

                    {{-- Encabezado --}}
                    <header class="modal-header bg-primary">
                        <h5 class="modal-title" id="exampleModalLabel">Agregar materia</h5>
                    </header>

                    {{-- Contenido --}}
                    <main class="modal-body">
                        <form action="{{ route('materias.store') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            {{-- Nombre --}}
                            <div class="form-group mb-3">
                                <label for="nom_materia">Nombre</label>
                                <input type="text" name="nom_materia"
                                    class="form-control @error('nom_materia') is-invalid @enderror"
                                    value="{{ old('nom_materia') }}" placeholder="{{ __('Nombre de la materia') }}" autofocus>

                                @error('nom_materia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Cupos --}}
                            <div class="form-group mb-3">
                                <label for="cupos">Cupos disponibles</label>
                                <input type="number" name="cupos" class="form-control @error('cupos') is-invalid @enderror"
                                    value="{{ old('cupos') }}" placeholder="{{ __('Cupos iniciales, límite: 50') }}" autofocus>

                                @error('Cupos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Descripción --}}
                            <div class="form-group mb-3">
                                <label for="desc_materia">Descripción</label>
                                <textarea name="desc_materia" class="form-control @error('desc_materia') is-invalid @enderror"
                                    value="{{ old('desc_materia') }}" placeholder="{{ __('Descripción') }}" autofocus
                                    style="min-height: 9rem; resize: none" spellcheck="false"></textarea>

                                @error('desc_materia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Número de acreditable --}}
                            <div class="form-group mb-3">
                                <label for="num_acreditable">Acreditable Nro</label>
                                <select name="num_acreditable"
                                    class="form-control @error('num_acreditable') is-invalid @enderror">
                                    <option value="0">Seleccione una</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>

                                @error('num_acreditable')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Imagen (opcional) --}}
                            <div class="form-group mb-3">
                                <label for="imagen_materia">Imagen</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="custom-file-input @error('imagen_materia') is-invalid @enderror"
                                        id="imagen_materia" name="imagen_materia" accept="image/jpeg">
                                    <label class="custom-file-label text-muted" for="imagen_materia" id="campoImagen">Seleccione
                                        una imagen</label>
                                    <small id="ayudaImagen" class="form-text text-muted">La imagen debe pesar menos de 1
                                        MB.</small>
                                </div>
                                @error('imagen_materia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Previsualizar imagen --}}
                            <div class="card" style="max-width: 540px">
                                <img src="" alt="" id="previsualizar" class="rounded">
                            </div>

                            {{-- Botón de registrar --}}
                            <div class="row">
                                <x-botones.cancelar />

                                <x-botones.guardar />
                            </div>

                        </form>
                    </main>
                </div>
            </div>
        </div>
    @endcan

    {{-- Vista estudiante/profesor --}}
    @if (Auth::user()->getRoleNames()[0] !== 'Coordinador')
        @if (empty(Auth::user()->estudiante))
            <div class="col-md-6 col-sm-12 mx-auto">
                <section class="card">
                    <header class="card-header bg-secondary">
                        <h5 class="mx-auto text-center" id="exampleModalLongTitle">¡Aún no terminas tu perfil
                            académico!</h5>
                    </header>

                    <main class="card-body p-4 text-justify">
                        Dirigete al ícono o avatar al lado de tu nombre, perfil y coloca el pnf que estés cursando y
                        trayecto para acceder a las materias.
                    </main>

                    <footer class="card-footer">
                        <a href="{{ route('perfil.index') }}" class="btn btn-primary btn-block px-5">Ver perfil</a>
                    </footer>
                </section>
            </div>
        @endif

        @if (!empty(Auth::user()->estudiante->preinscrito))
            <div id="slick" class="px-5">
                @foreach ($materias as $materia)
                    @if ($materia->id === Auth::user()->estudiante->preinscrito->materia_id)
                        <div class="slide">
                            <div class="card mt-3">

                                @if ($materia->imagen_materia === null)
                                    <div class="card-header bg-secondary">
                                        <h5 class="py-2 my-4 text-light" style="min-height: 4.438rem;">Esta materia no
                                            posee una imagen</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title mb-2 h2 fw-bold">{{ $materia->nom_materia }}</h5>
                                        <h6 class="card-text text-secondary">Cupos disponibles:
                                            <span class="text-primary">{{ $materia->cupos_disponibles }}
                                            </span>
                                        </h6>
                                        <p class="card-text text-truncate">{{ $materia->desc_materia }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('materias.show', $materia->id) }}"
                                            class="btn btn-primary d-block">
                                            Ver materia
                                        </a>
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $materia->imagen_materia) }}"
                                        class="card-img-top rounded" alt="Imagen de la materia">

                                    <div class="card-body">
                                        <div class="row px-2">
                                            <h5 class="card-title mb-2 font-weight-bold">{{ $materia->nom_materia }}</h5>
                                        </div>

                                        <div class="row">
                                            <div class="col-10">
                                                <h6 class="card-text text-secondary">Cupos disponibles:
                                                    <span class="text-primary">{{ $materia->cupos_disponibles }}
                                                    </span>
                                                </h6>
                                            </div>
                                            <div class="col-2">
                                                <h5 class="card-title mb-2 font-weight-bold text-muted">
                                                    #A{{ $materia->num_acreditable }}</h5>

                                            </div>
                                        </div>
                                        <p class="card-text text-truncate">{{ $materia->desc_materia }}</p>
                                    </div>

                                    <div class="card-footer">
                                        <a href="{{ route('materias.show', $materia->id) }}"
                                            class="btn btn-primary d-block">
                                            Ver materia
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div id="slick" class="px-5">

                @foreach ($materias as $materia)
                    @if ($materia->estado_materia !== 'Inactivo' &&
                        !empty(Auth::user()->estudiante) &&
                        $materia->num_acreditable === Auth::user()->estudiante->trayecto_id)
                        <div class="slide">
                            <div class="card mt-3">

                                @if ($materia->imagen_materia === null)
                                    <div class="card-header bg-secondary">
                                        <h5 class="py-2 my-4 text-light" style="min-height: 4.438rem;">Esta materia no
                                            posee una imagen</h5>
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title mb-2 h2 fw-bold">{{ $materia->nom_materia }}</h5>
                                        <h6 class="card-text text-secondary">Cupos disponibles:
                                            <span class="text-primary">{{ $materia->cupos_disponibles }}
                                            </span>
                                        </h6>
                                        <p class="card-text text-truncate">{{ $materia->desc_materia }}</p>
                                    </div>
                                    <div class="card-footer">
                                        <a href="{{ route('materias.show', $materia->id) }}"
                                            class="btn btn-primary d-block">
                                            Ver materia
                                        </a>
                                    </div>
                                @else
                                    <img src="{{ asset('storage/' . $materia->imagen_materia) }}"
                                        class="card-img-top rounded" alt="Imagen de la materia">

                                    <div class="card-body">
                                        <div class="row px-2">
                                            <h5 class="card-title mb-2 font-weight-bold">{{ $materia->nom_materia }}</h5>
                                        </div>

                                        <div class="row">
                                            <div class="col-10">
                                                <h6 class="card-text text-secondary">Cupos disponibles:
                                                    <span class="text-primary">{{ $materia->cupos_disponibles }}
                                                    </span>
                                                </h6>
                                            </div>
                                            <div class="col-2">
                                                <h5 class="card-title mb-2 font-weight-bold text-muted">
                                                    #A{{ $materia->num_acreditable }}</h5>

                                            </div>
                                        </div>
                                        <p class="card-text text-truncate">{{ $materia->desc_materia }}</p>
                                    </div>

                                    <div class="card-footer">
                                        <a href="{{ route('materias.show', $materia->id) }}"
                                            class="btn btn-primary d-block">
                                            Ver materia
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @endif
                @endforeach

            </div>

        @endif

        {{-- Vista coordinador --}}
    @else
        <div class="card table-responsive-sm p-3 my-4 col-12">
            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Nombre</th>
                        <th>Cupos</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                        <th>Acreditable</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materias as $materia)
                        <tr>
                            <td>{{ $materia->nom_materia }}</td>
                            <td>{{ $materia->cupos }}</td>
                            <td>{{ $materia->estado_materia }}</td>
                            <td class="text-justify" style="width: 15rem">{{ $materia->desc_materia }}</td>
                            <td>{{ $materia->num_acreditable }}</td>
                            <td>
                                <a href="{{ route('materias.edit', $materia) }}" class="btn btn-primary"
                                    style="width: 7rem">
                                    <i class="fas fa-edit mr-2"></i>
                                    Editar
                                </a>
                                <a href="{{ route('materias.show', $materia) }}" class="btn btn-primary"
                                    style="width: 7rem">
                                    <i class="fas fa-eye mr-2"></i>
                                    Ver
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@stop

@section('css')
    @if (Auth::user()->getRoleNames()[0] !== 'Coordinador')
        <link rel="stylesheet" href="{{ asset('vendor/carousel/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/carousel/carousel.css') }}">
        <style>
            .card-img-top {
                max-height: 9rem;
            }
        </style>
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <style>
        .custom-file-label::after {
            content: "Buscar";
        }
    </style>
@stop

@section('js')
    @if (Auth::user()->getRoleNames()[0] === 'Coordinador')
        <script src="{{ asset('js/tablas.js') }}"></script>
        <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    @else
        <script src="{{ asset('vendor/carousel/slick.min.js') }}"></script>
        <script src="{{ asset('vendor/carousel/carousel.js') }}"></script>
    @endif
    <script src="{{ asset('js/previsualizacion.js') }}" defer></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Cambio exitoso!',
                html: 'Materia editada correctamente.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Materia añadida!',
                html: 'Materia registrada correctamente.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo registrar!',
                html: 'Uno de los campos no cumple los requisitos.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('registrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Te has registrado exitosamente!',
                html: 'Ahora podrás cursar la materia preinscrita, pero recuerda llevar tu comprobante de preinscripción a la Coordinación de Acreditables para ser validado.',
                confirmButtonColor: '#6c757d',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
