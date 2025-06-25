<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'AdminLTE Laravel')</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- AdminLTE -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  @include('layouts.navbar')
  @include('layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <section class="content px-3 pt-3">
      @yield('content')
    </section>
  </div>

  @include('layouts.footer')

</div>

<!-- Scripts -->
<script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>

@yield('scripts') <!-- ← ini WAJIB -->

<!-- Optional Styles -->
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
