@php
    $pregunta = atributo($attributes, 'pregunta');
    
    if (!empty($pregunta)) {
        $titulo = $pregunta['titulo'];
        $descripcion = $pregunta['explicacion'];
    }
@endphp

{{-- Pregunta --}}
<div class="form-group required mb-3">
    <label for="titulo" class="control-label">Pregunta</label>

    <div class="input-group">
        <input type="text" id="pregunta" name="titulo"
            class="form-control @error('titulo') is-invalid @enderror contador" value="{{ $titulo ?? old('titulo') }}"
            placeholder="{{ __('Ej: Cómo consulto mi nota') }}" maxlength="{{ config('variables.preguntas.titulo') }}"
            pattern="[A-zÀ-ÿ0-9\s]+" title="Debe estar entre 5 y 30 letras." autofocus required>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-question"></span>
            </div>
        </div>

        @error('titulo')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{-- Respuesta --}}
<div class="form-group required mb-3">
    <label for="explicacion" class="control-label">Respuesta</label>

    <div class="input-group">
        <textarea id="respuesta" name="explicacion" class="form-control @error('explicacion') is-invalid @enderror descripcion"
            spellcheck="false" placeholder="{{ __('Ej: Vaya a su perfil, ubicado en el avatar al lado de su nombre') }}"
            maxlength="{{ config('variables.preguntas.explicacion') }}" pattern="[A-zÀ-ÿ0-9\s]+"
            title="Debe estar entre 20 y 255 letras, números y carácteres especiales." required>{{ $descripcion ?? old('explicacion') }}</textarea>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-pencil"></span>
            </div>
        </div>

        @error('explicacion')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<x-modal.mensaje-obligatorio />


@if (Route::is('preguntas.edit'))
    <div class="row">
        <div class="col-6">
            <a href="{{ route('preguntas.index') }}" class="btn btn-block btn-secondary">
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
