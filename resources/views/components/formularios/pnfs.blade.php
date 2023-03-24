@php
    $pnf = atributo($attributes, 'pnf');
    
    if ($pnf) {
        $nombre = $pnf->nom_pnf;
        $codigo = $pnf->cod_pnf === '?' ? '' : $pnf->cod_pnf;
        $trayectos = $pnf->trayectos;
    }
@endphp

{{-- Nombre --}}
<div class="form-group required mb-3">
    <label for="nom_pnf" class="control-label">Nombre</label>

    <div class="input-group">
        <input type="text" id="nombre" name="nom_pnf" class="form-control @error('nom_pnf') is-invalid @enderror"
            value="{{ $nombre ?? old('nom_pnf') }}" placeholder="{{ __('Nombre del PNF, ej: Mecánica') }}"
            maxlength="{{ config('variables.pnfs.nombre') }}" title="Debe contener solo letras." pattern="[A-zÀ-ÿ\s]+"
            autofocus required>

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
        <input type="text" id="codigo" name="cod_pnf" class="form-control @error('cod_pnf') is-invalid @enderror"
            value="{{ $codigo ?? old('cod_pnf') }}" placeholder="{{ __('Código del PNF, ej: PN002') }}"
            maxlength="{{ config('variables.pnfs.codigo') }}" pattern="^[a-zA-Z0-9]+"
            title="Debe contener números y/o letras">

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

{{-- Trayectos --}}
<div class="form-group required mb-3">
    <label for="trayectos" class="control-label">Trayectos</label>

    <div class="input-group">
        <input type="number" id="trayectos" name="trayectos"
            class="form-control @error('trayectos') is-invalid @enderror" value="{{ $trayectos ?? old('trayectos') }}"
            placeholder="{{ __('Cuantas veces ve acreditable, ej: 5') }}" min="1" max="10" required
            pattern="[0-9]" title="Debe ser menor a 10">

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-hashtag"></span>
            </div>
        </div>

        @error('trayectos')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<x-modal.mensaje-obligatorio />

@if (Route::is('pnfs.edit'))
    <div class="row">
        <div class="col-6">
            <a href="{{ route('pnfs.index') }}" class="btn btn-block btn-secondary">
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
