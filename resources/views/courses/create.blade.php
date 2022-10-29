@extends('adminlte::page')

@section('title', 'Acreditables | Cursos')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Crear curso</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    {{-- Page content --}}
    <section class="content">
        <div class="container-fluid">
            <div class="card col-6 mx-auto p-4">
                <h2 class="card-header">Nuevo curso</h2>

                <div class="card-body">
                    <form action="/Cursos" method="post">
                        @csrf
    
                        {{-- Name field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" placeholder="{{ __('Nombre del curso') }}" autofocus>
    
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
    
                        {{-- Professor field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="professor" class="form-control @error('professor') is-invalid @enderror"
                                value="{{ old('professor') }}" placeholder="{{ __('Profesor encargado') }}" autofocus>
    
                            @error('professor')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
    
                        {{-- Quotas_available field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="quotas_available"
                                class="form-control @error('quotas_available') is-invalid @enderror"
                                value="{{ old('quotas_available') }}" placeholder="{{ __('Cupos disponibles') }}" autofocus>
    
                            @error('quotas_available')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
    
                        {{-- Description field --}}
                        <div class="input-group mb-3">
                            <input type="text" name="description"
                                class="form-control @error('description') is-invalid @enderror"
                                value="{{ old('description') }}" placeholder="{{ __('Descripción') }}" autofocus>
    
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
    
                        {{-- Login field --}}
                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('Cursos.index') }}" class="btn btn-block btn-secondary">
                                    {{ __('Volver') }}
                                </a>
                            </div>
                            <div class="col-6">
                                <button type=submit class="btn btn-block btn-primary">
                                    {{ __('Crear curso') }}
                                </button>
                            </div>
                        </div>
    
                    </form>
                </div>
            </div>
        </div>
    </section>
@stop

@section('footer')
