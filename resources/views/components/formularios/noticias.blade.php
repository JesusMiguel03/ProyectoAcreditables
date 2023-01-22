@php
    $noticia = atributo($attributes, 'noticia');

    if (!empty($noticia)) {
        $titulo = $noticia->titulo;
        $descripcion = $noticia->desc_noticia;
        $activo = $noticia->activo;
        $imagen = $noticia->imagen_noticia;
    } else {
        $activo = '';
    }
@endphp

{{-- Titulo --}}
<div class="form-group required mb-3">
    <label for="titulo" class="control-label">Título</label>

    <div class="input-group">
        <input type="text" name="titulo" id="titulo"
            class="form-control @error('titulo') is-invalid @enderror" value="{{ $titulo ?? old('titulo') }}"
            placeholder="{{ __('Nombre de la noticia') }}" maxlength="{{ config('variables.noticias.titulo') }}" data-nombre="caracteres" autofocus required>

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
        <textarea name="desc_noticia" class="form-control @error('desc_noticia') is-invalid @enderror descripcion" spellcheck="false" 
            placeholder="{{ __('Descripción') }}" maxlength="{{ config('variables.noticias.descripcion') }}" data-nombre="caracteres" required>{{ $descripcion ?? old('desc_noticia') }}</textarea>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-comment"></span>
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
        <select name="activo" class="form-control @error('activo') is-invalid @enderror">
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
            name="imagen_noticia" accept="image/jpeg">

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
        <img src="{{ !empty($imagen) ? asset('storage/' . $imagen) : asset('vendor/img/defecto/noticias.png') }}"
            alt="{{ !empty($imagen) ? 'Imagen de la materia' : 'Imagen de materia por defecto' }}"
            class="rounded img-fluid">
    </div>
@else
    <div class="card" style="max-width: 540px">
        <img src="" alt="" id="previsualizar" class="rounded">
    </div>
@endif

<x-modal.mensaje-obligatorio />
@if (Route::is('noticias.edit'))
    <x-modal.footer-editar ruta="{{ route('noticias.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif
