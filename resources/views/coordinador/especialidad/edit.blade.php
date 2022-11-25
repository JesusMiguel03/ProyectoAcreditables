@extends('adminlte::page')

@section('title', 'Acreditables | Editar curso')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('cursos.index') }}">Cursos</a></li>
                <li class="breadcrumb-item active"><a href="">Editar Curso</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="container">
            <div class="card p-4">

                <div class="row">
                    <div class="col-md-12">

                        <h2 class="card-header">Editar Curso - {{ $curso['nombre'] }}</h2>

                        <form action="{{ url('/cursos/' . $curso->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PATCH') }}

                            <div class="bs-stepper">
                                <div class="bs-stepper-header my-2" role="tablist">
                                    <div class="step" data-target="#basic-info">
                                        <button type="button" class="step-trigger" role="tab"
                                            aria-controls="basic-info" id="basic-info-trigger">
                                            <span class="bs-stepper-circle">1</span>
                                            <span class="bs-stepper-label">Básico</span>
                                        </button>
                                    </div>

                                    <div class="line"></div>

                                    <div class="step" data-target="#course-details">
                                        <button type="button" class="step-trigger" role="tab"
                                            aria-controls="course-details" id="course-details-trigger">
                                            <span class="bs-stepper-circle">2</span>
                                            <span class="bs-stepper-label">Detalles</span>
                                        </button>
                                    </div>

                                    <div class="line"></div>

                                    <div class="step" data-target="#image-details">
                                        <button type="button" class="step-trigger" role="tab"
                                            aria-controls="image-details" id="image-details-trigger">
                                            <span class="bs-stepper-circle">3</span>
                                            <span class="bs-stepper-label">Final</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="bs-stepper-content">
                                    <div id="basic-info" class="content" role="tabpanel"
                                        aria-labelledby="basic-info-trigger">
                                        {{-- Part 1 --}}
                                        {{-- Name field --}}
                                        <div class="form-group mb-3">
                                            <label for="name">Nombre</label>
                                            <input type="text" name="nombre" id="nombre"
                                                class="form-control @error('nombre') is-invalid @enderror"
                                                value="{{ $curso['nombre'] }}" placeholder="{{ __('Nombre del curso') }}"
                                                autofocus>

                                            @error('nombre')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Quotas field --}}
                                        <div class="form-group mb-3">
                                            <label for="quotas">Cupos</label>
                                            <input type="number" name="cupos" id="cupos"
                                                class="form-control @error('cupos') is-invalid @enderror" id="cupos"
                                                value="{{ $curso['cupos'] }}"
                                                placeholder="{{ __('Cupos disponibles, límite: ') }}" autofocus>

                                            @error('cupos')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Description field --}}
                                        <div class="form-group mb-3">
                                            <label for="description">Descripción</label>
                                            <input type="text" name="descripcion" id="descripcion"
                                                class="form-control @error('descripcion') is-invalid @enderror"
                                                value="{{ $curso['descripcion'] }}" placeholder="{{ __('Descripción') }}"
                                                autofocus>

                                            @error('descripcion')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    {{-- Part 2 --}}
                                    <div id="course-details" class="content" role="tabpanel"
                                        aria-labelledby="course-details-trigger">

                                        {{-- Categoria --}}
                                        <div class="form-group mb-3">
                                            <label for="categoria">Categoria</label>
                                            <select id="categoria"
                                                class="form-control @error('categoria') is-invalid @enderror"
                                                name="categoria">
                                                @foreach ($categorias as $categoria)
                                                    <option value="{{ $categoria['id'] }}"
                                                        {{ $categoria['nombre'] === '' ? 'selected' : '' }}>
                                                        {{ $categoria->nombre }}</option>
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
                                            <label for="tipo">Tipo</label>
                                            <select id="tipo"
                                                class="form-control @error('tipo') is-invalid @enderror" name="tipo">
                                                @foreach ($tipos as $tipo)
                                                    <option value="{{ $tipo['id'] }}"
                                                        {{ $tipo['nombre'] === 'tipo' ? 'selected' : '' }}>
                                                        {{ $tipo->nombre }}</option>
                                                @endforeach
                                            </select>

                                            @error('tipo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Aula --}}
                                        <div class="form-group mb-3">
                                            <label for="aula">Aula</label>
                                            <select id="aula"
                                                class="form-control @error('aula') is-invalid @enderror" name="aula">
                                                @foreach ($aulas as $aula)
                                                    <option value="{{ $aula['id'] }}"
                                                        {{ $aula['edificio'] }}{{ $aula['numero'] === 'aula' ? 'selected' : '' }}>
                                                        {{ $aula['edificio'] }}{{ $aula['numero'] }}</option>
                                                @endforeach
                                            </select>

                                            @error('aula')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Horario --}}
                                        <div class="form-group mb-3">
                                            <label for="horario">Horario</label>
                                            <select id="horario"
                                                class="form-control @error('horario') is-invalid @enderror"
                                                name="horario">
                                                @foreach ($horarios as $horario)
                                                    <option value="{{ $horario['id'] }}">
                                                        {{ $horario['dia'] }}, {{ $horario['hora'] }}
                                                        {{ $horario['dia_noche'] }}</option>
                                                @endforeach
                                            </select>

                                            @error('horario')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Modalidad --}}
                                        <div class="form-group mb-3">
                                            <label for="modalidad">Modalidad</label>
                                            <select id="modalidad"
                                                class="form-control @error('modalidad') is-invalid @enderror"
                                                name="modalidad">
                                                @foreach ($modalidades as $modalidad)
                                                    <option value="{{ $modalidad['id'] }}">
                                                        {{ $modalidad['nombre'] }}</option>
                                                @endforeach
                                            </select>

                                            @error('modalidad')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                    </div>

                                    {{-- Part 3 --}}
                                    <div id="image-details" class="content" role="tabpanel"
                                        aria-labelledby="image-details-trigger">
                                        {{-- Image field --}}
                                        <div class="input-group mb-3">
                                            <input type="file"
                                                class="custom-file-input @error('imagen') is-invalid @enderror"
                                                id="imagen" name="imagen" accept="image/jpeg">
                                            <label class="custom-file-label text-muted" for="imagen"
                                                id="campoImagen">{{ Str::substr($curso['imagen'], 18) }}</label>
                                            <small id="imageHelp" class="form-text text-muted">La imagen debe pesar menos
                                                de
                                                1
                                                MB.</small>

                                            @error('imagen')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        {{-- Image preview --}}
                                        <div class="card">
                                            @if ($curso['imagen'] !== null)
                                                <img src="{{ asset('storage/' . $curso['imagen']) }}" alt=""
                                                    id="previsualizar" class="rounded img-fluid">
                                            @else
                                                <div class="card-body">
                                                    <img src="" alt="" id="previsualizar"
                                                        class="rounded img-fluid">
                                                    <h5 id="noImagen" class="text-muted">El curso no posee una imagen
                                                        para poder
                                                        mostrarla</h5>
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Login field --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <a href="{{ route('cursos.index') }}"
                                                    class="btn btn-block btn-secondary">
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

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('css')
    <style>
        .custom-file-label::after {
            content: "Buscar";
        }
    </style>

    <link rel="stylesheet" href="{{ asset('/vendor/bs-stepper/css/bs-stepper.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('/vendor/bs-stepper/js/bs-stepper.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            const stepper = new Stepper($('.bs-stepper')[0], {
                linear: false,
                animation: true
            })
        })
    </script>

    <script>
        const archivo = document.getElementById('imagen')
        const previsualizar = document.getElementById('previsualizar')
        const campoImagen = document.getElementById('campoImagen')
        const textoSiNoHayImagen = document.getElementById('noImagen')

        archivo.addEventListener('change', e => {
            if (e.target.files.length === 1) {
                const lector = new FileReader()
                const archivos = e.target.files[0]
                lector.readAsDataURL(archivos)
                lector.onload = function() {
                    temp = lector.result
                }
                console.log(URL.createObjectURL(archivos));
                previsualizar.src = URL.createObjectURL(archivos)
                campoImagen.innerHTML = e.target.files[0].name
                textoSiNoHayImagen.style.display = "none"
            } else {
                previsualizar.src = ""
                campoImagen.innerHTML = ""
                textoSiNoHayImagen.style.display = "block"
            }
        })
    </script>
@stop
