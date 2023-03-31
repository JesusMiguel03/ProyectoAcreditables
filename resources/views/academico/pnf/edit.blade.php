@extends('adminlte::page')

@section('title', 'Acreditables | Editar pnf')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('pnfs.index') }}" class="link-muted">PNF</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>PNF</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar PNF</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('pnfs.update', $pnf) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.pnfs :pnf="$pnf" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('css/estilosVarios/required.css') : asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    {{-- Validaciones --}}
    <script>
        const nombre = document.getElementById('nombre')
        const codigo = document.getElementById('codigo')
        const trayectos = document.getElementById('trayectos')
        const boton = document.getElementById('formularioEnviar')

        let [validacionNombre, validacionCodigo, validacionTrayectos] = [
            nombre.value.length > 5 && nombre.value.length < 31,
            codigo.value.length === 0 || codigo.value.length > 3,
            trayectos.value > 0 && trayectos.value < 11
        ]

        const validarFormulario = () => {
            if (validacionNombre && validacionCodigo && validacionTrayectos) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        validarFormulario()

        nombre.addEventListener('input', (e) => {
            nombre.value = nombre.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            nombre.value = nombre.value.replace(/ {2,}/g, '')

            if (nombre.value.length > 20) {
                nombre.value = nombre.value.slice(0, 20)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(nombre.value)) {
                if (nombre.value.length > 5 && nombre.value.length < 31) {
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

        codigo.addEventListener('input', (e) => {
            codigo.value = codigo.value.replace(/[^a-zA-Z0-9]+/, '')

            if (codigo.value.length > 6) {
                codigo.value = codigo.value.length.slice(0, 30)
            }

            if (codigo.value.length === 0 || codigo.value.length > 3) {
                codigo.classList.remove('is-invalid')
                validacionCodigo = true
            } else {
                codigo.classList.add('is-invalid')
                validacionCodigo = false
            }

            validarFormulario()
        })

        trayectos.addEventListener('input', (e) => {
            if (trayectos.value > 10) {
                trayectos.value = 10
            }

            if (trayectos.value < 1) {
                trayectos.value = 1
            }

            if (trayectos.value > 0 && trayectos.value < 11) {
                trayectos.classList.remove('is-invalid')
                validacionTrayectos = true
            } else {
                trayectos.classList.add('is-invalid')
                validacionTrayectos = false
            }

            validarFormulario()
        })
    </script>
@stop
