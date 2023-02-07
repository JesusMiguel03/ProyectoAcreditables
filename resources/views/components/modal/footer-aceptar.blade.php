@php
    $enviar = atributo($attributes, 'enviar');
@endphp

<div class="row">
    <x-botones.modal-cancelar />

    <div class="col-6">
        <button {{ $enviar ? 'disabled' : 'type="submit"' }} class="btn btn-block btn-success">
            <i class="fas fa-save mr-2"></i>
            {{ __('Guardar') }}
        </button>
    </div>
</div>