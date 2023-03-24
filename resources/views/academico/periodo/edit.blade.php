@extends('adminlte::page')

@section('title', 'Acreditables | Periodo')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('periodos.index') }}" class="link-muted">Periodos</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Periodo</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar periodo</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('periodos.update', $periodoEditar->id) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.periodo :periodo="$periodoEditar" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $(function() {
            $('#inicio').datetimepicker({
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        });
        $(function() {
            $('#fin').datetimepicker({
                locale: 'es',
                format: 'YYYY-MM-DD'
            });
        });
        $("#fin").on("change.datetimepicker", function(e) {
            $('#inicio').datetimepicker('maxDate', e.date);
        });
    </script>

    {{-- Validaciones --}}
    <script>
        const fase = document.getElementById('fase')

        fase.addEventListener('input', (e) => {
            if (e.currentTarget.value > 3) {
                e.currentTarget.value = 3

                validacionFase = true
            }

            if (e.currentTarget.value < 0) {
                e.currentTarget.value = 1

                validacionFase = true
            }
        })
    </script>
@stop
