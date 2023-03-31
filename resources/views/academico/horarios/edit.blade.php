@extends('adminlte::page')

@section('title', 'Acreditables | Editar hora')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('horarios.index') }}" class="link-muted">Horarios</a></li>
    <li class="breadcrumb-item active"><a href="">Editar hora</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Horarios</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto mt-3">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar hora</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('horarios.update', $horario->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.horarios :horario="$horario" />
                </form>

                <form id="form" action="{{ route('horarios.destroy', $horario->id) }}" method="post">
                    @csrf
                    {{ method_field('DELETE') }}

                    <button id="borrar" type="submit" class="mt-2 btn btn-block btn-danger"
                        data-nombre="{{ $horario->nombreMateria() }}">
                        <i class="fas fa-trash mr-2"></i>
                        Borrar
                    </button>
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    @include('popper::assets')
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.min.js') }}"></script>

    {{-- Validaciones --}}
    <script>
        const espacio = document.getElementById('espacio')
        const aula = document.getElementById('aula')
        const enviarBoton = document.getElementById('formularioEnviar')

        const espacios = ['A', 'Edificio A', 'B', 'Edificio B', 'C', 'Edificio C']

        let [validacionEspacio, validacionAula] = [
            espacio.value.length > 0 && espacio.value.length < 31,
            aula.value === 0 || aula.value < 13 && espacio.value.length > 1 || espacios.includes(espacio.value)
        ]

        const validarFormulario = () => {
            if (validacionEspacio && validacionAula) {
                enviarBoton.removeAttribute('disabled')
            } else {
                enviarBoton.disabled = true
            }
        }

        validarFormulario()

        espacio.addEventListener('input', (e) => {
            espacio.value = espacio.value.replace(/[^A-zÀ-ÿ\s]+/g, '')
            espacio.value = espacio.value.replace(/ {2,}/g, '')

            if (espacio.value.length > 30) {
                espacio.value = espacio.value.slice(0, 30)
            }

            if (/^\p{L}+(?:\s+\p{L}+)*$/u.test(espacio.value)) {
                if (espacios.includes(espacio.value) && aula.value === '') {
                    aula.classList.add('is-invalid')
                    validacionAula = false
                } else {
                    aula.classList.remove('is-invalid')
                    validacionAula = true
                }

                if (espacio.value.length > 0 && espacio.value.length < 31) {
                    espacio.classList.remove('is-invalid')
                    validacionEspacio = true
                } else {
                    espacio.classList.add('is-invalid')
                    validacionEspacio = false
                }
            } else {
                espacio.classList.add('is-invalid')
                validacionEspacio = false
            }


            validarFormulario()
        })

        aula.addEventListener('input', (e) => {
            if (aula.value > 12) {
                aula.value = 12
            }

            if (aula.value === 0 || aula.value < 13 && espacio.value.length > 1 || espacios.includes(espacio
                .value)) {
                espacio.classList.remove('is-invalid')
                aula.classList.remove('is-invalid')
                validacionAula = true
            } else {
                espacio.classList.add('is-invalid')
                aula.classList.add('is-invalid')
                validacionAula = false
            }

            validarFormulario()
        })
    </script>

    <script>
        $(function() {
            $('#hora').datetimepicker({
                format: 'h:mm a'
            });
        });
    </script>

    {{-- Mensaje de borrar --}}
    <script>
        const form = document.getElementById('form')
        const boton = document.getElementById('borrar')

        boton.addEventListener('click', (e) => {
            e.preventDefault()

            Swal.fire({
                title: "¿Está seguro?",
                html: `La hora de <strong>${e.currentTarget.getAttribute('data-nombre')}</strong> será borrada`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirmar",
                cancelButtonText: "Cancelar",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-danger px-5 mr-2",
                    cancelButton: "btn btn-secondary px-5 ml-2",
                },

            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit()
                }
            })
        })
    </script>
@endsection
