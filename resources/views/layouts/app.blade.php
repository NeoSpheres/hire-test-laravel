<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Sweet alert css --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--<link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    /> --}}
    {{-- Bootstrap CSS --}}
    <link href="{{ asset('vendor/bootstrap-5.3.2/css/bootstrap.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('vendor/sweetalert2-11.10.2/sweetalert2.min.css') }}" rel="stylesheet">
    <!--<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet" /> -->


    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .error {
            color: #ff0055;
        }
        .no-sort:after, .no-sort:before {
            content: none !important;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('vendor/datatables-2.0.3/css/dataTables.dataTables.css') }}">
    <!-- Ajax Jquery-->
    <script src="{{ asset('vendor/jquery-3.7.1/jquery.min.js') }}"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>-->
    <script src="{{ asset('vendor/bootstrap-4.5.2/js/bootstrap.min.js') }}"></script>

    <!-- DataTables-->
    <link rel="stylesheet" href="{{ asset('vendor/datatables-2.0.3/css/dataTables.dataTables.min.css') }}">
    <script src="{{ asset('vendor/datatables-2.0.3/js/dataTables.js') }}"></script>

    @yield('head')
    <title>@yield('title', 'Crud app')</title>
</head>
<body>

<!-- Topbar -->
<div class="topbar" style="background-color: {{ $settings->topbar_color ?? 'default-color' }}">
    <div class="container">
         <h1 style="color: {{ $settings->title_color ?? 'default-text-color' }}">Hire test</h1>


    </div>
</div>

<!-- Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar" style="background-color: {{ $settings->sidebar_color ?? 'default-color' }}">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ url('/user') }}">Users</a></li>
                <li><a href="{{ url('/cars') }}">Cars</a></li>
                <li><a href="{{ url('/model') }}">Car models</a></li>
                <li><a href="{{ url('/brands') }}">Car brands</a></li>
                <li><a href="{{ url('/engine-type') }}">Engine Types</a></li>
                <li><a href="{{ url('/tires') }}">Car tires</a></li>
                <li><a href="{{ url('/setting') }}">Settings</a></li>
                <li><a href="{{ url('/datatable-cars') }}">Cars datatable</a></li>
                <li><a href="{{ url('/ajax-brands') }}">Brands (ajax)</a></li>
                <li><a href="{{ url('/ajax-models') }}">Models (ajax)</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 offset-md-3">
            <section class="container mt-5 ml-auto">
                @yield('content')
                <script src="{{ asset('vendor/jquery-3.7.1/jquery.min.js') }}"></script>

                <!-- Bootstrap JavaScript Libraries -->
                <script src="{{ asset('vendor/popper-2.11.8/popper.min.js') }}"></script>

                <script src="{{ asset('vendor/bootstrap-5.3.2/js/bootstrap.min.js') }}"></script>

                <script src="{{ asset('vendor/jquery-validate-1.20.0/jquery.validate.min.js') }}"></script>

                <script src="{{ asset('vendor/datatables-1.13.8/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>

                <script src="{{ asset('vendor/datatables-1.13.8/js/dataTables.bootstrap5.min.js') }}" type="text/javascript"></script>

                {{-- Sweet alert js --}}
            </section>
        </div>
    </div>
</div>

<script type="text/javascript">
    const baseUrl = "{{ url('/') }}"
</script>
<script type="text/javascript" src="{{asset('assets/script.js')}}"></script>
</body>
</html>
