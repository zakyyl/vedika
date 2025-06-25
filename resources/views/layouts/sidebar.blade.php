<!-- Sidebar AdminLTE 3 hasil konversi dari Materio -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/dashboard" class="brand-link">
    <span class="brand-logo">
      <svg width="30" height="24" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M12.3 1.25L56.65 28.64C59.03 30.11 60.48 32.71 60.48 35.51V160.63C60.48 163.47 58.99 166.10 56.56 167.55L12.21 194.11C8.38 196.39 3.43 195.15 1.14 191.33C0.40 190.07 0 188.64 0 187.18V8.12C0 3.66 3.61 0.05 8.06 0.05C9.56 0.05 11.03 0.47 12.3 1.25Z"
          fill="currentColor" />
      </svg>
    </span>
    <span class="brand-text font-weight-light">VEDIKA</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <li class="nav-item">
          <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/rawatjalan" class="nav-link {{ request()->is('rawatjalan*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-md"></i>
            <p>Rawat Jalan</p>
          </a>
        </li>

        <li class="nav-item">
          <a href="/rawatinap" class="nav-link {{ request()->is('rawatinap*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-procedures"></i>
            <p>Rawat Inap</p>
          </a>
        </li>
        <li class="nav-header">USER</li>
        <li class="nav-item">
          <a href="#" class="nav-link disabled">
            <i class="nav-icon fas fa-user-circle"></i>
            <p class="text">{{ Auth::user()->fullname ?? Auth::user()->username }}</p>
          </a>
        </li>

        <li class="nav-item">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-danger text-left">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>Logout</p>
            </button>
          </form>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
