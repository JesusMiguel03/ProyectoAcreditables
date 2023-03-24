@php
    $nombre = atributo($attributes, 'nombre');
    $contenido = atributo($attributes, 'contenido');
    $url = atributo($attributes, 'url');
@endphp

<div class="col-sm-12 col-md-3">
    <div class="card border pt-2 text-center">
        <strong>{{ $nombre }}</strong>
        <p>
            [
            @if (rol('Coordinador') && empty($contenido))
                <a href="{{ $url }}" class="text-info">Sin asignar</a>
            @else
                <span class="{{ $contenido === 'Sin asignar' ? 'text-info' : 'text-muted' }}">
                    {{ $contenido }}
                </span>
            @endif
            ]
        </p>
    </div>
</div>
