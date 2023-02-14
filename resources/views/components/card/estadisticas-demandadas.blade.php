@php
    $trayecto = atributo($attributes, 'trayecto');
    $nroTrayecto = atributo($attributes, 'nroTrayecto');
    $colores = ['primary', 'secondary', 'info', 'success', 'danger'];
@endphp

<article class="col-md-4 col-sm-12">
    <div class="small-box bg-gradient-{{ $colores[$nroTrayecto - 1] ?? 'secondary' }}">
        <div class="inner">
            <h5 class="text-center">Trayecto {{ $nroTrayecto }}</h5>
        </div>

        <span class="small-box-footer" data-toggle="collapse" data-target="#collapse{{ $nroTrayecto }}"
            aria-expanded="false" aria-controls="collapse{{ $nroTrayecto }}" role="button">
            Más información <i class="fas fa-arrow-circle-right"></i>
        </span>

        <div class="collapse" id="collapse{{ $nroTrayecto }}">
            <div class="card card-body text-dark">
                @foreach ($trayecto as $index => $pnf)
                    @php
                        $materia = 'Acreditable: ' . $pnf['materia'];
                        $cantidad = 'Estudiantes: ' . $pnf['cantidad'];
                    @endphp

                    <p class="{{ !$loop->first ? 'mt-1' : '' }} pl-3 border-bottom border-secondary">
                        [ {{ $index }} ]
                    </p>
                    <small class="mt-n3 text-muted">{{ $materia }}</small>
                    <small class="mt-n1 text-muted">{{ $cantidad }}</small>
                @endforeach
            </div>
        </div>

    </div>
</article>
