@extends('adminlte::page')

@section('title', 'Acreditables | Editar categoria')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('categorias.index') }}" class="link-muted">Categorias</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Categorías</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar categoria</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('categorias.update', $categoria) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.categorias :nombre="$categoria->nom_categoria" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    {{-- Validaciones --}}
    <script>
        const nombre = document.getElementById('nombre')
        const boton = document.getElementById('formularioEnviar')

        let validacionNombre = /^(?=[^_]*(?:[A-Za-zÀ-ÿ][^_]*){3})[^_]+$/g.test(nombre.value) && nombre
            .value.length > 5 && nombre.value.length < 51

        if (!validacionNombre) {
            boton.disabled = true
        }

        nombre.addEventListener('input', (e) => {
            // Valida que tenga minimo 5 letras, pueden tener acentos y espacios, pero no pueden ser solo espacios
            let validacion = /^(?=[^_]*(?:[A-Za-zÀ-ÿ][^_]*){3})[^_]+$/g.test(nombre.value)

            e.currentTarget.value = e.currentTarget.value.replace(/[^A-zÀ-ÿ0-9\s]|[_]+/g, '')

            // Si es mayor a 50 quita los caracteres extra
            if (e.currentTarget.value.length > 50) {
                e.currentTarget.value = e.currentTarget.value.slice(0, 50)
            }

            // Debe ser mayor a 5 y menor a 51
            if (validacion && e.currentTarget.value.length > 5 && e.currentTarget.value.length < 51) {
                validacionNombre = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validacionNombre = false
                e.currentTarget.classList.add('is-invalid')
            }

            if (validacionNombre) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        })
    </script>
@stop
