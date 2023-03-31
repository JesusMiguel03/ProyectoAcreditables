@php
    $materia = atributo($attributes, 'materia');
    
    $info = !empty($materia->info) ? $materia->info->categoria : null;
    $categoria = !empty($info) ? $info->nom_categoria : 'Sin asignar';
    $id = $materia->id;
    $imagen = $materia->imagen_materia;
    if (request()->secure()) {
        $imagen = !empty($imagen) ? secure_asset('storage/' . $imagen) : secure_asset('vendor/img/defecto/materias.png');
    } else {
        $imagen = !empty($imagen) ? asset('vendor/img/defecto/materias.png') : asset('storage/' . $imagen);
    }
    $nombre = $materia->nom_materia;
    $cupos = $materia->cupos_disponibles;
    $nro = $materia->trayecto->num_trayecto;
    $descripcion = $materia->desc_materia;
@endphp

@if (!empty(atributo($attributes, 'existe')))
    <div class="mx-auto col-md-4 col-sm-12">
        <section class="card mt-3">
            <header class="card-img-top">
                <img src="{{ request()->secure() ? secure_asset('vendor/img/defecto/materias.png') : asset('vendor/img/defecto/materias.png') }}"
                    alt="Imagen de materia" class="card-img-top rounded" style="height: 15vh">
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
            <img src="{{ $imagen }}" alt="Imagen de materia"
                class="card-img-top rounded {{ $imagen ? 'border border-outline-secondary' : '' }}"
                style="height: 15vh">
        </header>

        <main class="card-body">
            <div class="row px-2">
                <h5 class="card-title mb-2 font-weight-bold">
                    {{ $nombre }} {{ $nro }}
                </h5>
            </div>

            <div class="row mb-2 border-bottom">

                <div class="col-10">
                    <h6 class="card-text text-secondary">
                        Cupos disponibles:
                        <span class="text-primary">
                            {{ $cupos }}
                        </span>
                    </h6>
                </div>

                <div class="col-2">
                    <h5 class="card-title mb-2 font-weight-bold text-muted">
                        #A{{ $nro }}
                    </h5>
                </div>

                <div class="col-12" style="margin-top: -0.5rem">
                    <h6 class="text-muted">
                        Categoria:
                        <span class="text-info">
                            {{ $categoria ?? 'Sin asignar' }}
                        </span>
                    </h6>
                </div>

            </div>

            <p class="card-text text-truncate">{{ $descripcion }}</p>
        </main>

        <footer class="card-footer">
            <a href="{{ route('materias.show', $id) }}" class="btn btn-primary d-block">
                Ver materia
            </a>
        </footer>
    </section>
@endif
