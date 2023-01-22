@php
    $horario = atributo($attributes, 'horario');

    if (!empty($horario)) {
        $espacio = $horario->espacio;
        $edificio = $horario->edificio;
        $dia = $horario->dia;
        $hora = \Carbon\Carbon::parse($horario->hora)->format('g:i A');
    } else {
        $dia = '';
    }
@endphp

{{-- Espacio --}}
<div class="form-group required">
    <label for="espacio" class="control-label">Espacio</label>

    <div class="input-group">
        <input type="text" name="espacio" id="espacio" class="form-control @error('espacio') is-invalid @enderror"
            value="{{ $espacio ?? old('espacio') }}" placeholder="{{ __('Espacio a ocupar, Ej: Edificio B o B') }}" maxlength="{{ config('variables.horarios.espacio') }}" data-nombre="caracteres" autofocus
            required>

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

<div class="form-group">
    <div class="form-row">
        {{-- Numero --}}
        <div class="form-group col-6">
            <label for="edificio" class="control-label">Edificio Nro</label>

            <div class="input-group">
                <input type="number" name="edificio" id="edificio"
                    class="form-control @error('edificio') is-invalid @enderror contador"
                    value="{{ $edificio ?? old('edificio') }}" placeholder="{{ __('Ej: 12') }}" maxlength="{{ config('variables.horarios.edificio') }}" data-nombre="número">


                @error('edificio')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- Dia --}}
        <div class="form-group required col-6">
            <label for="dia" class="control-label">Dia</label>

            <div class="input-group">
                <select name="dia" class="form-control" required>
                    <option value="0" readonly>Seleccione...</option>
                    <option value="1" {{ $dia === '1' ? 'selected' : '' }}>Lunes</option>
                    <option value="2" {{ $dia === '2' ? 'selected' : '' }}>Martes</option>
                    <option value="3" {{ $dia === '3' ? 'selected' : '' }}>Miércoles</option>
                    <option value="4" {{ $dia === '4' ? 'selected' : '' }}>Jueves</option>
                    <option value="5" {{ $dia === '5' ? 'selected' : '' }}>Viernes</option>
                </select>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-calendar-day"></span>
                    </div>
                </div>

                @error('dia')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
</div>

{{-- Hora --}}
<div class="form-group required mb-3" style="margin-top: -10px">
    <label for="hora" class="control-label">Hora</label>

    <div class="input-group date" id="hora" data-target-input="nearest">
        <input type="text" name="hora"
            class="form-control datetimepicker-input @error('hora') is-invalid @enderror" data-target="#hora"
            value="{{ $hora ?? old('hora') }}" placeholder="{{ __('Ej: 10:45') }}" required>

        <div class="input-group-append" data-target="#hora" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>

        @error('hora')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<x-modal.mensaje-obligatorio />
@if (Route::is('horarios.edit'))
    <x-modal.footer-editar ruta="{{ route('horarios.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif
