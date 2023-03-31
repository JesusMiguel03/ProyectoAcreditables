@extends('adminlte::page')

@section('title', 'Acreditables | Gráficos y estadísticas')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="">Estadísticas</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Gráficos y estadísticas</x-tipografia.titulo>
@stop

@section('content')
    {{-- Periodos --}}
    <div class="row">
        <section class="col-md-6 col-sm-12 mx-auto">

            <div class="form-group mb-3 card p-3">
                <div class="row">

                    <main class="col-12">
                        <label for="periodo" class="control-label">Periodos</label>

                        <div class="input-group">

                            <select id="periodo" class="form-control @error('periodo') is-invalid @enderror"
                                name="periodo" required>

                                <option value="" readonly>Seleccione...</option>

                                @php
                                    $conversor = [1 => 'I', 2 => 'II', 3 => 'III'];
                                @endphp

                                @foreach ($periodos as $periodo)
                                    <option value="{{ $periodo->id }}">
                                        {{ $conversor[$periodo->fase] . '-' . \Carbon\Carbon::parse($periodo->inicio)->format('Y') }}
                                    </option>
                                @endforeach
                            </select>

                            @error('periodo')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </main>

                    <footer class="mt-3 mx-auto col-md-4 col-sm-12">
                        <a id="btnPeriodo" class="btn btn-block btn-success disabled">
                            <i class="fas fa-search mr-2"></i>
                            {{ __('Buscar') }}
                        </a>
                    </footer>

                </div>
            </div>
        </section>
    </div>
@stop

@section('css')
    <link rel="stylesheet"
        href="{{ request()->secure() ? secure_asset('vendor/sweetalert2/bootstrap-4.min.css') : asset('vendor/sweetalert2/bootstrap-4.min.css') }}">
@stop

@section('js')
    <script
        src="{{ request()->secure() ? secure_asset('vendor/sweetalert2/sweetalert2.min.js') : asset('vendor/sweetalert2/sweetalert2.min.js') }}">
    </script>

    <script>
        const inputPeriodo = document.getElementById('periodo')
        const form = document.getElementById('form')
        const btn = document.getElementById('btnPeriodo')

        let periodo = 0

        inputPeriodo.addEventListener('change', (e) => {
            periodo = e.currentTarget.options[e.currentTarget.selectedIndex].value

            if (periodo == 0) {
                btn.classList.add('disabled')
            } else {
                btn.classList.remove('disabled')
            }
        })

        btn.addEventListener('click', (e) => {
            e.currentTarget.href = `${"{{ route('estadisticas.show') }}"}/${periodo}`
        })
    </script>

    <script>
        @if (session('noExiste'))
            Swal.fire({
                icon: 'info',
                title: '¡Ha ocurrido un error!',
                html: 'No hay estadísticas del periodo seleccionado.',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-info px-5'
                },
            })
        @elseif (session('inscripcionActiva'))
            Swal.fire({
                width: '60rem',
                icon: 'warning',
                title: '¡Inscripciones Activas!',
                html: "Las inscripciones aún se encuentran activas, por tal motivo no se pueden generar gráficos y/o mostrar estadísticas precisas. Estarán disponibles a partir del <strong>({{ session('inscripcionActiva') }})</strong>, <strong>45 días</strong> después de la fecha de inicio del periodo <strong>({{ session('fechaInicio') }})</strong>.",
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-warning px-5'
                },
            })
        @endif
    </script>
@stop
