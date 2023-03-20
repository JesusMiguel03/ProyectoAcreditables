@php
    $horario = atributo($attributes, 'horario');
    
    if (!empty($horario)) {
        $espacio = $horario->espacio;
        $aula = $horario->aula;
    }
@endphp

<input type="text" name="actualizar" value="sinHora" hidden>

<section class="form-group">
    <div class="form-row">
        {{-- Espacio --}}
        <article class="form-group col-md-6 col-sm-12">
            <label for="espacio" class="control-label">Espacio</label>

            <div class="input-group">
                <input type="text" name="espacio" id="espacio"
                    class="form-control @error('espacio') is-invalid @enderror" value="{{ $espacio ?? old('espacio') }}"
                    placeholder="{{ __('Espacio a ocupar, Ej: (Edificio B) o solo (B)') }}"
                    maxlength="{{ config('variables.horarios.espacio') }}" pattern="[A-zÀ-ÿ0-9\s]+"
                    title="Debe contener letras, espacios y/o números." autofocus required>

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
        </article>

        {{-- Numero --}}
        <article class="form-group col-md-6 col-sm-12">
            <label for="aula" class="control-label">Aula</label>

            <div class="input-group">
                <input type="number" name="aula" id="aula"
                    class="form-control @error('aula') is-invalid @enderror contador" value="{{ $aula ?? old('aula') }}"
                    placeholder="{{ __('Número del aula, si es un edificio, ej: 12') }}" min="1"
                    max="{{ config('variables.horarios.aula') }}"
                    title="No debe ser mayor a {{ config('variables.horarios.aula') }}">


                @error('aula')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </article>

    </div>
</section>

<x-modal.mensaje-obligatorio />

@if (Route::is('horarios.edit'))
    <x-modal.footer-editar ruta="{{ route('horarios.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif
