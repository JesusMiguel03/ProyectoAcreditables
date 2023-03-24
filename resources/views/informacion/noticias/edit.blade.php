@extends('adminlte::page')

@section('title', 'Acreditables | Editar noticia')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('noticias.index') }}" class="link-muted">Noticias</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Noticias</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar noticia</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('noticias.update', $noticia) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.noticias :noticia="$noticia" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/buscar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/iconos/lapiz.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
@stop

@section('js')
    {{-- Personalizados --}}
    <script src="{{ asset('js/previsualizacion.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const titulo = document.getElementById('titulo')
        const descripcion = document.getElementById('descripcion')
        const boton = document.getElementById('formularioEnviar')

        let validacion = /^(?=[^_]*(?:[A-Za-zÀ-ÿ][^_]*){5})[^_]+$/g

        let [validacionTitulo, validacionDescripcion] = [
            validacion.test(titulo.value) && titulo.value.length > 5 && titulo.value.length < 30,
            validacion.test(descripcion.value) && descripcion.value.length > 15 && descripcion.value.length < 100
        ]

        if (!(validacionTitulo || validacionDescripcion)) {
            boton.disabled = true
        }

        const validarFormulario = () => {
            if (validacionTitulo && validacionDescripcion) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        titulo.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 30) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 30)
            }

            if (validacion.test(titulo.value) && e.currentTarget.value.length > 5 && e.currentTarget.value.length < 30) {
                e.currentTarget.classList.remove('is-invalid')
                validacionTitulo = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionTitulo = false
            }

            validarFormulario()
        })

        descripcion.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 100) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 100)
            }

            if (validacion.test(descripcion.value) && e.currentTarget.value.length > 15 && e.currentTarget.value.length < 100) {
                e.currentTarget.classList.remove('is-invalid')
                validacionDescripcion = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionDescripcion = false
            }

            validarFormulario()
        })
    </script>
@stop
