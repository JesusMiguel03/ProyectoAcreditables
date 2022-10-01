  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">Usuario</a>
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
                  <li class="nav-item">
                      <a href="/" class="nav-link{{ request()->routeIs('home') ? ' active' : '' }}">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Página Principal</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="cursos" class="nav-link{{ request()->routeIs('cursos') ? ' active' : '' }}">
                          <i class="nav-icon fas fa-th"></i>
                          <p>Cursos</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="perfiles" class="nav-link{{ request()->routeIs('perfiles.index') ? ' active' : '' }}">
                          <i class="nav-icon fas fa-copy"></i>
                          <p>Perfiles de profesores</p>
                      </a>
                  </li>
                  <li class="nav-item">
                    <a href="courses" class="nav-link{{ request()->routeIs('courses.index') ? ' active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>Listado de estudiantes</p>
                    </a>
                </li>
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
