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
    
    $usuario = Auth::user()->estudiante;
    if (!empty($usuario)) {
        $estudianteInscrito = $usuario->inscrito ?? null;
        $estudianteID = $usuario->id;
        $estudianteMateriaID = !empty($usuario->inscrito) ? $usuario->inscrito->materia_id : '';
    }

    $descripcionLarga = Str::length($descripcion) > 100;
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
                    @if (datosUsuario(Auth::user(), 'Estudiante', 'materia') === $materiaID)
                        <p class="btn btn-secondary" style="{{ $descripcionLarga ? 'margin-top: -0.5rem' : '' }}">
                            Se encuentra inscrito
                        </p>
                    @else
                        <form id="form" action="{{ route('inscripcion.store') }}" method="post">
                            @csrf

                            @if ($estudianteInscrito)
                                <section class="row"
                                    style="{{ $descripcionLarga ? 'margin-top: -0.5rem' : '' }}">
                                    <article class="col-6">
                                        <a href="{{ route('materias.show', $estudianteMateriaID) }}"
                                            class="btn btn-block btn-secondary">
                                            Se encuentra inscrito
                                        </a>
                                    </article>

                                    <article class="col-6">
                                        <button id="cambiarAcreditable" data-id="{{ $estudianteID }}"
                                            data-materia="{{ $materiaID }}" class="btn btn-block btn-outline-warning">
                                            Cambiar de acreditable
                                        </button>
                                    </article>
                                </section>
                            @else
                                <input type="number" name="estudiante_id" class="d-none" value="{{ $estudianteID }}"
                                    hidden>
                                <input type="number" name="materia_id" class="d-none" value="{{ $materiaID }}" hidden>

                                <button type="submit"
                                    style="{{ $descripcionLarga ? 'margin-top: -0.5rem' : '' }}"
                                    class="btn btn-{{ $cuposDisponibles === 0 ? 'secondary' : 'primary' }}"
                                    {{ $cuposDisponibles === 0 ? 'disabled' : '' }}>
                                    {{ $cuposDisponibles === 0 ? 'No hay cupos disponibles' : 'Inscribir' }}
                                </button>
                            @endif

                        </form>
                    @endif
                </footer>
            @endcan
        </main>

    </article>
</section>
