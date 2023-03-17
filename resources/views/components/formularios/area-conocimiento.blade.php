@php
    $nombre = atributo($attributes, 'nombre');
    $descripcion = atributo($attributes, 'descripcion');
@endphp

{{-- Nombre --}}
<div class="form-group required mb-3">
    <label for="nom_conocimiento" class="control-label">Nombre</label>
    <div class="input-group">
        <input type="text" name="nom_conocimiento"
            class="form-control @error('nom_conocimiento') is-invalid @enderror"
            value="{{ $nombre ?? old('nom_conocimiento') }}"
            placeholder="{{ __('Nombre del área, ej: Contaduría') }}" maxlength="{{ config('variables.conocimiento.nombre') }}" 
            pattern="[A-zÀ-ÿ\s]+" title="Solo debe contener letras y/o espacios." autofocus required>

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
        <textarea name="desc_conocimiento" class="form-control @error('desc_conocimiento') is-invalid @enderror descripcion" spellcheck="false"
            placeholder="{{ __('Descripción, ej: Manejo de cuentas contables') }}" maxlength="{{ config('variables.conocimiento.descripcion') }}" pattern="[A-zÀ-ÿ0-9\s]+" title="Debe contener letras, espacios y/o números."  required>{{ $descripcion ?? old('desc_conocimiento') }}</textarea>

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
    <x-modal.footer-editar ruta="{{ route('conocimientos.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif
