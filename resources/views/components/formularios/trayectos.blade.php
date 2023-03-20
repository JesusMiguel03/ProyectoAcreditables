@php
    $numero = atributo($attributes, 'numero');
@endphp

<div class="form-group required mb-3">
    <label for="num_trayecto" class="control-label">Número</label>

    <div class="input-group">
        <input type="number" name="num_trayecto" class="form-control @error('num_trayecto') is-invalid @enderror"
            value="{{ $numero ?? old('num_trayecto') }}" placeholder="{{ __('Número del trayecto, ej: 1') }}" autofocus
            required min="1" max="10" title="Debe ser menor a 10">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-sort-numeric-down"></span>
            </div>
        </div>

        @error('num_trayecto')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<x-modal.mensaje-obligatorio />
@if (Route::is('trayectos.edit'))
    <x-modal.footer-editar ruta="{{ route('trayectos.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif
