@extends('adminlte::page')

@section('title', 'Acreditables | Mi perfil')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="">Cuenta</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body" style="height: 21.7rem;">
                            <div class="row">

                                <div class="col-sm-12 col-md-6">
                                    <h3>Actualizar mi información</h3>
                                </div>
                                <div class="col-sm-12 col-md-6">

                                    <form action="{{ route('Perfil.index') }}" method="post">

                                        @csrf

                                        <div class="input-group mb-3">
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror"
                                                value="{{ $profile['name'] }}" placeholder="{{ __('Nombre y apellido') }}"
                                                required autofocus>

                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span
                                                        class="fas fa-user {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                </div>
                                            </div>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="input-group mb-3">
                                            <input type="email" name="email"
                                                class="form-control @error('email') is-invalid @enderror"
                                                value="{{ $profile['email'] }}" placeholder="{{ __('Correo electrónico') }}"
                                                required autofocus>

                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span
                                                        class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                </div>
                                            </div>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="input-group mb-3">
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="{{ __('Contraseña') }}" required autofocus>

                                            <div class="input-group-append">
                                                <div class="input-group-text">
                                                    <span
                                                        class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                                </div>
                                            </div>

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="col-6 mx-auto">
                                            <button type=submit class="btn btn-block btn-primary">
                                                {{ __('Cambiar datos') }}
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('footer')

@section('css')
@stop

@section('js')
@stop
