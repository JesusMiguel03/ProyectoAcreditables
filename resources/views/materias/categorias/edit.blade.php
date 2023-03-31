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

        let validacionNombre = nombre.value.length > 5 && nombre.value.length < 51

        const validarFormulario = () => {
            validacionNombre ? boton.removeAttribute('disabled') : boton.disabled = true
        }

        validarFormulario()

        nombre.addEventListener('input', (e) => {
            nombre.value = nombre.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            nombre.value = nombre.value.replace(/ {2,}/g, '')
            nombre.value = nombre.value.replace('_', '')

            if (nombre.value.length > 50) {
                nombre.value = nombre.value.slice(0, 50)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(nombre.value)) {
                if (nombre.value.length > 5 && nombre.value.length < 51) {
                    nombre.classList.remove('is-invalid')
                    validacionNombre = true
                } else {
                    nombre.classList.add('is-invalid')
                    validacionNombre = false
                }
            } else {
                nombre.classList.add('is-invalid')
                validacionNombre = false
            }

            validarFormulario()
        })
    </script>
@stop
