<?php

use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('user',UserController::class);
Route::resource('setting',SettingsController::class);
Route::resource('cars',CarController::class);


