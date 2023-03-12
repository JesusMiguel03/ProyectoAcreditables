@php
    // Modelos
    $materia = atributo($attributes, 'materia');
    $categorias = atributo($attributes, 'categorias');
    $profesores = atributo($attributes, 'profesores');
    $trayectos = atributo($attributes, 'trayectos');
    
    if (!empty($materia)) {
        // Datos de la materia
        $nombre = $materia['nom_materia'];
        $cupos = $materia['cupos'];
        $descripcion = $materia['desc_materia'];
        $estado = $materia['estado_materia'];
        $nro = $materia['trayecto_id'];
        $imagen = $materia['imagen_materia'];
    
        // Relacion
        $info = $materia->info;
        $metodologia = !empty($info) ? $info->metodologia : '';
    }
@endphp


@if (Route::is('materias.index'))
    {{-- Nombre --}}
    <div class="form-group required mb-3">
        <label for="nom_materia" class="control-label">Nombre</label>
        <div class="input-group">
            <input type="text" name="nom_materia" class="form-control @error('nom_materia') is-invalid @enderror"
                value="{{ old('nom_materia') }}" placeholder="{{ __('Nombre de la materia') }}"
                maxlength="{{ config('variables.materias.nombre') }}" data-nombre="caracteres" autofocus required>

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
                    <input type="number" name="cupos" id="cupos"
                        class="form-control @error('cupos') is-invalid @enderror" value="{{ old('cupos') }}"
                        placeholder="{{ __('Cupos iniciales') }}" maxlength="{{ config('variables.materias.cupos') }}"
                        data-nombre="cupos" required>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-clipboard"></span>
                        </div>
                    </div>

                    @error('Cupos')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            {{-- Numero --}}
            <div class="form-group required col-6">
                <label for="trayecto" class="control-label">Acreditable Nro</label>
                <div class="input-group">
                    <select name="trayecto" class="form-control @error('trayecto') is-invalid @enderror">
                        <option value="0" readonly>Seleccione...</option>

                        @foreach ($trayectos as $trayecto)
                            <option value={{ $trayecto->id }}>
                                {{ $trayecto->num_trayecto }}
                            </option>
                        @endforeach
                    </select>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-list-ol"></span>
                        </div>
                    </div>

                    @error('trayecto')
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
                value="{{ old('desc_materia') }}" placeholder="{{ __('Descripción') }}" spellcheck="false"
                maxlength="{{ config('variables.materias.descripcion') }}" required></textarea>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-pencil"></span>
                </div>
            </div>

            @error('desc_materia')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
