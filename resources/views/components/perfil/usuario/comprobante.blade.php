<section class="card-body">
    <x-perfil.card-titulo>
        Comprobante de inscripción
    </x-perfil.card-titulo>

    <main class="row">
        @if (!empty(estudiante(auth()->user()->estudiante, 'inscrito')->materia->info->profesor))
            <a href="{{ route('comprobante', estudiante(auth()->user(), 'id')) }}" class="col-md-6 col-sm-12 px-3">
                <div class="info-box shadow">
                    <span class="info-box-icon bg-danger"><i class="far fa-file-pdf"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-primary">
                            <strong>Descargar PDF</strong>
                        </span>
                    </div>
                </div>
            </a>
        @elseif (empty(estudiante(auth()->user()->estudiante, 'materia')))
            <p class="card-text text-muted text-justify p-2 px-3">
                Aún no se encuentra inscrito en una acreditable, hasta entonces no tendrá la opción de descargar su
                comprobante.
                Puede revisar las materias disponibles e inscribirse en alguna acreditable de su interés. <a
                    href="{{ route('materias.index') }}">Enlace</a>
            </p>
        @else
            <p class="card-text text-muted text-justify p-2 px-3">
                {{-- Revisar --}}
                {{-- empty(estudiante(auth()->user()->estudiante, 'inscrito')->materia->info->profesor) --}}
                Su comprobante no se encuentra finalizado, por favor, comuníquese con el Coordinador de Acreditables
                para que añada un profesor a la acreditable, hasta entonces su comprobante no estará disponible.
            </p>
        @endif
    </main>
</section>
