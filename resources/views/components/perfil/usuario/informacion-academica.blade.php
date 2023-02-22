@php
    $usuario = Auth()->user()->estudiante;
    $acreditable = $usuario->nroAcreditable();
    $materia = $usuario->nombreMateria();
    $nota = $usuario->inscrito->aprobo()[0] ?? null;
    $asistencia = $usuario->inscrito->aprobo()[1] ?? null;
@endphp

<section class="card-body">
    <x-perfil.card-titulo titulo="Notas académicas" />

    <main class="row">
        <x-perfil.card-mensaje>
            En este apartado se encuentra la información de las materias que usted ha cursado.
        </x-perfil.card-mensaje>

        <div class="col-md-7 col-sm-12">
            <div class="form-group mb-3">
                <label>Acreditable [{{ $acreditable }}] ({{ $materia }})</label>

                <div class="form-row">
                    <div class="col-6">
                        <input type="text" class="form-control text-{{ $nota < 75 ? 'danger' : 'success' }}" value="Nota: {{ $nota }}/100" readonly disabled>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control text-{{ $asistencia < 75 ? 'danger' : 'success' }}" value="Asistencia: {{ $asistencia }}/100" readonly disabled>
                    </div>
                </div>
            </div>
        </div>
    </main>
</section>
