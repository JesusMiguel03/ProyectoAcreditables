<div class="col-sm-12 col-md-9">
    <div class="card">
        <main class="card-body" style="min-height: 13.52rem">

            <h2 class="d-none d-md-block">
                Cupos disponibles
                [ <span class="text-info">{{ atributo($attributes, 'cupos-disponibles') }}</span> /
                <span class="text-info">{{ atributo($attributes, 'cupos') }}</span> ]
            </h2>
            <h2 class="d-md-none">Cupos disponibles</h2>
            <h2 class="d-md-none">
                [ <span class="text-info">{{ atributo($attributes, 'cupos-disponibles') }}</span> /
                <span class="text-info">{{ atributo($attributes, 'cupos') }}</span>]
            </h2>

            <p class="text-justify text-muted">{{ atributo($attributes, 'contenido') }}</p>

            @can('inscribir')
                @if (rol('Estudiante'))
                    <div class="text-center pt-5">
                        <form action="{{ route('inscripcion.store') }}" method="post">
                            @csrf

                            <input type="number" name="estudiantes[]" class="d-none" hidden
                                value="{{ estudiante(auth()->user()->estudiante, 'id') }}">
                            <input type="number" name="materia_id" class="d-none" hidden value="{{ atributo($attributes, 'materiaID') }}">

                            @if (estudiante(auth()->user()->estudiante, 'inscrito') ? estudiante(auth()->user()->estudiante, 'materia') === atributo($attributes, 'materiaID') : '')
                                <button class="btn btn-secondary disabled">Se encuentra inscrito en esta
                                    acreditable</button>
                            @else
                                @if (estudiante(auth()->user()->estudiante, 'inscrito'))
                                    <a href="{{ route('materias.show', estudiante(auth()->user()->estudiante, 'materia')) }}" class="btn btn-primary">
                                        Ya estás inscrito en una acreditable
                                    </a>
                                @else
                                    <button type="submit"
                                        class="btn btn-{{ atributo($attributes, 'cupos-disponibles') === 0 ? 'secondary' : 'primary' }}"
                                        {{ atributo($attributes, 'cupos-disponibles') === 0 ? 'disabled' : '' }}>
                                        {{ atributo($attributes, 'cupos-disponibles') === 0 ? 'No hay cupos disponibles' : 'Inscribir' }}
                                    </button>
                                @endif
                            @endif

                        </form>
                    </div>
                @endif
            @endcan
        </main>

    </div>
</div>
