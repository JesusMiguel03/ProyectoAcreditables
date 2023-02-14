@php
    $usuario = Auth()->user()->estudiante;
    $acreditable = $usuario->nroAcreditable();
    $materia = $usuario->nombreMateria();
    $nota = $usuario->inscrito->nota ?? null;
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
                <input type="text" class="form-control" value="{{ $nota }}" readonly disabled>
            </div>
        </div>
    </main>
</section>
