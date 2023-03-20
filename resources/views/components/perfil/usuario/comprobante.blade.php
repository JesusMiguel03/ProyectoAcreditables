@php
    $estudiante = Auth::user()->estudiante ?? null;
    $estudianteID = $estudiante->id ?? null;
    
    if ($estudiante) {
        $inscripcion = $estudiante->inscrito ?? null;
        $informacion = [];
    
        foreach ($inscripcion as $i => $inscrito) {
            $informacion[$i] = [
                'id' => $i,
                'profesor' => $inscrito->materia->profesorEncargado() ?? null,
                'acreditable' => $inscrito->inscritoAcreditable('nombre'),
                'nroAcreditable' => $inscrito->inscritoAcreditable('nro'),
            ];
        }
    }
@endphp

<section class="card-body">
    <x-perfil.card-titulo titulo="Comprobantes de inscripción" />

    <main class="row">
        @if ($estudiante)
            @foreach ($informacion as $inscrito)
                @php
                    $profesor = $inscrito['profesor'];
                    $acreditable = $inscrito['acreditable'];
                    $nroAcreditable = $inscrito['nroAcreditable'];
                    $comprobanteID = $inscrito['id'] + 1;
                @endphp

                <a href="{{ route('comprobante', [$estudianteID, $comprobanteID]) }}" class="col-12 px-3" data-download="true">
                    <div class="info-box shadow">
                        <span class="info-box-icon bg-danger"><i class="far fa-file-pdf"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text text-primary">
                                <strong>Descargar PDF
                                    ({{ $acreditable . ' - Acreditable ' . $nroAcreditable }})
                                </strong>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <p class="card-text text-muted text-justify p-2 px-3">
                Aún no se encuentra inscrito en una acreditable, hasta entonces no tendrá la opción de descargar su
                comprobante.
                Puede revisar las materias disponibles e inscribirse en alguna acreditable de su interés. <a
                    href="{{ route('materias.index') }}">Enlace</a>
            </p>
        @endif
    </main>
</section>
