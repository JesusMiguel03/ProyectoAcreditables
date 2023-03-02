@extends('adminlte::page')

@section('title', 'Acreditables | Editar trayecto')

@section('rutas')
    <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="link-muted">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('trayectos.index') }}" class="link-muted">Trayectos</a></li>
    <li class="breadcrumb-item active"><a href="">Editar</a></li>
@stop

@section('content_header')
    <x-tipografia.titulo>Trayectos</x-tipografia.titulo>
@stop

@section('content')
    <div class="col-md-6 col-sm-12 mx-auto">
        <div class="card">
            <header class="card-header bg-primary">
                <h5>Editar trayecto</h5>
            </header>

            <main class="card-body">
                <form action="{{ route('trayectos.update', $trayecto) }}" method="post">
                    @csrf
                    {{ method_field('PUT') }}

                    <x-formularios.trayectos :numero="$trayecto->num_trayecto" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
@stop
