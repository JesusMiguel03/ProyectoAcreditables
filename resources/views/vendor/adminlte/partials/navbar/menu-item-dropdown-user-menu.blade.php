@php($logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout'))
@php($profile_url = View::getSection('profile_url') ?? config('adminlte.profile_url', 'logout'))

@if (config('adminlte.usermenu_profile_url', false))
    @php($profile_url = Auth::user()->adminlte_profile_url())
@endif

@if (config('adminlte.use_route_url', false))
    @php($profile_url = $profile_url ? route($profile_url) : '')
    @php($logout_url = $logout_url ? route($logout_url) : '')
@else
    @php($profile_url = $profile_url ? url($profile_url) : '')
    @php($logout_url = $logout_url ? url($logout_url) : '')
@endif

@php
    $avatar = Auth::user()->avatar ?? null;
    
    if (request()->secure()) {
        $avatar = !empty($avatar) ? secure_asset('vendor/img/avatares/' . $avatar . '.webp') : secure_asset('vendor/img/defecto/usuario.webp');
    } else {
        $avatar = !empty($avatar) ? asset('vendor/img/avatares/' . $avatar . '.webp') : asset('vendor/img/defecto/usuario.webp');
    }
@endphp

<li class="nav-item dropdown user-menu d-flex align-items-center">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle p-2" data-toggle="dropdown">
        <img src="{{ $avatar }}" class="avatar-usuario user-image img-circle" alt="Imagen de usuario">
    </a>

    <div style="margin-top: -0.2rem">
        <h6 class="d-block text-muted font-weight-bold" style="margin-bottom: -0.5rem">
            {{ Auth::user()->nombreCompleto() }}
        </h6>
        <small class="text-muted text-weight-bold">{{ rolUsuarioConectado() }}</small>
    </div>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu rounded" style="width: 9rem">

        {{-- User menu footer --}}
        <li class="user-footer rounded">
            @can('perfil')
                <a class="d-block p-2 link-muted" href="{{ route('perfil.index') }}">
                    <i class="fas fa-cog mr-2"></i>
                    {{ __('Perfil') }}
                </a>
            @endcan
            <a class="d-block p-2 mt-2 link-muted" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-door-open mr-2"></i>
                {{ __('adminlte::adminlte.log_out') }}
            </a>
            <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
                @if (config('adminlte.logout_method'))
                    {{ method_field(config('adminlte.logout_method')) }}
                @endif
                {{ csrf_field() }}
            </form>
        </li>

    </ul>

</li>
