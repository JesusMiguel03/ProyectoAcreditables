@extends('adminlte::page')

@section('title', 'Acreditables | Mi cuenta')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0">Coordinación de Acreditables</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('student.index') }}" class="text-primary">Inicio</a></li>
                <li class="breadcrumb-item active"><a href="" class="text-primary">Mi cuenta</a></li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <x-app-layout>
        <div>
            <div class="card">
                <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                    {{-- Profile update --}}
                    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                        @livewire('profile.update-profile-information-form')

                        <x-jet-section-border />
                    @endif

                    {{-- Update password --}}
                    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                        <div class="mt-10 sm:mt-0">
                            @livewire('profile.update-password-form')
                        </div>

                        <x-jet-section-border />
                    @endif

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
                </div>
            </div>
        </div>
    </x-app-layout>
@stop

@section('footer')

@section('css')
@stop

@section('js')
@stop
