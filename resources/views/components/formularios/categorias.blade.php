@php
    $nombre = atributo($attributes, 'nombre');
@endphp

{{-- Campo de nombre --}}
<div class="form-group required mb-3">
    <label for="nom_categoria" class="control-label">Nombre</label>

    <div class="input-group">
        <input type="text" id="nombre" name="nom_categoria"
            class="form-control @error('nom_categoria') is-invalid @enderror"
            value="{{ $nombre ?? old('nom_categoria') }}" placeholder="{{ __('Nombre de la categoria, ej: Ciencias') }}"
            maxlength="{{ config('variables.categorias.nombre') }}" pattern="[A-zÀ-ÿ0-9\s]+"
            title="Debe contener entre 5 y 50 letras y/o números." autofocus required>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-font"></span>
            </div>
        </div>

        @error('nom_categoria')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<x-modal.mensaje-obligatorio />

@if (Route::is('categorias.edit'))
    <div class="row">
        <div class="col-6">
            <a href="{{ route('categorias.index') }}" class="btn btn-block btn-secondary">
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
