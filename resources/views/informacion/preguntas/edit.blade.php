@extends('adminlte::page')

@section('title', 'Acreditables | Editar pregunta')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('preguntas.index') }}" class="link-muted">Preguntas frecuentes</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Preguntas frecuentes</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Cambiar datos</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('preguntas.update', $pregunta->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.preguntas :pregunta="$pregunta" />
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
    {{-- Validaciones --}}
    <script>
        const pregunta = document.getElementById('pregunta')
        const respuesta = document.getElementById('respuesta')
        const boton = document.getElementById('formularioEnviar')

        let [validacionPregunta, validacionRespuesta] = [
            pregunta.value.length > 10 && pregunta.value.length < 31,
            respuesta.value.length > 20 && respuesta.value.length < 255
        ]

        if (!(pregunta && respuesta)) {
            boton.disabled = true
        }

        const valiadarFormulario = () => {
            if (validacionPregunta && validacionRespuesta) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        pregunta.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 30) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 30)
            }

            if (e.currentTarget.value.length > 10 && e.currentTarget.value.length < 31) {
                e.currentTarget.classList.remove('is-invalid')
                validacionPregunta = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionPregunta = false
            }

            valiadarFormulario()
        })

        respuesta.addEventListener('input', (e) => {
            if (e.currentTarget.value.length > 255) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 255)
            }

            if (e.currentTarget.value.length > 20 && e.currentTarget.value.length < 255) {
                e.currentTarget.classList.remove('is-invalid')
                validacionRespuesta = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionRespuesta = false
            }

            valiadarFormulario()
        })
    </script>
@stop
