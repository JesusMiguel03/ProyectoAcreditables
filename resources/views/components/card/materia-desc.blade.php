@php
    // Modelo
    $materia = atributo($attributes, 'materia');
    
    // Campos
    $materiaID = $materia->id;
    $cuposActuales = $materia->cupos;
    $cuposDisponibles = $materia->cupos_disponibles;
    $descripcion = $materia->desc_materia;
    
    // Relacion
    $avatar = materia($materia, 'profAvatar');
    $profesor = materia($materia, 'profesor');
    $profesorID = materia($materia, 'profID');
    
@endphp

<div class="col-sm-12 col-md-9">
    <div class="card">
        <main class="card-body" style="min-height: 13.52rem">

            <h3>
                Cupos disponibles
                (<span class="text-info">{{ $cuposDisponibles }}</span> /
                <span class="text-info">{{ $cuposActuales }}</span>)
            </h3>

            <p class="text-justify text-muted">{{ $descripcion }}</p>

            @can('inscribir')
                <div class="text-center pt-5">

                    @if (datosUsuario(Auth::user(), 'Estudiante', 'materia') === $materiaID)
                        <button class="btn btn-secondary" style="pointer-events: none">
                            Se encuentra inscrito
                        </button>
                    @else
                        <form id="form" action="{{ route('inscripcion.store') }}" method="post">
                            @csrf

                            @if (datosUsuario(Auth::user(), 'Estudiante', 'inscrito'))
                                <section class="row">
                                    <article class="col-6">
                                        <a href="{{ route('materias.show', datosUsuario(Auth::user(), 'Estudiante', 'materia')) }}"
                                            class="btn btn-block btn-primary">
                                            Se encuentra inscrito
                                        </a>
                                    </article>

                                    <article class="col-6">
                                        <button id="cambiarAcreditable"
                                            data-id="{{ datosUsuario(Auth::user()->estudiante, 'Estudiante', 'ID') }}"
                                            data-materia="{{ $materiaID }}" class="btn btn-block btn-outline-primary">
                                            Cambiar de acreditable
                                        </button>
                                    </article>
                                </section>
                            @else
                                <input type="number" name="estudiante_id" class="d-none"
                                    value="{{ datosUsuario(Auth::user(), 'Estudiante', 'ID') }}" hidden>
                                <input type="number" name="materia_id" class="d-none" value="{{ $materiaID }}" hidden>

                                <button type="submit"
                                    class="btn btn-{{ $cuposDisponibles === 0 ? 'secondary' : 'primary' }}"
                                    {{ $cuposDisponibles === 0 ? 'disabled' : '' }}>
                                    {{ $cuposDisponibles === 0 ? 'No hay cupos disponibles' : 'Inscribir' }}
                                </button>
                            @endif

                        </form>
                    @endif

                </div>
            @endcan
        </main>

    </div>
</div>
