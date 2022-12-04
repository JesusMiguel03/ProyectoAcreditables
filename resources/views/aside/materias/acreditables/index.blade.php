@extends('adminlte::page')

@section('title', 'Acreditables | Materias')

@section('content_header')
    <div class="row mb-2">
        <div class="col-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Materias</a></li>
            </ol>
        </div>
        <div class="col-6">
            {{-- Boton para crear cursos - Modal --}}
            @can('materias.gestion')
                <div class="card float-right">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#materias">
                        <i class="fas fa-plus mr-2"></i>
                        {{ __('Añadir materia') }}
                    </button>
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
                                    <div class="form-group required mb-3">
                                        <label for="nom_materia" class="control-label">Nombre</label>
                                        <input type="text" name="nom_materia"
                                            class="form-control @error('nom_materia') is-invalid @enderror"
                                            value="{{ old('nom_materia') }}" placeholder="{{ __('Nombre de la materia') }}"
                                            autofocus required>

                                        @error('nom_materia')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Cupos --}}
                                    <div class="form-group required mb-3">
                                        <label for="cupos" class="control-label">Cupos disponibles</label>
                                        <input type="number" name="cupos"
                                            class="form-control @error('cupos') is-invalid @enderror"
                                            value="{{ old('cupos') }}" placeholder="{{ __('Cupos iniciales, límite: 50') }}"
                                            autofocus required>

                                        @error('Cupos')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Descripción --}}
                                    <div class="form-group required mb-3">
                                        <label for="desc_materia" class="control-label">Descripción</label>
                                        <textarea name="desc_materia" class="form-control @error('desc_materia') is-invalid @enderror"
                                            value="{{ old('desc_materia') }}" placeholder="{{ __('Descripción') }}" autofocus
                                            style="min-height: 9rem; resize: none" spellcheck="false" required></textarea>

                                        @error('desc_materia')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    {{-- Número de acreditable --}}
                                    <div class="form-group required mb-3">
                                        <label for="num_acreditable" class="control-label">Acreditable Nro</label>
                                        <select name="num_acreditable"
                                            class="form-control @error('num_acreditable') is-invalid @enderror">
                                            <option value="0" disabled>Seleccione una</option>
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
                                            <label class="custom-file-label text-muted" for="imagen_materia"
                                                id="campoImagen">Seleccione
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

                                    <div class="form-group" style="margin-bottom: -10px">
                                        <p class="pl-2 text-danger"><strong>Nota:</strong> (*) Indica los campos que
                                            son obligatorios.
                                        </p>
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
        </div>
    </div>
@stop

