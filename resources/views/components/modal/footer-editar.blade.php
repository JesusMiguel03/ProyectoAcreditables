@php
    $validacion = atributo($attributes, 'sinEstudiantes');
    $id = atributo($attributes, 'id');
@endphp

<div class="row">
    <div class="col-6">
        <a href="{{ $ruta }}" class="btn btn-block btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>
            {{ __('Volver') }}
        </a>
    </div>

    <div class="col-6">
        @if ($validacion)
            <p class="btn btn-block btn-secondary disabled">
                {{ __('Guardar') }}
            </p>
        @else
            <button type="submit" id="{{ $id ?? 'formularioEnviar' }}"
                class="btn btn-block btn-success">
                <i class="fas fa-save mr-2"></i>
                {{ __('Guardar') }}
            </button>
        @endif
    </div>
</div>
