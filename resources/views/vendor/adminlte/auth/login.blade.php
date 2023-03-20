@extends('adminlte::auth.auth-page', ['auth_type' => 'login'])

@section('adminlte_css_pre')
    <link rel="stylesheet" href="{{ asset('vendor/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stop

@php($login_url = View::getSection('login_url') ?? config('adminlte.login_url', 'login'))
@php($register_url = View::getSection('register_url') ?? config('adminlte.register_url', 'register'))
@php($password_reset_url = View::getSection('password_reset_url') ?? config('adminlte.password_reset_url', 'password/reset'))

@if (config('adminlte.use_route_url', false))
    @php($login_url = $login_url ? route($login_url) : '')
    @php($register_url = $register_url ? route($register_url) : '')
    @php($password_reset_url = $password_reset_url ? route($password_reset_url) : '')
@else
    @php($login_url = $login_url ? url($login_url) : '')
    @php($register_url = $register_url ? url($register_url) : '')
    @php($password_reset_url = $password_reset_url ? url($password_reset_url) : '')
@endif

@section('title', 'Acreditables | Iniciar sesión')

@section('auth_header', __('Inicia sesión para acceder'))

@section('auth_body')
    <form action="{{ $login_url }}" method="post">
        @csrf

        {{-- Correo --}}
        <div class="form-group required">
            <label for="email" class="control-label">Correo</label>
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}" placeholder="{{ __('Ej: micorreo@gmail.com') }}" autofocus required>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope {{ config('adminlte.classes_auth_icon', '') }}"></span>
                    </div>
                </div>

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        {{-- Contraseña --}}
        <div class="form-group required">
            <label for="password" class="control-label">Contraseña</label>
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="{{ __('Contraseña') }}" required>

                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                    </div>
                </div>

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <x-modal.mensaje-obligatorio />

        <div class="row">
            <div class="col-6 text-center">
                <a href="{{ $register_url }}" class="btn text-primary">
                    {{ __('Registrarme') }}
                </a>
            </div>

            <div class="col-6">
                <button type=submit class="btn btn-block btn-primary">
                    {{ __('Iniciar Sesión') }}
                </button>
            </div>
        </div>

    </form>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/estilosVarios/required.css') }}">
@stop
