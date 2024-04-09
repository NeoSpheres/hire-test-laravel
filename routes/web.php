<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ModeleController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('user',UserController::class);
Route::resource('setting',SettingsController::class);
Route::resource('cars',CarController::class);
Route::resource('brands',BrandController::class);
Route::resource('model',ModeleController::class);


