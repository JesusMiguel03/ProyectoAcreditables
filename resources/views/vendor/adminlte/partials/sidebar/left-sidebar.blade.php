<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar menu --}}
    <div class="sidebar">
        
        {{-- Sidebar User --}}
        <div class="user-panel my-2 pb-2 d-flex align-items-center">
            <div class="image">
                <img src="{{ asset('vendor/img/profs/user6.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <p class="d-block font-weight-bold" style="margin-bottom: -0.5rem; color: #c2c7d0">
                    {{ Auth::user()->name }}</p>
                <small class="text-muted font-weight-bold">Estudiante</small>
            </div>
        </div>

        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if (config('adminlte.sidebar_nav_animation_speed') != 300) data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}" @endif
                @if (!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
                {{-- Configured sidebar links --}}
                @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item')
            </ul>
        </nav>
    </div>

</aside>
