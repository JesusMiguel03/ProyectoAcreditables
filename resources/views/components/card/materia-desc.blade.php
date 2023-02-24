@php
    // Modelo
    $materia = atributo($attributes, 'materia');
    
    // Campos
    $materiaID = $materia->id;
    $cuposActuales = $materia->cupos;
    $cuposDisponibles = $materia->cupos_disponibles;
    $descripcion = $materia->desc_materia;
    $estado = $materia->estado_materia;
    
    // Relacion
    $materiaProfesor = $materia->profesorEncargado();
    
    if ($materiaProfesor) {
        $profesor = $materia->profesorEncargado()->nombreProfesor();
        $profesorID = $materia->profesorEncargado()->id;
    }
    
    $estudiante = Auth::user()->estudiante ?? null;
    
    if ($estudiante) {
        $inscrito = $estudiante->inscrito->last();

        $estudianteInscrito = $inscrito ?? null;
        $estudianteID = $estudiante->id;
        $estudianteMateriaID = $inscrito->materia_id ?? null;
        $materiaActual = $inscrito->materia->estado_materia ?? null;

        // $repiteAcreditable = $inscrito->repiteAcreditable() ?? null;

        // dd($inscrito->periodoInscripcion()->formato() !== periodo() && $repiteAcreditable);
    }
    
    $descripcionLarga = Str::length($descripcion) > 100;

    $estudianteAproboAcreditableAnterior = $inscrito->estaAprobado() ?? null;
@endphp

<section class="col-sm-12 col-md-9">
    <article class="card">

        <main class="card-body" style="height: 13.52rem">
            <header>
                <h3>
                    Cupos disponibles
                    (<span class="text-info">{{ $cuposDisponibles }}</span> /
                    <span class="text-info">{{ $cuposActuales }}</span>)
                </h3>
            </header>

            <main>
                <p class="text-justify text-muted">{{ $descripcion }}</p>
            </main>

            @can('inscribir')
                <footer class="text-center pt-5">
                    @if ($estado !== 'Finalizado')
                        @if ($estudianteMateriaID === $materiaID)
                            <p class="btn btn-secondary {{ $descripcionLarga ? 'mt-n2' : '' }}">
                                Se encuentra inscrito en esta acreditable
                            </p>
                        @else
                            @if ($materia->estado_materia === 'En progreso')
                                <p class="py-2 rounded bg-secondary font-weight-bold {{ $descripcionLarga ? 'mt-n2' : '' }}">
                                    Esta acreditable ya ha empezado, no puede inscribirse en ella.
                                </p>
                            @elseif ($materiaActual !== 'En progreso' && $materiaActual !== 'Finalizado')
                                <form id="form" action="{{ route('inscripcion.store') }}" method="post">
                                    @csrf

                                    @if ($estudianteInscrito && !$estudianteAproboAcreditableAnterior)
                                        <section class="row {{ $descripcionLarga ? 'mt-n2' : '' }}">
                                            <article class="col-6">
                                                <a href="{{ route('materias.show', $estudianteMateriaID) }}"
                                                    class="btn btn-block btn-secondary">
                                                    Se encuentra inscrito
                                                </a>
                                            </article>

                                            <article class="col-6">
                                                <button id="cambiarAcreditable" data-id="{{ $estudianteID }}"
                                                    data-materia="{{ $materiaID }}"
                                                    class="btn btn-block btn-outline-warning">
                                                    Cambiar de acreditable
                                                </button>
                                            </article>
                                        </section>
                                    @else
                                        <input type="number" name="estudiante_id" class="d-none"
                                            value="{{ $estudianteID }}" hidden>
                                        <input type="number" name="materia_id" class="d-none" value="{{ $materiaID }}"
                                            hidden>

                                        <button type="submit"
                                            class="btn btn-{{ $cuposDisponibles === 0 ? 'secondary' : 'primary' }} {{ $descripcionLarga ? 'mt-n2' : '' }}"
                                            {{ $cuposDisponibles === 0 ? 'disabled' : '' }}>
                                            {{ $cuposDisponibles === 0 ? 'No hay cupos disponibles' : 'Inscribir' }}
                                        </button>
                                    @endif

                                </form>
                            @else
                                <p
                                    class="py-2 rounded bg-secondary font-weight-bold {{ $descripcionLarga ? 'mt-n2' : '' }}">
                                    La acreditable que se encuentra cursando ya ha empezado, no puede cambiarse de
                                    acreditable.
                                </p>
                            @endif
                        @endif
                    @else
                        <p class="py-2 rounded bg-secondary font-weight-bold {{ $descripcionLarga ? 'mt-n2' : '' }}">
                            Esta acreditable ya ha finalizado.
                        </p>
                    @endif
                </footer>
            @endcan
        </main>

    </article>
</section>
