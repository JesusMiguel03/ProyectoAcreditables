@php
    $noticia = atributo($attributes, 'noticia');
    
    if (!empty($noticia)) {
        $imagen = !empty($noticia->imagen_noticia) ? 'storage/' . $noticia->imagen_noticia : 'vendor/img/defecto/noticias.png';
        $titulo = $noticia->titulo;
        $descripcion = $noticia->desc_noticia;
        $fecha = \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y');
    }
@endphp

@if (empty($noticia))
    <div class="col-md-4 col-sm-12 mx-auto">
        <div class="card card-noticia mt-3 shadow">
            <div class="card-header bg-secondary">
                <h5 class="text-center">Esperando noticias...</h5>
            </div>
            <div class="card-body border-bottom border-primary">
                <h6 class="mb-2 pl-3 py-1 text-muted fecha-noticia">
                    Sin fecha
                </h6>
                <p class="card-text text-justify text-muted">
                    Parece que no hay novedades aún, puede que en otro momento haya alguna noticia...
                </p>
            </div>
        </div>
    </div>
@else
    <section class="slide mb-4">
        <article class="card card-noticia mt-3 shadow" style="height: 300px">

            <img src="{{ asset($imagen) }}"
                class="card-img-top mx-auto rounded border border-outline-secondary" alt="Imagen de noticia" style="max-height: 144px">

            <h6 class="titulo-noticia py-2"> {{ $titulo }} </h6>

            <main class="card-body">
                <p class="mb-2 mt-4 pl-3 text-muted fecha-noticia">
                    {{ $fecha }}
                </p>

                <p class="card-text text-justify">{{ $descripcion }}</p>
            </main>

        </article>
    </section>
@endif
