@extends('adminlte::page')

@section('title', 'Acreditables | Editar área de conocimiento')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('conocimientos.index') }}" class="link-muted">Áreas de
            conocimiento</a></li>
    <li class="breadcrumb-item active"><a href="">Editar área de conocimiento</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Áreas de conocimiento</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto mt-3">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar área de conocimiento</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('conocimientos.update', $conocimiento) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.area-conocimiento :nombre="$conocimiento->nom_conocimiento" :descripcion="$conocimiento->desc_conocimiento" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet" href="{{ asset('css/descripcion.css') }}">
    <link rel="stylesheet" href="{{ asset('css/iconos/lapiz.css') }}">
@stop

@section('js')
    <script>
        const nombre = document.getElementById('nombre')
        const descripcion = document.getElementById('descripcion')
        const boton = document.getElementById('formularioEnviar')

        let [validarNombre, validarDescripcion] = [
            nombre.value.length > 4 && nombre.value.length < 51,
            descripcion.value.length > 10 && descripcion.value.length < 256
        ]

        boton.disabled = true

        const validarFormulario = () => {
            if (validarNombre && validarDescripcion) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        nombre.addEventListener('input', (e) => {
            nombre.value = nombre.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            nombre.value = nombre.value.replace(/ {2,}/g, '')

            if (nombre.value.length > 51) {
                nombre.value = nombre.value.slice(0, 51)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(nombre.value)) {
                if (nombre.value.length > 4 && nombre.value.length < 51) {
                    nombre.classList.remove('is-invalid')
                    validarNombre = true
                } else {
                    nombre.classList.add('is-invalid')
                    validarNombre = false
                }
            } else {
                nombre.classList.add('is-invalid')
                validarNombre = false
            }

            validarFormulario()
        })

        descripcion.addEventListener('input', (e) => {
            descripcion.value = descripcion.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            descripcion.value = descripcion.value.replace(/ {2,}/g, '')

            if (descripcion.value.length > 256) {
                descripcion.value = descripcion.value.slice(0, 256)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(descripcion.value)) {
                if (descripcion.value.length > 10 && descripcion.value.length < 256) {
                    descripcion.classList.remove('is-invalid')
                    validarDescripcion = true
                } else {
                    descripcion.classList.add('is-invalid')
                    validarDescripcion = false
                }
            } else {
                descripcion.classList.add('is-invalid')
                validarDescripcion = false
            }

            validarFormulario()
        })
    </script>
@stop