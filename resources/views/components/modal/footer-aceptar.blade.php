@php
    $id = atributo($attributes, 'id');
@endphp

<div class="row">
    <div class="col-6">
        <button id="{{ $id . 'Cancelar' ?? 'cancelar' }}" type="button" class="btn btn-block btn-secondary"
            data-dismiss="modal">
            <i class="fas fa-arrow-left mr-2"></i>
            {{ __('Cancelar') }}
        </button>
    </div>

    <div class="col-6">
        <button id="{{ $id ?? 'formularioEnviar' }}" type="submit" class="btn btn-block btn-success">
            <i class="fas fa-save mr-2"></i>
            {{ __('Guardar') }}
        </button>
    </div>
</div>
