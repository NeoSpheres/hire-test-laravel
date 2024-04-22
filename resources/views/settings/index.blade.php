{{-- resources/views/settings/index.blade.php --}}

@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="{{ asset('css/setting.css') }}">
@endsection
@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="settings-page">
        <h2>Réglages de Couleur</h2>

        <form action="{{ route('setting.store') }}" method="POST" id="settings-form">
            @csrf
            <div>
                <label for="topbar_color">Couleur de fond de la top-bar :</label>
                <input type="color" id="topbar_color" name="topbar_color" value="{{ $setting->topbar_color ?? null }}" data-default-value="{{ $setting->topbar_color ?? null }}" onchange="updateColorValue(this, 'topbar_color_value')">
                <input type="text" id="topbar_color_value"  oninput="setColor('topbar_color', this.value)">

            </div>
            <div>
                <label for="sidebar_color">Couleur de fond du menu latéral :</label>
                <input type="color" id="sidebar_color" name="sidebar_color" value="{{ $setting->sidebar_color ?? null }}" data-default-value="{{ $setting->sidebar_color ?? null }}" onchange="updateColorValue(this, 'sidebar_color_value')">
                <input type="text" id="sidebar_color_value"  oninput="setColor('sidebar_color', this.value)">
            </div>
            <div>
                <label for="title_color">Couleur du titre :</label>
                <input type="color" id="title_color" name="title_color" value="{{ $setting->title_color ?? null }}" data-default-value="{{ $setting->title_color ?? null }}" onchange="updateColorValue(this, 'title_color_value')">
                <input type="text" id="title_color_value" oninput="setColor('title_color', this.value)">
            </div>
            <button type="submit">Appliquer Réglages</button>
        </form>
    </div>
        @endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('settings-form').onsubmit = function() {
                this.querySelectorAll('input[type=color]').forEach(input => {
                    // If the value is black but the data-default-value attribute is empty,
                    // then the user did not set a color and we should not submit this value.
                    if (input.value === '#000000' && !input.getAttribute('data-default-value')) {
                        input.value = ''; // Clear the value to avoid submitting black by default
                    }
                });
            };
        });

        function updateColorValue(colorInput, textInputId) {
            var textInput = document.getElementById(textInputId);
            if (textInput) {
                textInput.value = colorInput.value;
            }
        }

        function setColor(inputId, value) {
            var input = document.getElementById(inputId);
            if (input) {
                input.value = value;
            }
        }

    </script>

