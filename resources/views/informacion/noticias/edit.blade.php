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
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet" href="{{ request()->secure() ? secure_asset('css/buscar.css') : asset('css/buscar.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/iconos/lapiz.css') : asset('css/iconos/lapiz.css') }}">
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/descripcion.css') : asset('css/descripcion.css') }}">
@stop

@section('js')
    {{-- Personalizados --}}
    <script src="{{ request()->secure() ? secure_asset('js/previsualizacion.js') : asset('js/previsualizacion.js') }}">
    </script>

    {{-- Validaciones --}}
    <script>
        const titulo = document.getElementById('titulo')
        const descripcion = document.getElementById('descripcion')
        const activo = document.getElementById('mostrar')
        const boton = document.getElementById('formularioEnviar')

        const estados = ['0', '1']

        let [validacionTitulo, validacionDescripcion, validacionActivo] = [
            titulo.value.length > 5 && titulo.value.length < 30,
            descripcion.value.length > 15 && descripcion.value.length < 100,
            estados.includes(activo.options[activo.selectedIndex].value)
        ]

        const validarFormulario = () => {
            if (validacionTitulo && validacionDescripcion && validacionActivo) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        validarFormulario()

        titulo.addEventListener('input', (e) => {
            titulo.value = titulo.value.replace(/[^A-zÀ-ÿ0-9¡?¿!\s]+/g, '')
            titulo.value = titulo.value.replace(/ {2,}/g, '')

            if (titulo.value.length > 30) {
                titulo.value = titulo.value.slice(0, 30)
            }

            if (/^[\p{L}\p{N}\s¿?¡!]+(?:[\p{L}\p{N}\s¿?¡!]+)*$/u.test(titulo.value)) {
                if (titulo.value.length > 4 && titulo.value.length < 31) {
                    titulo.classList.remove('is-invalid')
                    validacionTitulo = true
                } else {
                    titulo.classList.add('is-invalid')
                    validacionTitulo = false
                }
            } else {
                titulo.classList.add('is-invalid')
                validacionTitulo = false
            }

            validarFormulario()
        })

        descripcion.addEventListener('input', (e) => {
            descripcion.value = descripcion.value.replace(/[^A-zÀ-ÿ0-9¡?¿!\s]+/g, '')
            descripcion.value = descripcion.value.replace(/ {2,}/g, '')

            if (descripcion.value.length > 100) {
                descripcion.value = descripcion.value.slice(0, 100)
            }

            if (/^[\p{L}\p{N}\s¿?¡!]+(?:[\p{L}\p{N}\s¿?¡!]+)*$/u.test(descripcion.value)) {
                if (descripcion.value.length > 14 && descripcion.value.length < 100) {
                    descripcion.classList.remove('is-invalid')
                    validacionDescripcion = true
                } else {
                    descripcion.classList.add('is-invalid')
                    validacionDescripcion = false
                }
            } else {
                descripcion.classList.add('is-invalid')
                validacionDescripcion = false
            }

            validarFormulario()
        })

        activo.addEventListener('change', (e) => {
            if (estados.includes(activo.options[activo.selectedIndex].value)) {
                activo.classList.remove('is-invalid')
                validacionActivo = true
            } else {
                activo.classList.add('is-invalid')
                validacionActivo = false
            }

            validarFormulario()
        })
    </script>
@stop
