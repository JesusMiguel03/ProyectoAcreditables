@if (atributo($attributes, 'sin-noticias'))
    <div class="col-md-4 col-sm-12 mx-auto">
        <div class="card card-noticia mt-3 shadow">
            <div class="card-header bg-secondary">
                <h5 class="text-center">. . . Esperando noticias . . .</h5>
            </div>
            <div class="card-body border-bottom border-primary">
                <h6 class="mb-2 pl-3 py-1 text-muted fecha-noticia">
                    [ Sin fecha ]
                </h6>
                <p class="card-text text-justify text-muted">
                    Parece que no hay novedades aún, puede que en otro momento haya alguna noticia...
                </p>
            </div>
        </div>
    </div>
@else
    <div class="slide">
        <div class="card card-noticia mt-3 shadow">

            <img loading="lazy" src="{{ !empty(atributo($attributes, 'img')) ? asset('storage/' . atributo($attributes, 'img')) : asset('vendor/img/defecto/noticias.png') }}"
                class="card-img-top card-img-ajuste rounded border border-outline-secondary" alt="Imagen de noticia">

            <h5 class="titulo-noticia py-2">
                {{ atributo($attributes, 'encabezado') }}
            </h5>

            <div class="card-body border-bottom border-info">

                <h6 class="my-3 pl-3 py-1 text-muted fecha-noticia">
                    [ {{ parsearFecha(atributo($attributes, 'fecha'), 'd-m-Y') }} ]
                </h6>

                <p class="card-text text-justify">{{ atributo($attributes, 'contenido') }}.</p>
            </div>

        </div>
    </div>
@endif
