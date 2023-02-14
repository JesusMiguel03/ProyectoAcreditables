@php
    $cantidad = atributo($attributes, 'cantidad');
    $nombre = atributo($attributes, 'nombre');
    $color = atributo($attributes, 'color');
    $extra = atributo($attributes, 'extra');
    $icono = atributo($attributes, 'icono');

    if ($nombre === 'Estudiantes') {
        $mensaje = "Registrados: $cantidad | Inscritos: $extra";
    } elseif ($nombre === 'Profesores') {
        $mensaje = "Registrados: $cantidad";
    } else {
        $mensaje = "Cantidad: $cantidad";
    }
@endphp

<article class="col-md-4 col-sm-12">
    <div class="small-box bg-gradient-{{ $color }}">
        <div class="inner">
            <h4 class="text-center">{{ $nombre }}</h4>
            <p>{{ $mensaje }}</p>
        </div>
        <div class="icon">
            <i class="fas {{ $icono }}"></i>
        </div>
    </div>
</article>
