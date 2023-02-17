@php
    $nombre = atributo($attributes, 'nombre');
    $color = atributo($attributes, 'color');
    $cantidad = atributo($attributes, 'cantidad');
    
    $contenido = atributo($attributes, 'contenido');
    $aprobados = atributo($attributes, 'aprobados');
    
    if ($nombre === 'Estudiantes') {
        $totalAprobados = 0;
        $totalNoAprobados = 0;
        $notas = [];
        $asistencias = [];
        $estudiantesNombreCI = [];
        $estanAprobados = [];
    
        foreach ($contenido as $index => $estudiante) {
            $datosEstudiante = explode(', ', $estudiante);
    
            $asistencia = $datosEstudiante[1];
            $nota = $datosEstudiante[2];
            $aprobado = $asistencia >= 75 && $nota >= 56;
    
            array_push($notas, $nota);
            array_push($asistencias, $asistencia);
            array_push($estanAprobados, $aprobado);
            array_push($estudiantesNombreCI, $datosEstudiante[0]);
    
            $aprobado ? $totalAprobados++ : $totalNoAprobados++;
        }
    }
@endphp

<article class="col-md-6 col-sm-12">
    <div class="small-box bg-gradient-{{ $color }}">
        <div class="inner text-center">
            <h5>{{ $nombre }} {{ !empty($cantidad) ? "$cantidad" : '' }}</h5>
        </div>

        <span class="small-box-footer" data-toggle="collapse" data-target="#collapse{{ $nombre }}"
            aria-expanded="false" aria-controls="collapse{{ $nombre }}" role="button">
            Más información <i class="fas fa-arrow-circle-right"></i>
        </span>

        <div class="collapse" id="collapse{{ $nombre }}">
            <div class="card card-body text-dark">
                @if ($nombre === 'Estudiantes')
                    <p class="font-weight-bold text-center">
                        [{{ "Aprobados: $totalAprobados - Suspendidos: $totalNoAprobados" }}]
                    </p>

                    <div class="row">
                        @foreach ($estudiantesNombreCI as $index => $estudiante)
                            <small class="col-8 text-{{ $estanAprobados[$index] ? 'success' : 'danger' }}">
                                <i class="fas fa-{{ $estanAprobados[$index] ? 'check' : 'x' }} mr-2"></i>
                                {{ $estudiante }}
                            </small>

                            <small class="col-4 text-muted">
                                <span
                                    class="text-{{ $asistencias[$index] >= 75 ? 'success' : 'danger' }}">{{ "Asistencia: $asistencias[$index]" }}</span>
                                |
                                <span
                                    class="text-{{ $notas[$index] >= 56 ? 'success' : 'danger' }}">{{ "Nota: $notas[$index]" }}</span>
                            </small>
                        @endforeach
                    </div>
                @elseif ($nombre === 'PNF')
                    <p class="text-center">Estudiantes agrupados por PNF</p>

                    <div class="row">
                        @foreach ($contenido as $index => $elemento)
                            <p class="col-6 border-left border-3 border-info">{{ "$index: $elemento" }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

    </div>
</article>
