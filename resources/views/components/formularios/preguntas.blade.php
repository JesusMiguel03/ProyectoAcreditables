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
        <input type="text" name="titulo" id="titulo"
            class="form-control @error('titulo') is-invalid @enderror contador" value="{{ $titulo ?? old('titulo') }}"
            placeholder="{{ __('Ej: Cómo consulto mi nota') }}" maxlength="{{ config('variables.preguntas.titulo') }}" data-nombre="caracteres" autofocus required>

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
        <textarea name="explicacion" class="form-control @error('explicacion') is-invalid @enderror descripcion" spellcheck="false"
            placeholder="{{ __('Ej: Vaya a su perfil, ubicado en el avatar al lado de su nombre') }}" maxlength="{{ config('variables.preguntas.explicacion') }}" data-nombre="caracteres" required>{{ $descripcion ?? old('explicacion') }}</textarea>

        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-comment"></span>
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
    <x-modal.footer-editar ruta="{{ route('preguntas.index') }}" />
@else
    <x-modal.footer-aceptar />
@endif
