<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
