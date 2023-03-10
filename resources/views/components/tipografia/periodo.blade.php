<div class="col-md-4 col-sm-12 mb-2">
    <h5 class="text-center">
        Periodo
        @if (!empty(periodo()))
            <span class="text-primary">
                {{ periodo() }}
            </span>
            <span class="{{ estadoPeriodo() === 'En curso' ? 'text-success' : 'text-danger' }}">
                ({{ estadoPeriodo() }})
            </span>
        @else
            <span class="text-danger">Sin Asignar</span>
        @endif
    </h5>
</div>
