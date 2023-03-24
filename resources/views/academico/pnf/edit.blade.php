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
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
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
            true,
            trayectos.value > 0 && trayectos.value < 11
        ]

        if (!(validacionNombre && validacionCodigo && validacionTrayectos)) {
            boton.disabled = true
        }

        const validarFormulario = () => {
            if (validacionNombre && validacionCodigo && validacionTrayectos) {
                boton.removeAttribute('disabled')
            } else {
                boton.disabled = true
            }
        }

        nombre.addEventListener('input', (e) => {
            e.currentTarget.value = e.currentTarget.value.replace(/[^a-zA-ZÀ-ÿ\s]+$/, '')

            if (e.currentTarget.value.length > 30) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 30)
            }

            if (e.currentTarget.value.length > 5 && e.currentTarget.value.length < 31) {
                e.currentTarget.classList.remove('is-invalid')
                validacionNombre = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionNombre = false
            }

            validarFormulario()
        })

        codigo.addEventListener('input', (e) => {
            e.currentTarget.value = e.currentTarget.value.replace(/[^a-zA-Z0-9]+/, '')

            if (e.currentTarget.value.length > 6) {
                e.currentTarget.value = e.currentTarget.value.length.slice(0, 30)
            }

            console.log(e.currentTarget.value.length)

            if (e.currentTarget.value.length === 0 || e.currentTarget.value.length > 3) {
                e.currentTarget.classList.remove('is-invalid')
                validacionCodigo = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionCodigo = false
            }

            validarFormulario()
        })

        trayectos.addEventListener('input', (e) => {
            if (e.currentTarget.value > 10) {
                e.currentTarget.value = 10
            }

            if (e.currentTarget.value > 0 && e.currentTarget.value < 11) {
                e.currentTarget.classList.remove('is-invalid')
                validacionTrayectos = true
            } else {
                e.currentTarget.classList.add('is-invalid')
                validacionTrayectos = false
            }

            validarFormulario()
        })
    </script>
@stop
