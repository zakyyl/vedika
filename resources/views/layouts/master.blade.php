<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Vedika')</title>

    <link rel="icon" href="{{ asset('assets/img/backgrounds/logos.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

    @stack('styles')
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
    <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



    @yield('scripts')
    @stack('scripts')

    <style>
        .rotate-icon {
            transition: transform 0.3s ease;
        }

        .accordion .collapse.show~.card-header .rotate-icon,
        .card-header .btn[aria-expanded="true"] .rotate-icon {
            transform: rotate(180deg);
        }

        .table td {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .timeline {
            position: relative;
            padding-left: 25px;
            border-left: 2px solid #ccc;
        }

        .timeline-item {
            position: relative;
        }

        .timeline-point {
            position: absolute;
            left: -13px;
            top: 5px;
            width: 25px;
            height: 25px;
            line-height: 25px;
            border-radius: 50%;
            background-color: #17a2b8;
            font-size: 14px;
        }

        .timeline-content {
            margin-left: 20px;
        }

        #dashboardChart {
            min-height: 280px;
            /* tinggi chart */
        }
    </style>

</body>

</html>