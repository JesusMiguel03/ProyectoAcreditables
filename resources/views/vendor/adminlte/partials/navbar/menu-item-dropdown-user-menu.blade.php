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

<li class="nav-item dropdown user-menu d-flex align-items-center">

    {{-- User menu toggler --}}
    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
        <img src="{{ asset('vendor/img/profs/user6.jpg') }}" class="user-image img-circle" alt="Imagen de usuario">
        <i class="fa fa-chevron-down" style="margin-left: -0.5rem; margin-top: -0.7rem;font-size: 0.7rem"></i>
    </a>

    <div style="margin-top: -0.2rem">
        <h6 class="d-block text-muted font-weight-bold" style="margin-bottom: -0.5rem">
            {{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</h6>
        <small class="text-muted text-weight-bold">{{ Auth::user()->getRoleNames()[0] }}</small>
    </div>

    {{-- User menu dropdown --}}
    <ul class="dropdown-menu rounded" style="width: 11rem">

        {{-- User menu footer --}}
        <li class="user-footer rounded">
            <a class="btn btn-outline-secondary btn-block mt-2" href="{{ route('perfil.index') }}">
                <i class="fas fa-cog"></i>
                {{ __('Perfil') }}
            </a>
            <a class="btn btn-outline-secondary btn-block mt-2" href="#"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-door-open"></i>
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
