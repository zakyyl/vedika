<aside class="main-sidebar sidebar-dark-primary elevation-4 d-flex flex-column">
    <a href="/dashboard" class="brand-link d-flex align-items-center">
        <span class="brand-text font-weight-light">VEDIKA</span>
    </a>

    <div class="sidebar d-flex flex-column" style="flex: 1; overflow-y: auto;">
        <nav class="mt-1" style="flex-grow: 1;">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" style="gap: 2px;">

                <li class="nav-item">
                    <a href="/dashboard" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if(in_array(auth()->user()->roles, ['casemix', 'admin']))
                <li class="nav-header text-light"
                    style="font-size: 0.75rem; padding: 6px 10px 3px; border-bottom: 1px solid rgba(255,255,255,0.07);">
                    <i class="fas fa-layer-group mr-1"></i> CASEMIX
                </li>
                <li class="nav-item">
                    <a href="/rawatjalan" class="nav-link {{ request()->is('rawatjalan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-md"></i>
                        <p>Rawat Jalan</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/rawatinap" class="nav-link {{ request()->is('rawatinap') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-procedures"></i>
                        <p>Rawat Inap</p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ request()->routeIs('triase*','soap*','triase-sekunder*','triase-primer*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ request()->routeIs('triase*','soap*','triase-sekunder*','triase-primer*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-procedures"></i>
                        <p>
                            Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{ route('triase.index') }}"
                                class="nav-link {{ request()->routeIs('triase.*') ? 'active' : '' }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Data Triase</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ route('triase-primer.index') }}"
                                class="nav-link {{ request()->routeIs('triase-primer*') ? 'active' : '' }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Triase Primer</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('triase-sekunder.index') }}"
                                class="nav-link {{ request()->routeIs('triase-sekunder*') ? 'active' : '' }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>Triase Sekunder</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('soap.index') }}"
                                class="nav-link {{ request()->routeIs('soap*') ? 'active' : '' }}">
                                <i class="fas fa-file-alt nav-icon"></i>
                                <p>S.O.A.P Ralan / Ranap</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="/download" class="nav-link {{ request()->is('download') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-download"></i>
                        <p>Download</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/hapus" class="nav-link {{ request()->is('hapus') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-trash"></i>
                        <p>Hapus</p>
                    </a>
                </li>

                @endif

                {{-- BPJS Section --}}
                @if(in_array(auth()->user()->roles, ['bpjs', 'admin']))
                <li class="nav-header text-light mt-1"
                    style="font-size: 0.75rem; padding: 6px 10px 3px; border-bottom: 1px solid rgba(255,255,255,0.07);">
                    <i class="fas fa-briefcase-medical mr-1"></i> BPJS
                </li>
                <li class="nav-item">
                    <a href="/bpjs/rawatjalan" class="nav-link {{ request()->is('bpjs/rawatjalan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-notes-medical"></i>
                        <p>Rawat Jalan BPJS</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/bpjs/rawatinap" class="nav-link {{ request()->is('bpjs/rawatinap') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-bed"></i>
                        <p>Rawat Inap BPJS</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        {{-- Logout di pojok bawah --}}
        <div class="mt-auto">
            <ul class="nav nav-pills nav-sidebar flex-column">
                <li class="nav-item">
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
        </div>
    </div>
</aside>