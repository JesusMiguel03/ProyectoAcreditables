<div class="col-sm-12 col-md-3">
    <div class="card border pt-2 text-center">
        <strong>{{ atributo($attributes, 'nombre') }}</strong>
        <p class="{{ atributo($attributes, 'contenido') === 'Sin asignar' ? 'text-info' : 'text-muted' }} campo">
            {{ atributo($attributes, 'contenido') }}
        </p>
    </div>
</div>

@section('css')
    <link rel="stylesheet" href="{{ asset('css/decoracion.css') }}">
@endsection