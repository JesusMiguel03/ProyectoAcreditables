@php
    $nombre = atributo($attributes, 'nombre');
    $descripcion = atributo($attributes, 'descripcion');
@endphp

{{-- Nombre --}}
<div class="form-group required mb-3">
    <label for="nom_conocimiento" class="control-label">Nombre</label>
    <div class="input-group">
        <input type="text" id="nombre" name="nom_conocimiento"
            class="form-control @error('nom_conocimiento') is-invalid @enderror"
            value="{{ $nombre ?? old('nom_conocimiento') }}" placeholder="{{ __('Nombre del área, ej: Contaduría') }}"
            maxlength="{{ config('variables.conocimiento.nombre') }}" pattern="[A-zÀ-ÿ\s]+"
            title="Debe contener entre 5 y 50 letras." autofocus required>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-font"></span>
            </div>
        </div>

        @error('nom_conocimiento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Descripción --}}
<div class="form-group required mb-3">
    <label for="desc_conocimiento" class="control-label">Descripción</label>
    <div class="input-group">
        <textarea id="descripcion" name="desc_conocimiento"
            class="form-control @error('desc_conocimiento') is-invalid @enderror descripcion" spellcheck="false"
            placeholder="{{ __('Descripción, ej: Manejo de cuentas contables') }}"
            maxlength="{{ config('variables.conocimiento.descripcion') }}" pattern="[A-zÀ-ÿ0-9\s]+"
            title="Debe contener entre 11 y 255 letras y/o números." required>{{ $descripcion ?? old('desc_conocimiento') }}</textarea>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-pencil"></span>
            </div>
        </div>

        @error('desc_conocimiento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<x-modal.mensaje-obligatorio />


@if (Route::is('conocimientos.edit'))
    <div class="row">
        <div class="col-6">
            <a href="{{ route('conocimientos.index') }}" class="btn btn-block btn-secondary">
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
