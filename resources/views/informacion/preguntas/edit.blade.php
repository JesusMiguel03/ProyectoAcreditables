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
            pregunta.value.length > 6 && pregunta.value.length < 31,
            respuesta.value.length > 20 && respuesta.value.length < 255
        ]

        const valiadarFormulario = () => {
            if (validacionPregunta && validacionRespuesta) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        valiadarFormulario()

        pregunta.addEventListener('input', (e) => {
            pregunta.value = pregunta.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            pregunta.value = pregunta.value.replace(/ {2,}/g, '')

            if (pregunta.value.length > 30) {
                pregunta.value = pregunta.value.slice(0, 30)
            }

            if (/^[\p{L}\s]+(?:[\p{L}\s]+)*$/u.test(pregunta.value)) {
                if (pregunta.value.length > 6 && pregunta.value.length < 31) {
                    pregunta.classList.remove('is-invalid')
                    validacionPregunta = true
                } else {
                    pregunta.classList.add('is-invalid')
                    validacionPregunta = false
                }
            } else {
                pregunta.classList.add('is-invalid')
                validacionPregunta = false
            }

            valiadarFormulario()
        })

        respuesta.addEventListener('input', (e) => {
            respuesta.value = respuesta.value.replace(/[^A-zÀ-ÿ0-9(),."\s]+/g, '')
            respuesta.value = respuesta.value.replace(/ {2,}/g, '')
            respuesta.value = respuesta.value.replace('_', '')

            if (respuesta.value.length > 255) {
                respuesta.value = respuesta.value.slice(0, 255)
            }

            if (/^[\p{L}\s(),"\d,.]+(?:[\p{L}()\s",.\d]+)*$/u.test(respuesta.value)) {
                if (respuesta.value.length > 20 && respuesta.value.length < 255) {
                    respuesta.classList.remove('is-invalid')
                    validacionRespuesta = true
                } else {
                    respuesta.classList.add('is-invalid')
                    validacionRespuesta = false
                }
            } else {
                respuesta.classList.add('is-invalid')
                validacionRespuesta = false
            }

            valiadarFormulario()
        })
    </script>
@stop
