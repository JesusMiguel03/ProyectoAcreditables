@extends('adminlte::page')

@section('title', 'Acreditables | Editar curso')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('Cursos.index') }}">Cursos</a></li>
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
    
                        <h2 class="card-header">Editar Curso</h2>
    
                        <form action="{{ url('/Cursos/' . $course->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            {{ method_field('PATCH') }}
    
                            <div class="bs-stepper">
                                <div class="bs-stepper-header my-2" role="tablist">
                                    <div class="step" data-target="#basic-info">
                                        <button type="button" class="step-trigger" role="tab" aria-controls="basic-info"
                                            id="basic-info-trigger">
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
                                        <button type="button" class="step-trigger" role="tab" aria-controls="image-details"
                                            id="image-details-trigger">
                                            <span class="bs-stepper-circle">3</span>
                                            <span class="bs-stepper-label">Final</span>
                                        </button>
                                    </div>
                                </div>
    
                                <div class="bs-stepper-content">
                                    <div id="basic-info" class="content" role="tabpanel" aria-labelledby="basic-info-trigger">
                                        {{-- Part 1 --}}
                                        {{-- Name field --}}
                                        <div class="form-group mb-3">
                                            <label for="name">Nombre</label>
                                            <input type="text" name="name" id="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $course['name'] }}" placeholder="{{ __('Nombre del curso') }}"
                                                autofocus>
    
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
    
                                        {{-- Quotas field --}}
                                        <div class="form-group mb-3">
                                            <label for="quotas">Cupos</label>
                                            <input type="number" name="quotas" id="quotas"
                                                class="form-control @error('quotas') is-invalid @enderror" id="quotas"
                                                value="{{ $course['quotas'] }}"
                                                placeholder="{{ __('Cupos disponibles, límite: ') }}" autofocus>
    
                                            @error('quotas')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
    
                                        {{-- Description field --}}
                                        <div class="form-group mb-3">
                                            <label for="description">Descripción</label>
                                            <input type="text" name="description" id="description"
                                                class="form-control @error('description') is-invalid @enderror"
                                                value="{{ $course['description'] }}" placeholder="{{ __('Descripción') }}"
                                                autofocus>
    
                                            @error('description')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
    
                                    {{-- Part 2 --}}
                                    <div id="course-details" class="content" role="tabpanel"
                                        aria-labelledby="course-details-trigger">
                                        {{-- Professor field --}}
                                        <div class="form-group mb-3">
                                            <label for="professor">Profesor</label>
                                            <input type="text" name="professor" id="professor"
                                                class="form-control @error('professor') is-invalid @enderror"
                                                value="{{ $course['professor'] }}"
                                                placeholder="{{ __('Profesor encargado') }}" autofocus>
    
                                            @error('professor')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
    
                                        {{-- Category field --}}
                                        <div class="form-group mb-3">
                                            <label for="category">Categoria</label>
                                            <select id="category"
                                                class="form-control @error('category') is-invalid @enderror" name="category">
                                                <option {{ $course['category'] === 'Categoria' ? 'selected' : '' }}>Categoria
                                                </option>
                                                <option {{ $course['category'] === '1' ? 'selected' : '' }}>1</option>
                                                <option {{ $course['category'] === '2' ? 'selected' : '' }}>2</option>
                                                <option {{ $course['category'] === '3' ? 'selected' : '' }}>3</option>
                                            </select>
    
                                            @error('category')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
    
                                        {{-- Type field --}}
                                        <div class="form-group mb-3">
                                            <label for="type">Tipo</label>
                                            <select id="type" class="form-control @error('type') is-invalid @enderror"
                                                name="type">
                                                <option {{ $course['type'] === 'Tipo' ? 'selected' : '' }}>Tipo</option>
                                                <option {{ $course['type'] === 'Teórico' ? 'selected' : '' }}>Teórico</option>
                                                <option {{ $course['type'] === 'Práctico' ? 'selected' : '' }}>Práctico
                                                </option>
                                                <option {{ $course['type'] === 'Teórico - práctico' ? 'selected' : '' }}>
                                                    Teórico - práctico
                                                </option>
                                            </select>
    
                                            @error('type')
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
                                                class="custom-file-input @error('image') is-invalid @enderror" id="image"
                                                name="image" accept="image/jpeg">
                                            <label class="custom-file-label text-muted" for="image"
                                                id="imageLabel">{{ Str::substr($course['image'], 18) }}</label>
                                            <small id="imageHelp" class="form-text text-muted">La imagen debe pesar menos de 1
                                                MB.</small>
    
                                            @error('image')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
    
                                        {{-- Image preview --}}
                                        <div class="card">
                                            <img src="{{ asset('storage/' . $course['image']) }}" alt=""
                                                id="preview" class="rounded img-fluid">
                                        </div>
    
                                        {{-- Login field --}}
                                        <div class="row">
                                            <div class="col-6">
                                                <a href="{{ route('Cursos.index') }}" class="btn btn-block btn-secondary">
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
        document.querySelectorAll('p').forEach(item => {
            item.innerText === 'Cursos' ?
                item.parentNode.classList.add('active') : ""
        })
    </script>
    
    <script>
        const file = document.getElementById('image')
        const preview = document.getElementById('preview')
        const imageLabel = document.getElementById('imageLabel')

        file.addEventListener('change', e => {
            if (e.target.files.length === 1) {
                const reader = new FileReader()
                const files = e.target.files[0]
                reader.readAsDataURL(files)
                reader.onload = function() {
                    temp = reader.result
                }
                preview.src = URL.createObjectURL(files)
                imageLabel.innerHTML = e.target.files[0].name
            } else {
                preview.src = ""
                imageLabel.innerHTML = ""
            }
        })
    </script>
@stop
