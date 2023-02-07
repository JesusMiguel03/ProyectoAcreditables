@php
    $horario = atributo($attributes, 'horario');
    
    if (!empty($horario)) {
        $espacio = $horario->espacio;
        $edificio = $horario->edificio;
    }
@endphp

<input type="text" name="actualizar" value="sinHora" hidden>

<div class="form-group">
    <div class="form-row">
        {{-- Espacio --}}
        <div class="form-group col-6">
            <label for="espacio" class="control-label">Espacio</label>

            <div class="input-group">
                <input type="text" name="espacio" id="espacio"
                    class="form-control @error('espacio') is-invalid @enderror" value="{{ $espacio ?? old('espacio') }}"
                    placeholder="{{ __('Espacio a ocupar, Ej: Edificio B o B') }}"
                    maxlength="{{ config('variables.horarios.espacio') }}" data-nombre="caracteres" autofocus required>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-search-location"></span>
                    </div>
                </div>

                @error('espacio')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- Numero --}}
        <div class="form-group col-6">
            <label for="edificio" class="control-label">Aula</label>

            <div class="input-group">
                <input type="number" name="edificio" id="edificio"
                    class="form-control @error('edificio') is-invalid @enderror contador"
                    value="{{ $edificio ?? old('edificio') }}" placeholder="{{ __('Ej: 12') }}"
                    maxlength="{{ config('variables.horarios.edificio') }}" data-nombre="número">


                @error('edificio')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
</div>

<x-modal.mensaje-obligatorio />
@if (Route::is('horarios.edit'))
    <x-modal.footer-editar ruta="{{ route('horarios.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif
