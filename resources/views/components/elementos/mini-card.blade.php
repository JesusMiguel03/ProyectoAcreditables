@php
    $nombre = atributo($attributes, 'nombre');
    $contenido = atributo($attributes, 'contenido');
@endphp

<div class="col-sm-12 col-md-3">
    <div class="card border pt-2 text-center">
        <strong>{{ $nombre }}</strong>
        <p>
            [
            <span class="{{ $contenido === 'Sin asignar' ? 'text-info' : 'text-muted' }}">
                {{ $contenido }}
            </span>
            ]
        </p>
    </div>
</div>
