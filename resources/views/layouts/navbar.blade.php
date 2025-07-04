<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/dashboard" class="nav-link">Home</a>
    </li>
  </ul>


  <ul class="navbar-nav ml-auto">
    @auth
    <li class="nav-item dropdown">
      <a class="nav-link d-flex align-items-center" data-toggle="dropdown" href="#" role="button">
        <img src="{{ Auth::user()->profile_picture ?? asset('assets/img/backgrounds/logos.png') }}" 
             class="img-circle elevation-2" alt="User Image" 
             style="width: 30px; height: 30px; object-fit: cover;">
        <span class="ml-2">{{ Auth::user()->fullname ?? Auth::user()->username }}</span>
        <i class="fas fa-caret-down ml-1"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right">
        
        {{-- <a href="{{ route('profile.edit') }}" class="dropdown-item">
          <i class="fas fa-user me-2"></i> Profil
        </a>
        <div class="dropdown-divider"></div> --}}
        <a href="#" class="dropdown-item text-danger"
           onclick="event.preventDefault(); document.getElementById('navbar-logout-form').submit();">
          <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="navbar-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>
    @endauth

    
    @guest
<li class="nav-item">
  <a href="{{ route('login') }}" class="nav-link text-warning" style="font-weight: 500;">
    <i class="fas fa-exclamation-circle mr-1"></i>
    Sesi Anda telah berakhir. Silakan login kembali.
  </a>
</li>
@endguest

  </ul>
</nav>
