@php
    $materia = atributo($attributes, 'materia');

    $profesor = $materia->profesorEncargado();

    if ($profesor) {
        $profesorID = $profesor->id;
        $profesorNombre = $profesor->nombreProfesor();
        $profesorAvatar = $profesor->avatar();
    }

    $avatar = !empty($profesorAvatar) ? "vendor/img/avatares/avatar{$profesorAvatar}.webp": 'vendor/img/defecto/usuario.webp';
    
    if (rol('Estudiante')) {
        $altura = '7.133rem';
        $margen = 'mt-4';
    } elseif (rol('Profesor')) {
        $altura = '7.625rem';
        $margen = 'mt-3';
    } else {
        $altura = empty($profesorID) ? '7.625rem' : '';
        $margen = empty($profesorID) ? 'mt-3' : '';
    }
@endphp

<section class="col-sm-12 col-md-3">
    <article class="card">
        <main class="card-body box-profile">
            <div class="text-center {{ $margen }}" style="min-height:{{ $altura }}">
                <img class="profile-user-img img-fluid img-circle"
                    src="{{ asset($avatar) }}"
                    alt="Avatar del profesor">
            </div>

            <h4 class="profile-username text-center">
                {{ $profesorNombre ?? 'Sin asignar' }}
            </h4>
        </main>

        @can('materias.modificar')
            <footer class="card-footer" style="margin-top: -1.493rem">
                @if (!empty($profesorID))
                    <a href="{{ route('profesores.show', $profesorID) }}" class="btn btn-primary d-block">
                        <i class="fas fa-eye mr-2"></i>
                        Ver perfil
                    </a>
                @endif
            </footer>
        @endcan
    </article>
</section>
