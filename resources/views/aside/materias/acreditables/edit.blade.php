@extends('adminlte::page')

@section('title', 'Acreditables | Editar materia')

@section('content_header')
    <x-tipografia.titulo>Materias</x-tipografia.titulo>

    <div class="col-6">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Cursos</a></li>
            <li class="breadcrumb-item active"><a href="">Editar</a></li>
        </ol>
    </div>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">

        <div class="card">

            <header class="card-header bg-primary">
                <h5>Editar materia - {{ $materia->nom_materia }}</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('materias.update', $materia->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}

                    {{-- Nombre y cupos --}}
                    <div class="form-group required mb-3">
                        <div class="row">

                            {{-- Nombre --}}
                            <div class="col-6">
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
                            <div class="col-6">
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

                        </div>
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

                    {{-- Estado y nro de acreditable --}}
                    <div class="form-group mb-3">
                        <div class="row">

                            <div class="col-6">
                                <label for="description" class="control-label">Estado</label>
                                <select id="estado_materia"
                                    class="form-control @error('estado_materia') is-invalid @enderror"
                                    name="estado_materia">
                                    <option value="0" disabled readonly>Seleccione uno</option>
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

                            <div class="col-6">
                                <label for="num_acreditable" class="control-label">Acreditable Nro</label>
                                <select name="num_acreditable"
                                    class="form-control @error('num_acreditable') is-invalid @enderror">
                                    <option value="0" disabled readonly>Seleccione uno</option>
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

                        </div>
                    </div>

                    {{-- Categoria y tipo --}}
                    <div class="form-group">
                        <div class="row">
                            {{-- Categoria --}}
                            <div class="col-6">
                                <label for="categoria">Categoria</label>
                                <select id="categoria" class="form-control @error('categoria') is-invalid @enderror"
                                    name="categoria">
                                    @if ($profesores->isEmpty())
                                        <option value="0">No hay categorias añadidas</option>
                                    @else
                                        <option value="0" disabled readonly>Seleccione uno</option>
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
                            <div class="col-6">
                                <label for="tipo">Tipo de aprendizaje</label>
                                <select id="tipo" class="form-control @error('tipo') is-invalid @enderror"
                                    name="tipo">
                                    <option value="0" disabled readonly>Seleccione uno</option>
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
                        </div>
                    </div>

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

                    {{-- Campo de imagen --}}
                    <div class="form-group mb-3">
                        <label for="imagen_materia">Imágen</label>
                        <div class="input-group">
                            <input type="file" class="custom-file-input @error('imagen_materia') is-invalid @enderror"
                                id="imagen_materia" name="imagen_materia" accept="image/jpeg">
                            <label class="custom-file-label text-muted" for="imagen_materia"
                                id="campoImagen">{{ Str::substr($materia->imagen_materia, 18) }}</label>
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
                    </div>

                    {{-- Previsualizacion de imagen --}}
                    <div class="mb-3 text-center">
                        @if ($materia->imagen_materia !== null)
                            <img src="{{ asset('storage/' . $materia->imagen_materia) }}" alt=""
                                id="previsualizar" class="rounded img-fluid">
                        @else
                            <img src="{{ asset('vendor/img/defecto/materias.png') }}" alt="Imagen de materia por defecto"
                                id="previsualizar" class="rounded img-fluid">
                        @endif
                    </div>

                    {{-- Botones / acciones --}}
                    <div class="row">
                        <div class="col-6">
                            <a href="{{ route('materias.index') }}" class="btn btn-block btn-secondary">
                                <i class="fas fa-arrow-circle-left mr-2"></i>
                                {{ __('Volver') }}
                            </a>
                        </div>
                        <x-botones.guardar />
                    </div>

                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <style>
        .custom-file-label::after {
            content: "Buscar";
        }
    </style>

    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
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
