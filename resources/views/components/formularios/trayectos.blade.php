@php
    $numero = atributo($attributes, 'numero');
@endphp

<div class="form-group required mb-3">
    <label for="num_trayecto" class="control-label">Número</label>

    <div class="input-group">
        <input type="number" id="trayecto" name="num_trayecto"
            class="form-control @error('num_trayecto') is-invalid @enderror" value="{{ $numero ?? old('num_trayecto') }}"
            placeholder="{{ __('Número del trayecto, ej: 1') }}" autofocus required min="1" max="10"
            title="Debe estar entre 1 y 10 dígitos.">

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
    <div class="row">
        <div class="col-6">
            <a href="{{ route('trayectos.index') }}" class="btn btn-block btn-secondary">
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
