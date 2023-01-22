@php
    $nombre = atributo($attributes, 'nombre');
@endphp

{{-- Campo de nombre --}}
<div class="form-group required mb-3">
    <label for="nom_categoria" class="control-label">Nombre</label>
    <div class="input-group">
        <input type="text" name="nom_categoria" id="nom_categoria"
            class="form-control @error('nom_categoria') is-invalid @enderror" value="{{ $nombre ?? old('nom_categoria') }}"
            placeholder="{{ __('Nombre de la categoria') }}" maxlength="{{ config('variables.categorias.nombre') }}" data-nombre="caracteres"  autofocus required>

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
    <x-modal.footer-editar ruta="{{ route('categorias.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif
