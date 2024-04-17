<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Sweet alert css --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!--<link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    /> -->
    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css" rel="stylesheet">
    <--<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet" /> -->


    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .error {
            color: #ff0055;
        }
        .no-sort:after, .no-sort:before {
            content: none !important;
        }
    </style>

    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.css">
    <!-- Ajax Jquery-->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- DataTables-->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css">
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>

    @yield('head')
    <title>@yield('title', 'Crud app')</title>
</head>
<body>

<!-- Topbar -->
<div class="topbar" style="background-color: {{ $settings->topbar_color ?? 'default-color' }}">
    <div class="container">
         <h1 style="color: {{ $settings->title_color ?? 'default-text-color' }}">Test de recrutement</h1>


    </div>
</div>

<!-- Content -->
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 sidebar" style="background-color: {{ $settings->sidebar_color ?? 'default-color' }}">
            <ul>
                <li><a href="{{ url('/') }}">Accueil</a></li>
                <li><a href="{{ url('/user') }}">Utilisateurs</a></li>
                <li><a href="{{ url('/cars') }}">Voitures</a></li>
                <li><a href="{{ url('/model') }}">Modéles</a></li>
                <li><a href="{{ url('/brands') }}">Marques</a></li>
                <li><a href="{{ url('/setting') }}">Réglages</a></li>
                <li><a href="{{ url('/datatable-cars') }}">datatable-cars</a></li>
                <li><a href="{{ url('/ajax-brands') }}">Marques (ajax)</a></li>
                <li><a href="{{ url('/ajax-models') }}">Modéles (ajax)</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 offset-md-2">
            <section class="container mt-5 ml-auto">
                @yield('content')
                <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

                <!-- Bootstrap JavaScript Libraries -->
                <script
                    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
                    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
                    crossorigin="anonymous"
                ></script>

                <script
                    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
                    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
                    crossorigin="anonymous"
                ></script>

                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

                <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js" type="text/javascript"></script>

                <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js" type="text/javascript"></script>

                {{-- Sweet alert js --}}
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.all.min.js"></script>
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
