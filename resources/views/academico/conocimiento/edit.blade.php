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

        let validarNombre = true
        let validarDescripcion = true

        const validarFormulario = () => {
            if (validarNombre && validarDescripcion) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        nombre.addEventListener('input', (e) => {
            let validacion = /^(?=[^_]*(?:[A-Za-zÀ-ÿ][^_]*){5})[^_]+$/g

            if (e.currentTarget.value.length > 4 && e.currentTarget.value.length < 51 && validacion.test(e.currentTarget.value)) {
                validarNombre = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarNombre = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })

        descripcion.addEventListener('input', (e) => {
            let validacion = /^(?=[^_]*(?:[A-Za-zÀ-ÿ][^_]*){10})[^_]+$/g

            if (e.currentTarget.value.length > 15 && e.currentTarget.value.length < 256 && validacion.test(e.currentTarget.value)) {
                validarDescripcion = true
                e.currentTarget.classList.remove('is-invalid')
            } else {
                validarDescripcion = false
                e.currentTarget.classList.add('is-invalid')
            }

            validarFormulario()
        })
    </script>
@stop