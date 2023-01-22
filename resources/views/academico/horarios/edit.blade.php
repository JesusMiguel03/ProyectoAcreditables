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
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@stop

@section('js')
    <script src="{{ asset('vendor/moment/moment.js') }}"></script>
    <script src="{{ asset('vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script>
        $(function() {
            $('#hora').datetimepicker({
                format: 'h:mm a'
            });
        });
    </script>

    <script src="{{ asset('js/mensajeMostrarLimite.js') }}"></script>
@endsection
