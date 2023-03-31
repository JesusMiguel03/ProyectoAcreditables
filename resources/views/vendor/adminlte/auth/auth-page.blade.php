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
@stop

@section('classes_body'){{ ($auth_type ?? 'login') . '-page' }}@stop

@section('body')
    <div class="{{ $auth_type ?? 'login' }}-box">

        <div class="{{ $auth_type ?? 'login' }}-logo">
            <div class="card rounded-circle mx-auto" style="height: 120px; width: 120px; text-align: center;">
                <img src="{{ asset('vendor/img/logo.png') }}" alt="Logo de la UPTA" style="margin: auto;" height="90"
                    width="70">
            </div>

            <h2 class="text-white">Coordinación de Acreditables</h2>
        </div>

        {{-- Card Box --}}
        <div class="card">
            {{-- Logo --}}

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
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
@stop
