<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AdminLTE Laravel')</title>

<link rel="icon" href="{{ asset('assets/img/backgrounds/logos.png') }}" type="image/png">


  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  @include('layouts.navbar')
  @include('layouts.sidebar')

  <div class="content-wrapper">
    <section class="content px-3 pt-3">
      @yield('content')
    </section>
  </div>

  @include('layouts.footer')

</div>

<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

@yield('scripts') 

<style>
    .rotate-icon {
        transition: transform 0.3s ease;
    }

    .accordion .collapse.show ~ .card-header .rotate-icon,
    .card-header .btn[aria-expanded="true"] .rotate-icon {
        transform: rotate(180deg);
    }

    .table td {
    padding-top: 0.25rem;
    padding-bottom: 0.25rem;
}

</style>

</body>
</html>
