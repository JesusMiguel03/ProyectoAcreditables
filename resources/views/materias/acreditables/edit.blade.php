@extends('adminlte::page')

@section('title', 'Acreditables | Editar materia')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('materias.index') }}" class="link-muted">Cursos</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Materias</x-tipografia.titulo>
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

                    <div class="form-group required mb-3">
                        <div class="row">

                            {{-- Nombre --}}
                            <div class="col-6">
                                <label for="name" class="control-label">Nombre</label>
                                <div class="input-group">
                                    <input type="text" name="nom_materia" id="nom_materia"
                                        class="form-control @error('nom_materia') is-invalid @enderror"
                                        value="{{ $materia->nom_materia }}" placeholder="{{ __('Nombre de la materia') }}"
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

                            {{-- Cupos --}}
                            <div class="col-6">
                                <label for="cupos" class="control-label">Cupos</label>
                                <div class="input-group">
                                    <input type="number" name="cupos" id="cupos"
                                        class="form-control @error('cupos') is-invalid @enderror" id="cupos"
                                        value="{{ $materia->cupos }}" placeholder="{{ __('Cupos disponibles, límite: 50') }}"
                                        required>
    
                                    @error('cupos')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- Descripcion --}}
                    <div class="form-group required mb-3">
                        <label for="description" class="control-label">Descripción</label>
                        <div class="input-group">
                            <textarea name="desc_materia" class="form-control @error('desc_materia') is-invalid @enderror descripcion"
                                placeholder="{{ __('Descripción') }}" spellcheck="false" required>{{ $materia->desc_materia }}</textarea>

                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-comment"></span>
                                    </div>
                                </div>
    
                            @error('desc_materia')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <div class="row">

                            {{-- Activo --}}
                            <div class="col-6">
                                <label for="description" class="control-label">Estado</label>
                                <div class="input-group">

                                    <select id="estado_materia"
                                        class="form-control @error('estado_materia') is-invalid @enderror"
                                        name="estado_materia">
                                        <option value="0" disabled readonly>Seleccione uno</option>
                                        <option value="Inactivo"
                                            {{ $materia->estado_materia === 'Inactivo' ? 'selected' : '' }}>
                                            Inactivo
                                        </option>
                                        <option value="Activo" {{ $materia->estado_materia === 'Activo' ? 'selected' : '' }}>
                                            Activo
                                        </option>
                                        <option value="En progreso"
                                            {{ $materia->estado_materia === 'En progreso' ? 'selected' : '' }}>
                                            En progreso
                                        </option>
                                        <option value="Finalizado"
                                            {{ $materia->estado_materia === 'Finalizado' ? 'selected' : '' }}>
                                            Finalizado
                                        </option>
                                        <option value="Descontinuado"
                                            {{ $materia->estado_materia === 'Descontinuado' ? 'selected' : '' }}>
                                            Descontinuado
                                        </option>
                                    </select>
    
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-eye"></span>
                                        </div>
                                    </div>
    
                                    @error('estado_materia')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Numero --}}
                            <div class="col-6">
                                <label for="num_acreditable" class="control-label">Acreditable Nro</label>
                                <div class="input-group">
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

                    <div class="form-group">
                        <div class="row">

                            {{-- Categoria --}}
                            <div class="col-6">
                                <label for="categoria">Categoria</label>
                                <div class="input-group">
                                    <select id="categoria" class="form-control @error('categoria') is-invalid @enderror"
                                        name="categoria">
                                        <option value="0" {{ !$categorias->isEmpty() ? 'disabled readonly' : '' }}>
                                            {{ $categorias->isEmpty() ? 'No hay categorias añadidas' : 'Seleccione uno'  }}
                                        </option>
                                        @foreach ($categorias as $categoria)
                                            <option value="{{ $categoria->id }}"
                                                {{ !empty($materia->info) && $materia->info->categoria_id === $categoria->id ? 'selected' : '' }}>
                                                {{ $categoria->nom_categoria }}</option>
                                        @endforeach
                                    </select>

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-tags"></span>
                                        </div>
                                    </div>
    
                                    @error('categoria')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tipo --}}
                            <div class="col-6">
                                <label for="tipo">Tipo de aprendizaje</label>
                                <div class="input-group">
                                    <select id="tipo" class="form-control @error('tipo') is-invalid @enderror"
                                        name="tipo">
                                        <option value="0" disabled readonly>Seleccione uno</option>
                                        <option value="Teórico"
                                            {{ !empty($materia->info) && $materia->info->metodologia_aprendizaje === 'Teórico' ? 'selected' : '' }}>
                                            Teórico
                                        </option>
                                        <option value="Práctico"
                                            {{ !empty($materia->info) && $materia->info->metodologia_aprendizaje === 'Práctico' ? 'selected' : '' }}>
                                            Prático
                                        </option>
                                        <option value="Teórico-Práctico"
                                            {{ !empty($materia->info) && $materia->info->metodologia_aprendizaje === 'Teórico-Práctico' ? 'selected' : '' }}>
                                            Teórico-Práctico
                                        </option>
                                    </select>
    
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-chalkboard-teacher"></span>
                                        </div>
                                    </div>
    
                                    @error('tipo')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Profesor --}}
                    <div class="form-group mb-3">
                        <label for="profesor">Profesor</label>
                        <div class="input-group">
                            <select id="profesor" class="form-control @error('profesor') is-invalid @enderror"
                                name="profesor">
                                <option value="0" {{ !$profesores->isEmpty() ? 'disabled readonly' : '' }}>
                                    {{ $profesores->isEmpty() ? 'No hay profesores añadidos' : 'Seleccione uno'  }}
                                </option>
                                @foreach ($profesores as $profesor)
                                    <option value="{{ $profesor->id }}"
                                        {{ !empty($materia->info) && $materia->info->profesor_id === $profesor->id ? 'selected' : '' }}>
                                        {{ $profesor->usuario->nombre }}
                                        {{ $profesor->usuario->apellido }}</option>
                                @endforeach
                            </select>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user-tie"></span>
                                </div>
                            </div>
    
                            @error('profesor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Horario --}}
                    <div class="form-group mb-3">
                        <label for="horario">Horario</label>
                        <div class="input-group">
                            <select id="horario" class="form-control @error('horario') is-invalid @enderror"
                                name="horario">
                                <option value="0" {{ !$horarios->isEmpty() ? 'disabled readonly' : '' }}>
                                    {{ $horarios->isEmpty() ? 'No hay horarios añadidos' : 'Seleccione uno'  }}
                                </option>
                                @foreach ($horarios as $horario)
                                    <option value="{{ $horario->id }}"
                                        {{ !empty($materia->info) && $materia->info->horario_id === $horario->id ? 'selected' : '' }}>
                                        [{{ $horario->espacio }} {{ $horario->edificio_numero }}]
                                        {{ diaSemana($horario->dia) }} -
                                        {{ \Carbon\Carbon::parse($horario->hora)->format('g:i A') }}
                                    </option>
                                @endforeach
                            </select>

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-clock"></span>
                                </div>
                            </div>
    
                            @error('horario')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Campo de imagen --}}
                    <div class="form-group mb-3">
                        <label for="imagen_materia">Imágen</label>
                        <div class="input-group">
                            <input type="file" class="custom-file-input @error('imagen_materia') is-invalid @enderror"
                                id="imagen" name="imagen_materia" accept="image/jpeg">
                            <label class="custom-file-label text-muted" for="imagen_materia"
                                id="campoImagen">{{ Str::substr($materia->imagen_materia, 18) }}</label>
                            <small id="imageHelp" class="form-text text-muted">
                                La imagen debe pesar menos de 1 MB.
                            </small>

                            @error('imagen_materia')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    {{-- Previsualizacion de imagen --}}
                    <div class="mb-3 text-center">
                        <img src="{{ $materia->imagen_materia === null ? asset('vendor/img/defecto/materias.png') : asset('storage/' . $materia->imagen_materia) }}"
                            alt="{{ $materia->imagen_materia === null ? 'Imagen de materia por defecto' : 'Imagen de materia' }}"
                            id="previsualizar" class="rounded img-fluid">
                    </div>

                    <x-modal.footer-editar ruta="{{ route('materias.index') }}" />

                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">

    {{-- Personalizados --}}
    <link rel="stylesheet" href="{{ asset('css/buscar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Personalizados --}}
    <script src="{{ asset('js/previsualizacion.js') }}"></script>

    {{-- Mensajes --}}
    <script>
        @if ($message = session('error'))
            let timerInterval
            Swal.fire({
                icon: 'error',
                title: '¡No se pudo registrar!',
                html: 'Uno de los campos no cumple los requisitos.',
                confirmButtonColor: '#dc3545',
                customClass: {
                    confirmButton: 'btn px-5'
                },
            })
        @endif
    </script>
@stop
