<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('head')
    <title>@yield('title', 'Page par défaut')</title>
</head>
<body>

<!-- Topbar -->
<div class="topbar" style="background-color: {{ $settings->topbar_color ?? 'default-color' }}">
    <div class="container">
         <h1 style="color: {{ $settings->title_color ?? 'default-text-color' }}">Test de recrutement</h1>


    </div>
</div>
<!-- Sidebar -->
<div class="sidebar" style="background-color: {{ $settings->sidebar_color ?? 'default-color' }}">
    <ul>
        <li><a href="{{ url('/') }}">Accueil</a></li>
        <li><a href="{{ url('/user') }}">Utilisateurs</a></li>
        <li><a href="{{ url('/setting') }}">Réglages</a></li>
    </ul>
</div>

<div class="main-content">
    @yield('content')
</div>

</body>
</html>
