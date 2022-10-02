<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('/dist/img/user2-128x128.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('login') }}" class="d-block font-weight-bold">Usuario</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
            with font-awesome or any other icon font library -->
                {{-- {{ dump(request()->route()->getName()) }} --}}
                <li class="nav-item">
                    <a href="{{ route('index') }}"
                        class="nav-link{{ (request()->routeIs('index') ? ' active' : '' || request()->routeIs('store')) ? ' active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Página Principal</p>
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
                    <a href="{{ route('perfiles.index') }}"
                        class="nav-link{{ request()->routeIs('perfiles.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>Perfiles de profesores</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('estudiantes.index') }}"
                        class="nav-link{{ request()->routeIs('estudiantes.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>Listado de estudiantes</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('faq.index') }}"
                        class="nav-link{{ request()->routeIs('faq.*') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-question"></i>
                        <p>Preguntas Frecuentes</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