@section('content')
    {{-- Vista estudiante/profesor --}}
    @if (Auth::user()->getRoleNames()[0] === 'Estudiante')
        @if (empty(Auth::user()->estudiante))
            <div class="col-md-4 col-sm-12 mx-auto">
                <section class="card">
                    <header class="card-header bg-secondary">
                        <h5 class="mx-auto text-center" id="exampleModalLongTitle">Su perfil académico se encuentra
                            incompleto</h5>
                    </header>

                    <main class="card-body p-4 text-justify">
                        <p>Verifique en su perfil (<span class="text-info">haga clic en la imagen al lado de su nombre,
                                perfil</span>) y revise si en el apartado "Perfil académico" se encuentra su información, en
                            caso contrario comuníquese con el coordinador para completar su perfil.</p>
                    </main>

                    <footer class="card-footer">
                        <p class="text-justify">Nos disculpamos por los inconvenientes.</p>
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
                                    <div class="card-img-top">
                                        <img src="{{ asset('vendor/img/defecto/materias.png') }}" alt="Imagen de materia"
                                            class="card-img-top rounded border border-outline-secondary"
                                            style="filter:brightness(0.8)">
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
                                    <div class="card-img-top">
                                        <img src="{{ asset('vendor/img/defecto/materias.png') }}" alt="Imagen de materia"
                                            class="card-img-top rounded border border-outline-secondary"
                                            style="filter:brightness(0.8)">
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

        <div class="card table-responsive-sm p-3 mt-5 mb-3 col-12">
            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Nombre</th>
                        <th>Cupos</th>
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
                            <td>{{ $materia->cupos_disponibles }}</td>
                            <td>{{ $materia->estado_materia }}</td>
                            <td class="text-justify">{{ $materia->desc_materia }}</td>
                            <td>{{ $materia->num_acreditable }}</td>
                            <td>
                                <a href="{{ route('materias.show', $materia) }}"
                                    class="btn btn-primary {{ Popper::pop('Ver materia!') }}">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Vista coordinador --}}
    @elseif (Auth::user()->getRoleNames()[0] === 'Profesor')
        <div id="slick" class="px-5">
            @foreach ($materias as $materia)
                <div class="slide">
                    <div class="card mt-3">

                        @if ($materia->imagen_materia === null)
                            <div class="card-img-top">
                                <img src="{{ asset('vendor/img/defecto/materias.png') }}" alt="Imagen de materia"
                                    class="card-img-top rounded border border-outline-secondary"
                                    style="filter:brightness(0.8)">
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
                                <a href="{{ route('materias.show', $materia->id) }}" class="btn btn-primary d-block">
                                    Ver materia
                                </a>
                            </div>
                        @else
                            <img src="{{ asset('storage/' . $materia->imagen_materia) }}" class="card-img-top rounded"
                                alt="Imagen de la materia">

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
                                <a href="{{ route('materias.show', $materia->id) }}" class="btn btn-primary d-block">
                                    Ver materia
                                </a>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>

        <div class="card table-responsive-sm p-3 mt-4 mb-3 col-12">
            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Nombre</th>
                        <th>Cupos disponibles</th>
                        <th>Estado</th>
                        <th>Descripción</th>
                        <th>Acreditable</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($materias as $materia)
                        @if (!empty(Auth::user()->profesor) && !empty($materia->info)
                            ? Auth::user()->profesor->id === $materia->info->profesor->id
                            : '')
                            <tr>
                                <td>{{ $materia->nom_materia }}</td>
                                <td>{{ $materia->cupos_disponibles }}</td>
                                <td>{{ $materia->estado_materia }}</td>
                                <td class="text-justify">{{ $materia->desc_materia }}</td>
                                <td>{{ $materia->num_acreditable }}</td>
                                <td>
                                    <a href="{{ route('materias.show', $materia) }}" class="btn btn-primary"
                                        {{ Popper::arrow()->pop('Ver materia') }}>
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @else
                        <div class="card p-4 bg-secondary">
                            <h5>No se encuentra asignado a ninguna acreditable. Cuando el coordinador lo añada a una se mostrará en la tabla debajo.</h5>
                        </div>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="card table-responsive-sm p-3 mt-1 mb-3 col-12">
            <table id='tabla' class="table table-striped">
                <thead>
                    <tr class="bg-secondary">
                        <th>Nombre</th>
                        <th>Cupos disponibles</th>
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
                            <td>{{ $materia->cupos_disponibles }}</td>
                            <td>{{ $materia->estado_materia }}</td>
                            <td class="text-justify">{{ $materia->desc_materia }}</td>
                            <td>{{ $materia->num_acreditable }}</td>
                            <td>
                                @can('materias.gestion')
                                    <a href="{{ route('materias.edit', $materia) }}" class="btn btn-primary"
                                        {{ Popper::arrow()->pop('Editar materia') }}>
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan
                                <a href="{{ route('materias.show', $materia) }}" class="btn btn-primary"
                                    {{ Popper::arrow()->pop('Ver materia') }}>
                                    <i class="fas fa-eye"></i>
                                </a>
                                @can('materias.gestion')
                                    <a href="{{ route('preinscribir', $materia->id) }}"
                                        class="btn btn-primary {{ $materia->cupos_disponibles === 0 ? 'disabled' : '' }}"
                                        {{ Popper::arrow()->pop('Inscribir estudiantes') }}>
                                        <i class="fas fa-id-badge"></i>
                                    </a>
                                @endcan
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
    <link rel="stylesheet" type="text/css" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
    <style>
        .form-group.required .control-label:after {
            color: #d00;
            content: "*";
            position: absolute;
            margin-left: 6px;
            margin-top: 3px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
    <style>
        .custom-file-label::after {
            content: "Buscar";
        }
    </style>
@stop

@section('js')
    <script src="{{ asset('js/tablas.js') }}"></script>
    <script src="{{ asset('/vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('vendor/carousel/slick.min.js') }}"></script>
    <script src="{{ asset('vendor/carousel/carousel.js') }}"></script>
    <script src="{{ asset('js/previsualizacion.js') }}" defer></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        @if ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Registro actualizado!',
                html: 'La materia ha sido actualizad correctamente.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('creado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Materia registrada!',
                html: 'Una nueva materia ha sido añadida.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Error al registrar!',
                html: 'Uno de los campos parece estar mal.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
            $('materias').modal('show')
        @elseif ($message = session('inexistente'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Materia no encontrada!',
                html: 'La materia a la que intenta acceder no existe.',
                confirmButtonColor: '#dc3545',
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
                confirmButtonColor: '#007bff',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
