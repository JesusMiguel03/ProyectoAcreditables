<div class="col-md-4 col-sm-12 mb-2">
    <h5 class="text-center">
        Periodo
        <span class="{{ !empty(periodo()) ? 'text-primary' : 'text-danger' }}">
            {{ !empty(periodo()) ? periodo() : 'Sin asignar' }}
        </span>
    </h5>
</div>
