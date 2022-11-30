@extends('adminlte::page')

@section('title', 'Acreditables | Editar materia')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Cursos</a></li>
                <li class="breadcrumb-item active"><a href="">Editar Materia</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card my-3">

        <header class="card-header bg-primary">
            <h5>Editar materia - {{ $materia->nom_materia }}</h5>
        </header>

        <main class="card-body">
            <form action="{{ route('materias.update', $materia->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}

                <div class="bs-stepper">

                    <div class="bs-stepper-header my-2" role="tablist">

                        {{-- Icono y burbujas de texto (pasos) --}}
                        <div class="step" data-target="#basic-info">
                            <button type="button" class="step-trigger" role="tab" aria-controls="basic-info"
                                id="basic-info-trigger">
                                <span class="bs-stepper-circle">1</span>
                                <span class="bs-stepper-label">Básico</span>
                            </button>
                        </div>

                        <div class="line"></div>

                        <div class="step" data-target="#course-details">
                            <button type="button" class="step-trigger" role="tab" aria-controls="course-details"
                                id="course-details-trigger">
                                <span class="bs-stepper-circle">2</span>
                                <span class="bs-stepper-label">Detalles</span>
                            </button>
                        </div>

                        <div class="line"></div>

                        <div class="step" data-target="#image-details">
                            <button type="button" class="step-trigger" role="tab" aria-controls="image-details"
                                id="image-details-trigger">
                                <span class="bs-stepper-circle">3</span>
                                <span class="bs-stepper-label">Final</span>
                            </button>
                        </div>

                    </div>

                    <div class="bs-stepper-content">

                        {{--            Parte 1            --}}
                        <div id="basic-info" class="content" role="tabpanel" aria-labelledby="basic-info-trigger">

                            {{-- Nombre --}}
                            <div class="form-group required mb-3">
                                <label for="name" class="control-label">Nombre</label>
                                <input type="text" name="nom_materia" id="nom_materia"
                                    class="form-control @error('nom_materia') is-invalid @enderror"
                                    value="{{ $materia->nom_materia }}" placeholder="{{ __('Nombre de la materia') }}"
                                    autofocus required>

                                @error('nom_materia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Cupos --}}
                            <div class="form-group required mb-3">
                                <label for="cupos" class="control-label">Cupos</label>
                                <input type="number" name="cupos" id="cupos"
                                    class="form-control @error('cupos') is-invalid @enderror" id="cupos"
                                    value="{{ $materia->cupos }}" placeholder="{{ __('Cupos disponibles, límite: 50') }}"
                                    autofocus required>

                                @error('cupos')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Descripcion --}}
                            <div class="form-group required mb-3">
                                <label for="description" class="control-label">Descripción</label>
                                <textarea name="desc_materia" class="form-control @error('desc_materia') is-invalid @enderror"
                                    placeholder="{{ __('Descripción') }}" autofocus spellcheck="false" style="min-height: 7rem; resize: none" required>{{ $materia->desc_materia }}</textarea>

                                @error('desc_materia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Estado --}}
                            <div class="form-group required mb-3">
                                <label for="description" class="control-label">Estado</label>
                                <select id="estado_materia"
                                    class="form-control @error('estado_materia') is-invalid @enderror"
                                    name="estado_materia">
                                    <option disabled>Seleccione el estado de la materia</option>
                                    <option value="Inactivo"
                                        {{ $materia->estado_materia === 'Inactivo' ? 'selected' : '' }}>
                                        Inactivo</option>
                                    <option value="Activo" {{ $materia->estado_materia === 'Activo' ? 'selected' : '' }}>
                                        Activo
                                    </option>
                                    <option value="En progreso"
                                        {{ $materia->estado_materia === 'En progreso' ? 'selected' : '' }}>
                                        En
                                        progreso</option>
                                    <option value="Finalizado"
                                        {{ $materia->estado_materia === 'Finalizado' ? 'selected' : '' }}>
                                        Finalizado</option>
                                    <option value="Descontinuado"
                                        {{ $materia->estado_materia === 'Descontinuado' ? 'selected' : '' }}>
                                        Descontinuado</option>
                                </select>

                                @error('estado_materia')
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
                                    <option>Seleccione una</option>
                                    <option value="1" {{ $materia->num_acreditable === 1 ? 'selected' : '' }}>1
                                    </option>
                                    <option value="2" {{ $materia->num_acreditable === 2 ? 'selected' : '' }}>2
                                    </option>
                                    <option value="3" {{ $materia->num_acreditable === 3 ? 'selected' : '' }}>3
                                    </option>
                                    <option value="4" {{ $materia->num_acreditable === 4 ? 'selected' : '' }}>4
                                    </option>
                                </select>

                                @error('num_acreditable')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group" style="margin-bottom: -10px">
                                <p class="pl-2 text-danger"><strong>Nota:</strong> (*) Indica los campos que
                                    son obligatorios.
                                </p>
                            </div>

                        </div>

                        {{--            Parte 2            --}}
                        <div id="course-details" class="content" role="tabpanel"
                            aria-labelledby="course-details-trigger">

                            {{-- Categoria --}}
                            <div class="form-group mb-3">
                                <label for="categoria">Categoria</label>
                                <select id="categoria" class="form-control @error('categoria') is-invalid @enderror"
                                    name="categoria">
                                    @if ($profesores->isEmpty())
                                        <option value="0">No hay categorias añadidas</option>
                                    @else
                                        <option value="0">Seleccione uno</option>
                                    @endif
                                    @foreach ($categorias as $categoria)
                                        <option value="{{ $categoria->id }}"
                                            {{ !empty($materia->info) && $materia->info->categoria_id === $categoria->id ? 'selected' : '' }}>
                                            {{ $categoria->nom_categoria }}</option>
                                    @endforeach
                                </select>

                                @error('categoria')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Tipo --}}
                            <div class="form-group mb-3">
                                <label for="tipo">Tipo de aprendizaje</label>
                                <select id="tipo" class="form-control @error('tipo') is-invalid @enderror"
                                    name="tipo">
                                    <option value="0">Seleccione uno</option>
                                    <option value="Teórico"
                                        {{ !empty($materia->info) && $materia->info->metodologia_aprendizaje === 'Teórico' ? 'selected' : '' }}>
                                        Teórico</option>
                                    <option value="Práctico"
                                        {{ !empty($materia->info) && $materia->info->metodologia_aprendizaje === 'Práctico' ? 'selected' : '' }}>
                                        Prático</option>
                                    <option value="Teórico-Práctico"
                                        {{ !empty($materia->info) && $materia->info->metodologia_aprendizaje === 'Teórico-Práctico' ? 'selected' : '' }}>
                                        Teórico-Práctico</option>
                                </select>

                                @error('tipo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Horario --}}
                            {{-- <div class="form-group mb-3">
                                            <label for="horario">Horario</label>
                                            @if ($horarios->isEmpty())
                                                <input type="text" class="form-control"
                                                    placeholder="{{ __('No hay horarios añadidos') }}" disabled>
                                            @else
                                                <select id="horario"
                                                    class="form-control @error('horario') is-invalid @enderror"
                                                    name="horario">
                                                    @if ($horarios->isEmpty())
                                                        <option>No hay horarios añadidas</option>
                                                    @else
                                                        <option>Seleccione una categoria</option>
                                                    @endif
                                                    @foreach ($horarios as $horario)
                                                        <option value="{{ $horario->id }}"
                                                            {{ !empty($materia->info) && $materia->info->horario_id === $horario->id ? 'selected' : '' }}>
                                                            {{ $horario->dia }}, {{ $horario->hora }}
                                                            {{ $horario->dia_noche }}</option>
                                                    @endforeach
                                                </select>
                                            @endif

                                            @error('horario')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div> --}}

                            {{-- Profesor --}}
                            <div class="form-group mb-3">
                                <label for="profesor">Profesor</label>
                                <select id="profesor" class="form-control @error('profesor') is-invalid @enderror"
                                    name="profesor">
                                    @if ($profesores->isEmpty())
                                        <option value="0">No hay profesores añadidos</option>
                                    @else
                                        <option value="0">Seleccione uno</option>
                                    @endif
                                    @foreach ($profesores as $profesor)
                                        <option value="{{ $profesor->id }}"
                                            {{ !empty($materia->info) && $materia->info->profesor_id === $profesor->id ? 'selected' : '' }}>
                                            {{ $profesor->usuario->nombre }}
                                            {{ $profesor->usuario->apellido }}</option>
                                    @endforeach
                                </select>

                                @error('profesor')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                        </div>

                        {{--            Parte 3            --}}
                        <div id="image-details" class="content" role="tabpanel" aria-labelledby="image-details-trigger">

                            {{-- Campo de imagen --}}
                            <div class="input-group mb-3">
                                <input type="file"
                                    class="custom-file-input @error('imagen_materia') is-invalid @enderror"
                                    id="imagen_materia" name="imagen_materia" accept="image/jpeg">
                                <label class="custom-file-label text-muted" for="imagen_materia"
                                    id="campoImagen">{{ Str::substr($materia['imagen_materia'], 18) }}</label>
                                <small id="imageHelp" class="form-text text-muted">La imagen debe pesar
                                    menos
                                    de
                                    1
                                    MB.</small>

                                @error('imagen_materia')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Previsualizacion de imagen --}}
                            <div class="mx-auto mb-3" style="max-width: 50vw">
                                @if ($materia->imagen_materia !== null)
                                    <img src="{{ asset('storage/' . $materia->imagen_materia) }}" alt=""
                                        id="previsualizar" class="rounded img-fluid">
                                @else
                                    <div class="card-body">
                                        <img src="" alt="" id="previsualizar" class="rounded img-fluid">
                                        <h5 id="noImagen" class="text-muted">El curso no posee una imagen
                                            para poder
                                            mostrarla</h5>
                                    </div>
                                @endif
                            </div>

                            {{-- Botones / acciones --}}
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('materias.index') }}" class="btn btn-block btn-secondary">
                                        {{ __('Volver') }}
                                    </a>
                                </div>
                                <div class="col-6">
                                    <button type=submit class="btn btn-block btn-success">
                                        {{ __('Guardar') }}
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </form>
        </main>
    </div>
@stop

@section('css')
    <style>
        .custom-file-label::after {
            content: "Buscar";
        }
        .form-group.required .control-label:after {
            color: #d00;
            content: "*";
            position: absolute;
            margin-left: 6px;
            margin-top: 3px;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('vendor/bs-stepper/css/bs-stepper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/bs-stepper/js/bs-stepper.min.js') }}"></script>
    <script src="{{ asset('js/previsualizacion.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            const stepper = new Stepper($('.bs-stepper')[0], {
                linear: false,
                animation: true
            })
        })
    </script>
    <script>
        @if ($message = session('error'))
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
        @endif
    </script>
@stop
