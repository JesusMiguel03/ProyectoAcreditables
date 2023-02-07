@php
    $pnf = atributo($attributes, 'pnf');
    $codigo = atributo($attributes, 'codigo');
@endphp

{{-- Nombre --}}
<div class="form-group required mb-3">
    <label for="nom_pnf" class="control-label">Nombre</label>

    <div class="input-group">
        <input type="text" name="nom_pnf" id="nom_pnf" class="form-control @error('nom_pnf') is-invalid @enderror"
            value="{{ $pnf ?? old('nom_pnf') }}" placeholder="{{ __('Nombre del PNF') }}"
            maxlength="{{ config('variables.pnfs.nombre') }}" data-nombre="caracteres" autofocus required>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-font"></span>
            </div>
        </div>

        @error('nom_pnf')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Código --}}
<div class="form-group mb-3">
    <label for="cod_pnf">Código</label>

    <div class="input-group">
        <input type="text" name="cod_pnf" id="cod_pnf" class="form-control @error('cod_pnf') is-invalid @enderror"
            value="{{ $codigo ?? old('cod_pnf') }}" placeholder="{{ __('Código del PNF') }}"
            maxlength="{{ config('variables.pnfs.codigo') }}" data-nombre="caracteres">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-hashtag"></span>
            </div>
        </div>

        @error('cod_pnf')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<x-modal.mensaje-obligatorio />
@if (Route::is('pnfs.edit'))
    <x-modal.footer-editar ruta="{{ route('pnfs.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif