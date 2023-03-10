@php
    // Modelo
    $materia = atributo($attributes, 'materia');
    
    $periodoFinalizado = periodo('modelo')->finalizado();
    
    // Campos
    $materiaID = $materia->id;
    $cuposActuales = $materia->cupos;
    $cuposDisponibles = $materia->cupos_disponibles;
    $descripcion = $materia->desc_materia;
    $estadoMateria = $materia->estado_materia;
    
    // Relacion
    $materiaProfesor = $materia->profesorEncargado();
    
    if ($materiaProfesor) {
        $profesor = $materia->profesorEncargado()->nombreProfesor();
        $profesorID = $materia->profesorEncargado()->id;
    }
    
    $estudiante = Auth::user()->estudiante ?? null;
    
    $acreditableInscrita = false;
    $estadoMateriaActual = false;
    
    if ($estudiante) {
        $inscrito = $estudiante->inscrito->last();
    
        $aprobado = $inscrito->aprobado ?? null;
    
        $estudianteInscrito = $inscrito ?? null;
        $estudianteID = $estudiante->id;
        $estudianteMateriaID = $inscrito->materia_id ?? null;
        $estadoMateriaActual = $inscrito->materia->estado_materia ?? null;
    
        $acreditableInscrita = $estudianteMateriaID === $materiaID;
    }
    
    $descripcionLarga = Str::length($descripcion) > 100;
    
    if ($periodoFinalizado) {
        $mensaje = 'No puede inscribirse debido a que el periodo ha finalizado';
    } else {
        if ($estadoMateria !== 'Finalizado' && $estadoMateria !== 'Inactivo') {
            $mensaje = '';
    
            if (!$acreditableInscrita && $estadoMateriaActual === 'En progreso') {
                $mensaje = 'La acreditable que se encuentra cursando ya ha empezado, no puede cambiarse de acreditable.';
            }
    
            if (!$acreditableInscrita && $estadoMateria === 'En progreso') {
                $mensaje = 'Esta acreditable se encuentra en curso, no puede inscribirse en ella.';
            }
    
            if ($acreditableInscrita) {
                $mensaje = 'Se encuentra inscrito en esta acreditable.';
            }
        } else {
            $mensaje = 'Esta acreditable se encuentra finalizada.';
        }
    }
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

                    @if (!empty($mensaje))
                        <p class="{{ $descripcionLarga ? 'mt-n2' : '' }} mensaje">
                            {{ $mensaje }}
                        </p>
                    @else
                        <form id="form" action="{{ route('inscripcion.store') }}" method="post">
                            @csrf

                            @if ($aprobado !== null || !$estudianteInscrito)
                                <input type="number" name="estudiante_id" class="d-none" value="{{ $estudianteID }}"
                                    hidden>
                                <input type="number" name="materia_id" class="d-none" value="{{ $materiaID }}" hidden>

                                <button type="submit"
                                    class="btn btn-{{ $cuposDisponibles === 0 ? 'secondary' : 'primary' }} {{ $descripcionLarga ? 'mt-n2' : '' }}"
                                    {{ $cuposDisponibles === 0 ? 'disabled' : '' }}>
                                    {{ $cuposDisponibles === 0 ? 'No hay cupos disponibles' : 'Inscribirme' }}
                                </button>
                            @elseif ($estudianteInscrito)
                                <section class="row {{ $descripcionLarga ? 'mt-n2' : '' }}">
                                    <article class="col-6">
                                        <a href="{{ route('materias.show', $estudianteMateriaID) }}"
                                            class="btn btn-block btn-secondary">
                                            Ver acreditable inscrita
                                        </a>
                                    </article>

                                    <article class="col-6">
                                        <button id="cambiarAcreditable" data-id="{{ $estudianteID }}"
                                            data-materia="{{ $materiaID }}" class="btn btn-block btn-outline-warning">
                                            Cambiar de acreditable
                                        </button>
                                    </article>
                                </section>
                            @endif

                        </form>
                    @endif

                </footer>
            @endcan
        </main>

    </article>
</section>
