@php
    $estudiante = Auth()->user()->estudiante;
    
    $inscripciones = $estudiante->inscrito;
    
    $informacion = [];
    
    foreach ($inscripciones as $i => $inscrito) {

        $asistencia = $inscrito->asistencia;
    
        $asistencias = 0;
    
        for ($s = 1; $s <= 12; $s++) {
            $sem = 'sem' . $s;

            if (!empty($asistencia)) {
                $asistencia[$sem] === 1 ? $asistencias++ : '';
            }
        }
    
        $informacion["A$i"] = [
            'nombreAcreditable' => $inscrito->inscritoAcreditable('nombre'),
            'nroAcreditable' => $inscrito->inscritoAcreditable('nro'),
            'notaAcreditable' => $inscrito->nota,
            'asistenciaAcreditable' => round(($asistencias * 833) / 100),
        ];
    }
@endphp

<section class="card-body">
    <x-perfil.card-titulo titulo="Notas académicas" />

    <main class="row">
        <x-perfil.card-mensaje>
            En este apartado se encuentra la información de las materias que usted ha cursado.
        </x-perfil.card-mensaje>

        <div class="col-md-7 col-sm-12">
            <div class="form-group mb-3">

                @foreach ($informacion as $inscripcion)

                @php
                    $nroAcreditable = $inscripcion['nroAcreditable'];
                    $nombreAcreditable = $inscripcion['nombreAcreditable'];
                    $notaAcreditable = $inscripcion['notaAcreditable'];
                    $asistenciaAcreditable = $inscripcion['asistenciaAcreditable'];
                @endphp

                    <label>Acreditable [{{ $nroAcreditable }}] ({{ $nombreAcreditable }})</label>

                    <div class="form-row mb-2">
                        <div class="col-6">
                            <input type="text"
                                class="form-control text-{{ $notaAcreditable < 56 ? 'danger' : 'success' }}"
                                value="Nota: {{ $notaAcreditable }}/100" readonly disabled>
                        </div>
                        <div class="col-6">
                            <input type="text"
                                class="form-control text-{{ $asistenciaAcreditable < 75 ? 'danger' : 'success' }}"
                                value="Asistencia: {{ $asistenciaAcreditable }}/100" readonly disabled>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </main>
</section>
