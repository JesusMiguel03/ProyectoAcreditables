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

                    <x-formularios.pnfs :pnf="$pnf->nom_pnf" :codigo="$pnf->cod_pnf" />
                </form>
            </main>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/required.css') }}">
@stop

@section('js')
    {{-- <script src="{{ asset('js/mensajeMostrarLimite.js') }}"></script> --}}
@stop
