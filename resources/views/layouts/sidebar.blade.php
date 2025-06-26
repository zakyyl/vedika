<aside class="main-sidebar sidebar-dark-primary elevation-4 d-flex flex-column">
    <a href="/dashboard" class="brand-link d-flex align-items-center">
        
        <span class="brand-text font-weight-light">VEDIKA</span>
    </a>

    <div class="sidebar flex-grow-1 d-flex flex-column">
        <nav class="mt-2 flex-grow-1">
            <ul class="nav nav-pills nav-sidebar flex-column h-100" data-widget="treeview" role="menu">

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

                <li class="nav-item flex-grow-1"></li>
                <li class="nav-item mt-auto">
                    <a href="#" class="nav-link text-danger"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
