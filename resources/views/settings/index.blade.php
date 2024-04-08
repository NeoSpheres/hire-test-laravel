{{-- resources/views/settings/index.blade.php --}}

@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/setting.css') }}">
@endsection
@section('content')
    <div class="settings-page">
        <h2>Réglages de Couleur</h2>

        <form action="{{ route('setting.store') }}" method="POST">
            @csrf
            <div class="settings-item">
                <label for="topbar-color">Couleur de fond de la top-bar :</label>
                <input type="color" id="topbar-color" name="topbar_color">
            </div>
            <div class="settings-item">
                <label for="sidebar-color">Couleur de fond du menu latéral :</label>
                <input type="color" id="sidebar-color" name="sidebar_color">
            </div>
            <div class="settings-item">
                <label for="title-color">Couleur du titre :</label>
                <input type="color" id="title-color" name="title_color">
            </div>
            <button type="submit">Appliquer Réglages</button>
        </form>

    </div>
@endsection
