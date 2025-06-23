<!doctype html>
<html lang="en" class="layout-menu-fixed layout-compact" data-assets-path="../assets/" data-template="vertical-menu-template-free">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="robots" content="noindex, nofollow" />
    <title>Demo: RS</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('materio/assets/img/favicon/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('materio/assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('materio/assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('materio/assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('materio/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('materio/assets/css/demo.css') }}" />

    <script src="{{ asset('materio/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('materio/assets/js/config.js') }}"></script>
  </head>

  <body style="background: url('{{ asset('materio/assets/img/backgrounds/beger.jpg') }}') no-repeat center center fixed; background-size: cover;">
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme d-flex flex-column">
          <div class="app-brand demo">
            <a href="/dashboard" class="app-brand-link">
              <span class="app-brand-logo demo me-1">
                <span class="text-primary">
                  <svg width="30" height="24" viewBox="0 0 250 196" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M12.3 1.25L56.65 28.64C59.03 30.11 60.48 32.71 60.48 35.51V160.63C60.48 163.47 58.99 166.10 56.56 167.55L12.21 194.11C8.38 196.39 3.43 195.15 1.14 191.33C0.40 190.07 0 188.64 0 187.18V8.12C0 3.66 3.61 0.05 8.06 0.05C9.56 0.05 11.03 0.47 12.3 1.25Z" fill="currentColor" />
                  </svg>
                </span>
              </span>
              <span class="app-brand-text demo menu-text fw-semibold ms-2">VEDIKA</span>
            </a>
          </div>

          <div class="menu-inner-shadow"></div>
          
          <!-- Menu items dengan flex-grow-1 agar user section tetap di bawah -->
          <ul class="menu-inner py-1 flex-grow-1">
            <li class="menu-item active">
              <a href="/dashboard" class="menu-link"><i class="menu-icon ri ri-home-smile-line"></i><div>Dashboard</div></a>
            </li>
            <li class="menu-item active">
              <a href="/rawatjalan" class="menu-link"><i class="menu-icon ri ri-stethoscope-line"></i><div>Rawat Jalan</div></a>
            </li>
            <li class="menu-item active">
              <a href="/rawatinap" class="menu-link"><i class="menu-icon ri ri-hospital-line"></i><div>Rawat Inap</div></a>
            </li>
          </ul>

          <!-- User Profile Section di bagian bawah sidebar -->
          <div class="px-3 py-3 border-top mt-auto">
            <div class="dropdown dropup">
              <a class="d-flex align-items-center text-decoration-none dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="avatar avatar-sm me-2">
                  <img src="{{ asset('materio/assets/img/avatars/avatar.jpg') }}" alt="User Avatar" class="rounded-circle" />
                </div>
                <div class="flex-grow-1">
                  <h6 class="mb-0 text-truncate fw-medium">{{ Auth::check() ? (Auth::user()->fullname ?? Auth::user()->username) : 'Guest' }}</h6>
                  <small class="text-muted">{{ Auth::user()->role ?? 'User' }}</small>
                </div>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow rounded-2 p-2" style="min-width: 200px;">
                <li class="mb-2">
                  <div class="d-flex align-items-center px-3">
                    <div class="avatar flex-shrink-0 me-2">
                      <img src="{{ asset('materio/assets/img/avatars/avatar.jpg') }}" alt="User" class="w-px-40 h-auto rounded-circle" />
                    </div>
                    <div class="flex-grow-1">
                      <h6 class="mb-0">{{ Auth::check() ? (Auth::user()->fullname ?? Auth::user()->username) : 'Guest' }}</h6>
                      <small class="text-muted">{{ Auth::user()->role ?? 'User' }}</small>
                    </div>
                  </div>
                </li>
                <li><hr class="dropdown-divider my-2"></li>
                <li class="px-3">
                  <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm w-100 d-flex align-items-center justify-content-center">
                      <i class="ri ri-logout-box-r-line me-2"></i> Logout
                    </button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </aside>

        <div class="layout-page">
          <!-- Navbar dihapus sepenuhnya -->
          
          <div class="content-wrapper">
            @yield('content')
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
                  <div class="mb-2 mb-md-0"></div>
                  <div class="d-none d-lg-inline-block">
                    <a href="/dashboard" class="footer-link me-4">VEDIKA</a> &#169; <script>document.write(new Date().getFullYear());</script>
                  </div>
                </div>
              </div>
            </footer>
            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>

      <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    <script src="{{ asset('materio/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('materio/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('materio/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('materio/assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('materio/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('materio/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('materio/assets/js/main.js') }}"></script>
  </body>
</html>