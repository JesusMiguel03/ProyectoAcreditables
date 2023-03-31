@php
    $noticia = atributo($attributes, 'noticia');
    
    if (!empty($noticia)) {
        $titulo = $noticia->titulo;
        $descripcion = $noticia->desc_noticia;
        $activo = $noticia->activo;
        $imagen = $noticia->imagen_noticia;
    
        if (request()->secure()) {
            $imagen = !empty($imagen) ? secure_asset('storage/' . $imagen) : secure_asset('vendor/img/defecto/noticias.png');
        } else {
            $imagen = !empty($imagen) ? asset('storage/' . $imagen) : asset('vendor/img/defecto/noticias.png');
        }
    } else {
        $activo = '';
    }
@endphp

{{-- Titulo --}}
<div class="form-group required mb-3">
    <label for="titulo" class="control-label">Título</label>

    <div class="input-group">
        <input type="text" id="titulo" name="titulo" class="form-control @error('titulo') is-invalid @enderror"
            value="{{ $titulo ?? old('titulo') }}" placeholder="{{ __('Nombre de la noticia, ej: Nueva acreditable') }}"
            maxlength="{{ config('variables.noticias.titulo') }}" pattern="[A-zÀ-ÿ0-9\s]+"
            title="Debe estar entre 5 y 30 letras." autofocus required>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-heading"></span>
            </div>
        </div>

        @error('titulo')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Descripcion --}}
<div class="form-group required mb-3">
    <label for="desc_noticia" class="control-label">Descripción</label>

    <div class="input-group">
        <textarea id="descripcion" name="desc_noticia"
            class="form-control @error('desc_noticia') is-invalid @enderror descripcion" spellcheck="false"
            placeholder="{{ __('Descripción, ej: Una nueva acreditable ha sido registrada') }}"
            maxlength="{{ config('variables.noticias.descripcion') }}" required pattern="[A-zÀ-ÿ0-9\s]+"
            title="Debe estar entre 15 y 100 letras.">{{ $descripcion ?? old('desc_noticia') }}</textarea>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-pencil"></span>
            </div>
        </div>

        @error('desc_noticia')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Mostrar noticia --}}
<div class="form-group required mb-3">
    <label for="activo" class="control-label">¿Mostrar noticia?</label>

    <div class="input-group">
        <select id="mostrar" name="activo" class="form-control @error('activo') is-invalid @enderror"
            title="Debe seleccionar una opción de la lista." required>
            <option readonly>Seleccione...</option>
            <option value="1" {{ $activo === 1 ? 'selected' : '' }}>Si</option>
            <option value="0" {{ $activo === 0 ? 'selected' : '' }}>No</option>
        </select>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-eye"></span>
            </div>
        </div>

        @error('activo')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Imagen (opcional) --}}
<div class="form-group mb-3">
    <label for="imagen_noticia">Imagen</label>
    <div class="input-group">
        <input type="file" class="custom-file-input @error('imagen_noticia') is-invalid @enderror" id="imagen"
            name="imagen_noticia" accept="image/jpeg" title="Debe ser en formato jpg/jpeg">

        <label class="custom-file-label text-muted" for="imagen_noticia" id="campoImagen">
            Seleccione una imagen
        </label>

        <small id="ayudaImagen" class="form-text text-muted">
            La imagen debe pesar menos de 1 MB.
        </small>
    </div>

    @error('imagen_noticia')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

{{-- Previsualizar imagen --}}
@if (Route::is('noticias.edit'))
    <div class="mb-3 text-center">
        <img src="{{ $imagen }}" alt="{{ $imagen }}" class="rounded img-fluid" id="previsualizar">
    </div>
@else
    <div class="card" style="max-width: 540px">
        <img src="" alt="" id="previsualizar" class="rounded">
    </div>
@endif

<x-modal.mensaje-obligatorio />

@if (Route::is('noticias.edit'))
    <div class="row">
        <div class="col-6">
            <a href="{{ route('noticias.index') }}" class="btn btn-block btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>
                {{ __('Volver') }}
            </a>
        </div>

        <div class="col-6">
            <button type="submit" id="formularioEnviar" class="btn btn-block btn-success">
                <i class="fas fa-save mr-2"></i>
                {{ __('Guardar') }}
            </button>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-6">
            <button id="cancelar" type="button" class="btn btn-block btn-secondary" data-dismiss="modal">
                <i class="fas fa-arrow-left mr-2"></i>
                {{ __('Cancelar') }}
            </button>
        </div>

        <div class="col-6">
            <button id="formularioEnviar" type="submit" class="btn btn-block btn-success">
                <i class="fas fa-save mr-2"></i>
                {{ __('Guardar') }}
            </button>
        </div>
    </div>
@endif
