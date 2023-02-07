@php
    $datos = atributo($attributes, 'datos');

    $nombre = $datos[0];
    $contenido = $datos[1];

    // if ($nombre === 'Horario') {
    //     $contenido
    //     dd($datos, $nombre, $contenido);
    // }
@endphp

<div class="col-sm-12 col-md-3">
    <div class="card border pt-2 text-center">
        <strong>{{ $nombre }}</strong>
        <p class="{{ $contenido === 'Sin asignar' ? 'text-info' : 'text-muted' }} campo">
            {{ $contenido }}
        </p>
    </div>
</div>
