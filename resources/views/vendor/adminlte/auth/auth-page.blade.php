@extends('adminlte::master')

@php($dashboard_url = View::getSection('dashboard_url') ?? config('adminlte.dashboard_url', 'home'))

@if (config('adminlte.use_route_url', false))
    @php($dashboard_url = $dashboard_url ? route($dashboard_url) : '')
@else
    @php($dashboard_url = $dashboard_url ? url($dashboard_url) : '')
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    <div class="container-fluid bg-img">
        <div class="col-sm-12 col-md-4 offset-md-8 {{ Route::is('login') ? 'login' : 'register' }}">
            <div class="{{ $auth_type ?? 'login' }}-box">

                {{-- Logo --}}
                <div class="{{ $auth_type ?? 'login' }}-logo overlay">
                    <img src="{{ asset('vendor/img/logo.png') }}" alt="Logo de la UPTA" height="50">

                    <h2>Coordinación de Acreditables</h2>
                </div>

                {{-- Card Box --}}
                <div class="card">

                    {{-- Card Header --}}
                    @hasSection('auth_header')
                        <div class="card-body login-card-body">
                            <p class="login-box-msg">
                                @yield('auth_header')
                            </p>

                            @yield('auth_body')

                            @yield('auth_footer')
                        </div>
                    @endif

                </div>

            </div>
        </div>
    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
