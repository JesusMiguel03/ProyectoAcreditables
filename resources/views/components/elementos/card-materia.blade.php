@if (!empty(atributo($attributes, 'existe')))
    <div class="mx-auto col-md-4 col-sm-12">
        <section class="card mt-3">
            <header class="card-img-top">
                <img src="{{ asset('vendor/img/defecto/materias.png') }}" alt="Imagen de materia"
                    class="card-img-top rounded" style="height: 15vh">
            </header>

            <main class="card-body">
                <div class="row px-2">
                    <h5 class="card-title mb-2 text-muted">
                        No hay materias disponibles
                    </h5>
                </div>
            </main>
        </section>
    </div>
@else
    <section class="card mt-3">
        <header class="card-img-top">
            <img src="{{ empty(atributo($attributes, 'img')) ? asset('vendor/img/defecto/materias.png') : asset('storage/' . atributo($attributes, 'img')) }}"
                alt="Imagen de materia"
                class="card-img-top rounded {{ atributo($attributes, 'img') ? 'border border-outline-secondary' : '' }}"
                style="height: 15vh">
        </header>

        <main class="card-body">
            <div class="row px-2">
                <h5 class="card-title mb-2 font-weight-bold">
                    {{ atributo($attributes, 'nombre') }}
                </h5>
            </div>

            <div class="row mb-2 border-bottom">

                <div class="col-10">
                    <h6 class="card-text text-secondary">
                        Cupos disponibles:
                        <span class="text-primary">
                            {{ atributo($attributes, 'cupos') }}
                        </span>
                    </h6>
                </div>

                <div class="col-2">
                    <h5 class="card-title mb-2 font-weight-bold text-muted">
                        #A{{ atributo($attributes, 'acreditable') }}
                    </h5>
                </div>

                <div class="col-12" style="margin-top: -0.5rem">
                    <h6 class="text-muted">
                        Categoria:
                        <span class="text-info">
                            {{ atributo($attributes, 'categoria') ? 'Sin asignar' : atributo($attributes, 'categoria') }}
                        </span>
                    </h6>
                </div>

            </div>

            <p class="card-text text-truncate">{{ atributo($attributes, 'contenido') }}</p>
        </main>

        <footer class="card-footer">
            <a href="{{ route('materias.show', atributo($attributes, 'id')) }}" class="btn btn-primary d-block">
                Ver materia
            </a>
        </footer>
    </section>
@endif
