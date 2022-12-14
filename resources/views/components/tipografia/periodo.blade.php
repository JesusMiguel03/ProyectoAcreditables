<div class="col-4 mb-2">
    <h5 class="text-center">
        Periodo
        @php
            if ($fecha === 'Sin asignar') {
                $fecha = 'Sin asignar';
            } else {
                $numeros = ['I', 'II', 'III'];
                $fecha = $numeros[$fase - 1] . '-' . $fecha;
            }
        @endphp
        <span class="{{ $fecha === 'Sin asignar' ? 'text-danger' : 'text-primary' }}">{{ $fecha }}</span>
    </h5>
</div>
