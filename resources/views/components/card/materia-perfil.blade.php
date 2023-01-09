<div class="col-sm-12 col-md-3">
    <div class="card">
        <main class="card-body box-profile">
            <div class="text-center {{ rol('Estudiante') ? 'mt-4' : '' }}"
                @if (empty(atributo($attributes, 'profID'))) style="height: 7.133rem" @endif>
                <img class="profile-user-img img-fluid img-circle"
                    src="{{ !empty(atributo($attributes, 'profAvatar')) ? asset('vendor/img/avatares/' . atributo($attributes, 'profAvatar') . '.webp') : asset('vendor/img/defecto/usuario.webp') }}"
                    alt="User profile picture">
            </div>

            <h4 class="profile-username text-center">
                {{ atributo($attributes, 'profNombre') ?? 'Sin asignar' }}
            </h4>
        </main>

        <footer class="card-footer" style="margin-top: {{ rol('Estudiante') ? '-0.618rem' : '-1.512rem' }}">
            @can('materias.modificar')
                @if (!empty(atributo($attributes, 'profID')))
                    <a href="{{ route('profesores.show', atributo($attributes, 'profrID')) }}"
                        class="btn btn-primary d-block">
                        <i class="fas fa-eye mr-2"></i>
                        Ver perfil
                    </a>
                @endif
            @endcan
        </footer>
    </div>
</div>
