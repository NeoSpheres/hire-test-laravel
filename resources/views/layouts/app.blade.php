<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
    />

    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.2/dist/sweetalert2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

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
                <li><a href="{{ url('/ajax-brands') }}">Marques (ajax)</a></li>
                <li><a href="{{ url('/ajax-models') }}">Modéles (ajax)</a></li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 offset-md-2">
            <section class="container mt-5 ml-auto">
                @yield('content')
            </section>
        </div>
    </div>
</div>

</body>
</html>
