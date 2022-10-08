{{-- Sidebar content --}}
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        {{-- User --}}
        <div class="user-panel my-2 pb-2 d-flex align-items-center">
            <div class="image">
                <img src="{{ asset('/dist/img/user2-128x128.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('login') }}" class="d-block font-weight-bold" style="margin-bottom: -0.5rem">Luis
                    Montes</a>
                <small class="text-muted font-weight-bold">Estudiante</small>
            </div>
        </div>

        {{-- Menu --}}
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('index') }}"
                        class="nav-link{{ (request()->routeIs('index') ? ' active' : '' || request()->routeIs('store')) ? ' active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Inicio</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('cursos.index') }}"
                        class="nav-link{{ request()->routeIs('cursos.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-th"></i>
                        <p>Cursos</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('estudiantes.index') }}"
                        class="nav-link{{ request()->routeIs('estudiantes.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Listado de estudiantes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('perfiles.index') }}"
                        class="nav-link{{ request()->routeIs('perfiles.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Perfiles de profesores</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('faq.index') }}"
                        class="nav-link{{ request()->routeIs('faq.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-question"></i>
                        <p>¿Sabias que...?</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