@else
    <div class="form-group required mb-3">
        <div class="row">

            {{-- Nombre --}}
            <div class="col-6">
                <label for="name" class="control-label">Nombre</label>

                <div class="input-group">
                    <input type="text" name="nom_materia" id="nom_materia"
                        class="form-control @error('nom_materia') is-invalid @enderror" value="{{ $nombre }}"
                        placeholder="{{ __('Nombre de la materia') }}"
                        maxlength="{{ config('variables.materias.nombre') }}" data-nombre="caracteres" autofocus
                        required>

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
                        value="{{ $cupos }}" placeholder="{{ __('Cupos disponibles') }}"
                        maxlength="{{ config('variables.materias.cupos') }}" data-nombre="cupos" required>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-clipboard"></span>
                        </div>
                    </div>

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
                placeholder="{{ __('Descripción') }}" spellcheck="false"
                maxlength="{{ config('variables.materias.descripcion') }}" required>{{ $descripcion }}</textarea>

            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-pencil"></span>
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

                    <select id="estado_materia" class="form-control @error('estado_materia') is-invalid @enderror"
                        name="estado_materia">
                        <option value="0" readonly>Seleccione...</option>

                        <option value="Inactivo" {{ $estado === 'Inactivo' ? 'selected' : '' }}>
                            Inactivo
                        </option>
                        <option value="Activo" {{ $estado === 'Activo' ? 'selected' : '' }}>
                            Activo
                        </option>
                        <option value="En progreso" {{ $estado === 'En progreso' ? 'selected' : '' }}>
                            En progreso
                        </option>
                        <option value="Finalizado" {{ $estado === 'Finalizado' ? 'selected' : '' }}>
                            Finalizado
                        </option>
                        <option value="Descontinuado" {{ $estado === 'Descontinuado' ? 'selected' : '' }}>
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
                <label for="trayecto" class="control-label">Acreditable Nro</label>
                <div class="input-group">
                    <select name="trayecto" class="form-control @error('trayecto') is-invalid @enderror">
                        <option value="0" readonly>Seleccione...</option>

                        @foreach ($trayectos as $trayecto)
                            <option value={{ $trayecto->id }} {{ $nro === $trayecto->id ? 'selected' : '' }}>
                                {{ $trayecto->num_trayecto }}
                            </option>
                        @endforeach
                    </select>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-list-ol"></span>
                        </div>
                    </div>

                    @error('trayecto')
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
                    @if ($categorias->isEmpty())
                        <x-elementos.vacio :modelo="'categorías'" />
                    @else
                        <select id="categoria" class="form-control @error('categoria') is-invalid @enderror"
                            name="categoria">

                            <option value="0" readonly>
                                Seleccione...
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
                    @endif

                </div>
            </div>

            {{-- Metodologia --}}
            <div class="col-6">
                <label for="metodologia">Metodología</label>

                <div class="input-group">
                    <select id="metodologia" class="form-control @error('metodologia') is-invalid @enderror"
                        name="metodologia">

                        <option value="0" readonly>Seleccione...</option>

                        <option value="Teórico" {{ $metodologia === 'Teórico' ? 'selected' : '' }}>
                            Teórico
                        </option>
                        <option value="Práctico" {{ $metodologia === 'Práctico' ? 'selected' : '' }}>
                            Prático
                        </option>
                        <option value="Teórico-Práctico" {{ $metodologia === 'Teórico-Práctico' ? 'selected' : '' }}>
                            Teórico-Práctico
                        </option>
                    </select>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-chalkboard-teacher"></span>
                        </div>
                    </div>

                    @error('metodologia')
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
            @if (empty($profesores))
                <x-elementos.vacio :modelo="'profesores'" />
            @else
                <select id="profesor" class="form-control @error('profesor') is-invalid @enderror" name="profesor">

                    <option value="0" readonly> Seleccione... </option>

                    @foreach ($profesores as $profesor)
                        <option value="{{ $profesor->id }}"
                            {{ !empty($info) && $info->profesor_id === $profesor->id ? 'selected' : '' }}>
                            {{ $profesor->nombreProfesor() }} ({{ $profesor->profesorCI() }})
                        </option>
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
            @endif

        </div>
    </div>
@endif

{{-- Imagen (opcional) --}}
<div class="form-group mb-3">
    <label for="imagen_materia">Imagen</label>

    <div class="input-group">
        <input type="file" class="custom-file-input @error('imagen_materia') is-invalid @enderror" id="imagen"
            name="imagen_materia" accept="image/jpeg" >
            
            <label class="custom-file-label text-muted" for="imagen_materia" id="campoImagen">
                {{ !empty($imagen) ? Str::substr($imagen, 18) : 'Seleccione una imagen' }}
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

{{-- Previsualizacion de imagen --}}
@if (Route::is('materias.edit'))
    <div class="mb-3 text-center">
        <img src="{{ $imagen === null ? asset('vendor/img/defecto/materias.png') : asset('storage/' . $imagen) }}"
            alt="{{ $imagen === null ? 'Imagen de materia por defecto' : 'Imagen de materia' }}" id="previsualizar"
            class="rounded img-fluid">
    </div>
@else
    <div class="card" style="max-width: 540px">
        <img src="" alt="" id="previsualizar" class="rounded">
    </div>
@endif


<x-modal.mensaje-obligatorio />
@if (Route::is('materias.edit'))
    <x-modal.footer-editar ruta="{{ route('materias.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif
