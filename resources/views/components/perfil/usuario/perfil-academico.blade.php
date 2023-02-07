@php
    $trayecto = datosUsuario(Auth::user()->estudiante, 'Estudiante', 'trayecto');
    $pnf = datosUsuario(Auth::user()->estudiante, 'Estudiante', 'PNF');
@endphp

<section class="card-body">
    <x-perfil.card-titulo>
        Perfil académico
    </x-perfil.card-titulo>

    <main class="row">
        <x-perfil.card-mensaje>
            Esta información valida sus estudios al momento de inscribir una acreditable de su preferencia,
            si no están asignados los campos comuníquese con el Coordinador de Acreditables para
            actualizarlo.
        </x-perfil.card-mensaje>

        <div class="col-md-7 col-sm-12">
            <div class="form-group mb-3">
                <label>Trayecto</label>
                <div class="input-group">
                    <input type="text" class="form-control"
                        value="{{ $trayecto }}"
                        readonly disabled>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-bookmark"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group mb-3">
                <label>PNF</label>
                <div class="input-group">
                    <input type="text" class="form-control"
                        value="{{ $pnf }}"
                        readonly disabled>

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-book"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</section>