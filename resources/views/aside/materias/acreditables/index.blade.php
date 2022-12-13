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
                                    <div class="form-group" style="margin-bottom: -0.3rem">
                                        <div class="row">

                                            <div class="form-group required col-6">
                                                <label for="cupos" class="control-label">Cupos disponibles</label>
                                                <input type="number" name="cupos"
                                                    class="form-control @error('cupos') is-invalid @enderror"
                                                    value="{{ old('cupos') }}"
                                                    placeholder="{{ __('Cupos iniciales, límite: 50') }}" autofocus required>

                                                @error('Cupos')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group required col-6">
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

                                        </div>
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

    <x-tipografia.titulo>Materias</x-tipografia.titulo>
@stop

@section('content')
    {{-- Estudiante --}}
    @if (Auth::user()->getRoleNames()[0] === 'Estudiante')
        <div id="slick" class="px-5">
            @if (empty(Auth::user()->estudiante))
                <div class="col-md-12 col-sm-12 mx-auto">
                    <section class="card">
                        <header class="card-header bg-secondary">
                            <h5 class="mx-auto text-center" id="exampleModalLongTitle">Su perfil académico se
                                encuentra
                                incompleto</h5>
                        </header>

                        <main class="card-body p-4 text-justify">
                            <p>Verifique en su perfil (<span class="text-info">haga clic en la imagen al lado de su
                                    nombre,
                                    perfil</span>) y revise si en el apartado "Perfil académico" se encuentra su
                                información, en
                                caso contrario comuníquese con el coordinador para completar su perfil.</p>
                        </main>

                        <footer class="card-footer">
                            <p class="text-justify">Nos disculpamos por los inconvenientes.</p>
                        </footer>
                    </section>
                </div>
            @else
                @foreach ($materias as $materia)
                    @if ($materia->estado_materia !== 'Inactivo' &&
                        !empty(Auth::user()->estudiante) &&
                        $materia->num_acreditable === Auth::user()->estudiante->trayecto_id)
                        @if (Auth::user()->estudiante->preinscrito && $materia->id === Auth::user()->estudiante->preinscrito->materia_id)
                            <div class="slide">

                                <section class="card mt-3">
                                    <header class="card-img-top"
                                        {{ $materia->imagen_materia === null ? 'style="height: 5rem"' : '' }}>
                                        <img src="{{ $materia->imagen_materia === null ? asset('vendor/img/defecto/materias.png') : asset('storage/' . $materia->imagen_materia) }}"
                                            alt="Imagen de materia"
                                            class="card-img-top rounded {{ $materia->imagen_materia === null ? 'border border-outline-secondary' : '' }}">
                                    </header>

                                    <main class="card-body">
                                        <div class="row px-2">
                                            <h5 class="card-title mb-2 font-weight-bold">{{ $materia->nom_materia }}
                                            </h5>
                                        </div>

                                        <div class="row mb-2 border-bottom">
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
                                            <div class="col-12" style="margin-top: -0.5rem">
                                                <h6 class="text-muted">Categoria:
                                                    <span
                                                        class="text-info">{{ !empty($materia->info->categoria->nom_categoria) ? $materia->info->categoria->nom_categoria : 'Sin asignar' }}</span>
                                                </h6>
                                            </div>
                                        </div>

                                        <p class="card-text text-truncate">{{ $materia->desc_materia }}</p>
                                    </main>

                                    <footer class="card-footer">
                                        <a href="{{ route('materias.show', $materia->id) }}"
                                            class="btn btn-primary d-block">
                                            Ver materia
                                        </a>
                                    </footer>
                                </section>

                            </div>
                        @elseif (empty(Auth::user()->estudiante->preinscrito))
                            <div class="slide">

                                <section class="card mt-3">
                                    <header class="card-img-top"
                                        {{ $materia->imagen_materia === null ? 'style="height: 5rem"' : '' }}>
                                        <img src="{{ $materia->imagen_materia === null ? asset('vendor/img/defecto/materias.png') : asset('storage/' . $materia->imagen_materia) }}"
                                            alt="Imagen de materia"
                                            class="card-img-top rounded {{ $materia->imagen_materia === null ? 'border border-outline-secondary' : '' }}">
                                    </header>

                                    <main class="card-body">
                                        <div class="row px-2">
                                            <h5 class="card-title mb-2 font-weight-bold">{{ $materia->nom_materia }}
                                            </h5>
                                        </div>

                                        <div class="row mb-2 border-bottom">
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
                                            <div class="col-12" style="margin-top: -0.5rem">
                                                <h6 class="text-muted">Categoria:
                                                    <span
                                                        class="text-info">{{ !empty($materia->info->categoria->nom_categoria) ? $materia->info->categoria->nom_categoria : 'Sin asignar' }}</span>
                                                </h6>
                                            </div>
                                        </div>

                                        <p class="card-text text-truncate">{{ $materia->desc_materia }}</p>
                                    </main>

                                    <footer class="card-footer">
                                        <a href="{{ route('materias.show', $materia->id) }}"
                                            class="btn btn-primary d-block">
                                            Ver materia
                                        </a>
                                    </footer>
                                </section>

                            </div>
                        @endif
                    @endif
                @endforeach
            @endif
        </div>

        {{-- Profesor / Coordinador --}}
    @else
        <div class="card table-responsive-sm p-3 mt-1 mb-3 col-12">
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
                        @if (Auth::user()->getRoleNames()[0] === 'Profesor')
                            @if (!empty($materia->info->profesor_id) ? $materia->info->profesor_id === Auth::user()->profesor->id : '')
                                <tr>
                                    <td>{{ $materia->nom_materia }}</td>
                                    <td {{ Popper::arrow()->pop('Cupos disponibles') }}>
                                        {{ $materia->cupos_disponibles }}
                                    </td>
                                    <td>{{ !empty($materia->info->categoria->nom_categoria) ? $materia->info->categoria->nom_categoria : 'Sin categoría' }}
                                    </td>
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
                                            <a href="{{ route('inscribir', $materia->id) }}"
                                                class="btn btn-primary {{ $materia->cupos_disponibles === 0 ? 'disabled' : '' }}"
                                                {{ Popper::arrow()->pop('Inscribir estudiantes') }}>
                                                <i class="fas fa-id-badge"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                            @break
                        @endif
                    @else
                        <tr>
                            <td>{{ $materia->nom_materia }}</td>
                            <td {{ Popper::arrow()->pop('Cupos disponibles') }}>{{ $materia->cupos_disponibles }}
                            </td>
                            <td>{{ !empty($materia->info->categoria->nom_categoria) ? $materia->info->categoria->nom_categoria : 'Sin categoría' }}
                            </td>
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
                                    <a href="{{ route('inscribir', $materia->id) }}"
                                        class="btn btn-primary {{ $materia->cupos_disponibles === 0 ? 'disabled' : '' }}"
                                        {{ Popper::arrow()->pop('Inscribir estudiantes') }}>
                                        <i class="fas fa-id-badge"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endif
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('vendor/carousel/slick.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/carousel/carousel.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/DataTables/datatables.min.css') }}" />
<link rel="stylesheet" href="{{ asset('css/required.css') }}">
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

@if (Auth::user()->getRoleNames()[0] === 'Coordinador')
    <script src="{{ asset('js/previsualizacion.js') }}" defer></script>
@endif
<script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
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
            confirmButtonColor: '#007bff',
            customClass: {
                confirmButton: 'btn px-5'
            },
        })
    @endif
</script>
@stop
