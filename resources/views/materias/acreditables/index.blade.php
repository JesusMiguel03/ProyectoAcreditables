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

                            {{-- Nombre --}}
                            <div class="form-group required mb-3">
                                <label for="nom_materia" class="control-label">Nombre</label>
                                <div class="input-group">
                                    <input type="text" name="nom_materia"
                                        class="form-control @error('nom_materia') is-invalid @enderror"
                                        value="{{ old('nom_materia') }}" placeholder="{{ __('Nombre de la materia') }}"
                                        autofocus required>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-font"></span>
                                        </div>
                                    </div>

                                    @error('nom_materia')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group" style="margin-bottom: -0.3rem">
                                <div class="row">

                                    {{-- Cupos --}}
                                    <div class="form-group required col-6">
                                        <label for="cupos" class="control-label">Cupos disponibles</label>
                                        <div class="input-group">
                                            <input type="number" name="cupos"
                                                class="form-control @error('cupos') is-invalid @enderror"
                                                value="{{ old('cupos') }}"
                                                placeholder="{{ __('Cupos iniciales, límite: ' . config('variables.materias.cupos')) }}"
                                                required>

                                            @error('Cupos')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Numero --}}
                                    <div class="form-group required col-6">
                                        <label for="num_acreditable" class="control-label">Acreditable Nro</label>
                                        <div class="input-group">
                                            <select name="num_acreditable"
                                                class="form-control @error('num_acreditable') is-invalid @enderror">
                                                <option value="0" disabled>Seleccione una</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                            </select>

                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span class="fas fa-list-ol"></span>
                                                </div>
                                            </div>

                                            @error('num_acreditable')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>
                            </div>

                            {{-- Descripción --}}
                            <div class="form-group required mb-3">
                                <label for="desc_materia" class="control-label">Descripción</label>
                                <div class="input-group">
                                    <textarea name="desc_materia" class="form-control @error('desc_materia') is-invalid @enderror descripcion"
                                        value="{{ old('desc_materia') }}" placeholder="{{ __('Descripción') }}" spellcheck="false" required></textarea>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-quote-right"></span>
                                        </div>
                                    </div>

                                    @error('desc_materia')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Imagen (opcional) --}}
                            <div class="form-group mb-3">
                                <label for="imagen_materia">Imagen</label>
                                <div class="input-group">
                                    <input type="file"
                                        class="custom-file-input @error('imagen_materia') is-invalid @enderror" id="imagen"
                                        name="imagen_materia" accept="image/jpeg">
                                    <label class="custom-file-label text-muted" for="imagen_materia" id="campoImagen">
                                        Seleccione una imagen
                                    </label>
                                    <small id="ayudaImagen" class="form-text text-muted">
                                        La imagen debe pesar menos de 1 MB.
                                    </small>
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

                            <x-modal.mensaje-obligatorio />

                            <x-modal.footer-aceptar />
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

        @php
            $categoria = !empty($materias->info) ? $materias->info->categoria->nom_categoria : 'Sin asignar';
        @endphp

        {{-- No tiene perfil academico --}}
        @if (!estudiante(Auth::user(), 'academico'))
            <x-elementos.perfil-incompleto />

            {{-- Esta inscrito --}}
        @elseif (estudiante(Auth::user(), 'inscrito'))
            <div id="slick" class="px-5">
                <div class="slide">

                    <x-elementos.card-materia :id="$materias->id" :img="$materias->imagen_materia" :nombre="$materias->nom_materia" :cupos="$materias->cupos_disponibles"
                        :acreditable="$materias->num_acreditable" :categoria="$categoria" :contenido="$materias->desc_materia" />

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

                                <x-elementos.card-materia :id="$materia->id" :img="$materia->imagen_materia" :nombre="$materia->nom_materia"
                                    :cupos="$materia->cupos_disponibles" :acreditable="$materia->num_acreditable" :categoria="$categoria" :contenido="$materia->desc_materia" />
                            </div>
                        @endif
                    @endforeach
                </div>
            @endif
        @endif
    @endif

    @if (estudiante(Auth::user(), 'materia') || !rol('Estudiante'))
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
    <link rel="stylesheet" href="{{ asset('/vendor/DataTables/datatables.min.css') }}">
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
        <script src="{{ asset('js/previsualizacion.js') }}" defer></script>
        <script src="{{ asset('js/borrar.js') }}"></script>
    @endif

    <script src="{{ asset('js/tablas.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('actualizado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Registro actualizado!',
                html: 'La materia ha sido actualizada correctamente.',
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
                title: '¡Te has inscrito exitosamente!',
                html: 'Ahora podrás cursar la materia inscrita, pero recuerda llevar tu comprobante de inscripción a la Coordinación de Acreditables para ser validado.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('borrado'))
            let timerInterval
            Swal.fire({
                icon: 'success',
                title: '¡Acreditable borrada exitosamente!',
                html: 'La acreditable ha sido borrada.',
                confirmButtonColor: '#28a745',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @elseif ($message = session('no encontrado'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡Acreditable no encontrada!',
                html: 'La acreditable que desea buscar o editar no se encuentra disponible.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
