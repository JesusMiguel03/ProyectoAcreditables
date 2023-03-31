@php
    $periodo = atributo($attributes, 'periodo');
    
    if (!empty($periodo)) {
        $fase = $periodo->fase;
        $inicio = $periodo->inicio;
        $fin = $periodo->fin;
    }
@endphp

{{-- Fase --}}
<div class="form-group required">
    <label for="fase" class="control-label">Fase</label>

    <div class="input-group">
        <input type="number" id="fase" name="fase" class="form-control @error('fase') is-invalid @enderror"
            value="{{ $fase ?? old('fase') }}" placeholder="{{ __('Ej: 1, 2 o 3') }}" title="Debe estar entre 1 y 3." min="1" max="3"
            autofocus required>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-list-alt "></span>
            </div>
        </div>

        @error('fase')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Fecha de inicio --}}
<div class="form-group required">
    <label for="inicio" class="control-label">Fecha inicio</label>

    <div class="input-group date" id="inicio" data-target-input="nearest">
        <input type="text" id="inputInicio" name="inicio"
            class="form-control datetimepicker-input @error('inicio') is-invalid @enderror" data-target="#inicio"
            data-toggle="datetimepicker" value="{{ $inicio ?? old('inicio') }}" placeholder="{{ __('2015-01-01') }}" title="Debe ser una fecha con el formato yyyy/mm/dd."
            required>

        <div class="input-group-append" data-target="#inicio" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>

        @error('inicio')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Fecha de fin --}}
<div class="form-group required">
    <label for="fin" class="control-label">Fecha fin</label>

    <div class="input-group date" id="fin" data-target-input="nearest">
        <input type="text" id="inputFin" name="fin"
            class="form-control datetimepicker-input @error('fin') is-invalid @enderror" data-target="#fin"
            data-toggle="datetimepicker" value="{{ $fin ?? old('fin') }}" placeholder="{{ __('2015-04-09') }}"  title="Debe tener 90 días más que la fecha de inicio." required>

        <div class="input-group-append" data-target="#fin" data-toggle="datetimepicker">
            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
        </div>

        @error('fin')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<x-modal.mensaje-obligatorio />

@if (Route::is('periodos.edit'))
    <div class="row">
        <div class="col-6">
            <a href="{{ route('periodos.index') }}" class="btn btn-block btn-secondary">
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
