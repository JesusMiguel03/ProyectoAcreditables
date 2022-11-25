@extends('adminlte::page')

@section('title', 'Acreditables | Mi cuenta')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Perfil de usuario</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('inicio.index') }}" class="text-primary">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="" class="text-primary">Mi cuenta</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')

    <div class="col-12">
        <div class="card p-4">

            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <h5 class="text-muted">Información de perfil</h5>
                </div>
                <div class="col-md-6 col-sm-12">
                    <a href="{{ route('inicio.index') }}" class="btn btn-outline-secondary float-right" style="width: 10rem">Volver a
                        inicio</a>
                </div>
            </div>

            <section class="row">

                <div class="col-md-6 col-sm-12 mt-3">
                    <form action="{{ route('user-profile-information.update') }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}

                        {{-- Nombre --}}
                        <div class="input-group mb-3">

                            <div class="col-6 px-2">
                                <label>Nombre</label>
                                <input type="text" name="nombre" class="form-control"
                                    value="{{ Auth::user()->nombre }}">
                            </div>

                            <div class="col-6 px-2">
                                <label>Apellido</label>
                                <input type="text" name="apellido" class="form-control"
                                    value="{{ Auth::user()->apellido }}">
                            </div>

                        </div>

                        {{-- Correo --}}
                        <div class="form-group mb-3 px-2">
                            <label>Correo</label>
                            <input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}">
                        </div>

                        {{-- Botones --}}
                        <div class="row px-2">
                            <div class="col-md-6 col-sm-12">
                                <button type="submit" class="btn btn-block btn-primary">
                                    {{ __('Actualizar perfil ') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>

                @can('preinscribir')
                    <div class="col-md-6 col-sm-12 mt-3">

                        {{-- Botones --}}
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <a href="{{ route('perfil.edit', Auth::user()->id) }}" class="btn btn-block btn-primary">
                                    {{ __('Perfil academico') }}
                                </a>
                            </div>
                        </div>

                    </div>
                @endcan


            </section>


        </div>
    </div>

    {{-- <x-app-layout>
        <div>
            <div class="card">
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8"> --}}
    {{-- Profile update --}}
    {{-- @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                        @livewire('profile.update-profile-information-form')

                        <x-jet-section-border />
                    @endif --}}

    {{-- Update password --}}
    {{-- @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.update-password-form')
                        </div>

                        <x-jet-section-border />
                    @endif --}}

    {{-- TwoFactor --}}
    {{-- @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.two-factor-authentication-form')
                        </div>

                        <x-jet-section-border />
                    @endif --}}

    {{-- Browsers --}}
    {{-- <div class="mt-10 sm:mt-0">
                        @livewire('profile.logout-other-browser-sessions-form')
                    </div> --}}

    {{-- Delete --}}
    {{-- @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                        <x-jet-section-border />

                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.delete-user-form')
                        </div>
                    @endif --}}
    {{-- </div>
            </div>
        </div>
    </x-app-layout> --}}
@stop
