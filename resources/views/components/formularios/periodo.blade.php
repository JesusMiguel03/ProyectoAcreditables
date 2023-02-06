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
        <input type="number" name="fase" class="form-control @error('fase') is-invalid @enderror"
            value="{{ $fase ?? old('fase') }}" placeholder="{{ __('Ej: 1, 2 o 3') }}" min="1" max="3" autofocus
            required>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-calendar-day "></span>
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
        <input type="text"  name="inicio"
            class="form-control datetimepicker-input @error('inicio') is-invalid @enderror" data-target="#inicio" data-toggle="datetimepicker"
            value="{{ $inicio ?? old('inicio') }}" placeholder="{{ __('2015-01-01') }}"
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
        <input type="text"  name="fin"
            class="form-control datetimepicker-input @error('fin') is-invalid @enderror" data-target="#fin" data-toggle="datetimepicker"
            value="{{ $fin ?? old('fin') }}" placeholder="{{ __('2015-04-09') }}" required>

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
    <x-modal.footer-editar ruta="{{ route('periodos.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif
