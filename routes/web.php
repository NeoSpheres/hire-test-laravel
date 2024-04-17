<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ModeleController;
use App\Http\Controllers\DatatableCarController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('user',UserController::class);
Route::resource('setting',SettingsController::class);
Route::resource('cars',CarController::class);
Route::resource('brands',BrandController::class);
Route::resource('model',ModeleController::class);

//Route Datatable Cars
Route::resource('datatable-cars',DatatableCarController::class);
// Ajout d'une route API pour récupérer les modèles basés sur la marque
Route::get('/api/models/{brandId}', [DatatableCarController::class, 'getModelsByBrand']);
Route::get('/generate-matricule', [DatatableCarController::class, 'generateMatricule']);
Route::get('/api/cars/{id}', [DatatableCarController::class, 'show']);  // Pour récupérer les détails de la voiture










