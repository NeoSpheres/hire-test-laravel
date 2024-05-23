<?php

use App\Http\Controllers\BrandAjaxController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\CarModelAjaxController;
use App\Http\Controllers\EngineTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\DatatableCarController;
use \App\Http\Controllers\TireController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('user',UserController::class);
Route::resource('setting',SettingsController::class);
Route::resource('cars',CarController::class);
Route::resource('brands',BrandController::class);
Route::resource('model',CarModelController::class);
Route::resource('engine-type',EngineTypeController::class);
Route::resource('tires', TireController::class);

//Route Datatable Cars
Route::resource('datatable-cars',DatatableCarController::class);
// Ajout d'une route API pour récupérer les modèles basés sur la marque
Route::get('/api/models/{brandId}', [DatatableCarController::class, 'getModelsByBrand']);
Route::get('/generate-matricule', [DatatableCarController::class, 'generateMatricule']);
Route::get('/api/cars/{id}', [DatatableCarController::class, 'show']);  // Pour récupérer les détails de la voiture


Route::get('/get-models/{brand}', [CarModelController::class, 'getModelsByBrand'])->name('get-models');






Route::get('ajax-brands',[BrandAjaxController::class, 'index'])->name('ajax-brands.index');
Route::get('ajax-brands/fetch',[BrandAjaxController::class, 'fetchBrand'])->name('ajax-brands.fetch');
Route::post('ajax-brands/store',[BrandAjaxController::class, 'store'])->name('ajax-brands.store');
Route::get('ajax-brands/edit',[BrandAjaxController::class, 'edit'])->name('ajax-brands.edit');
Route::patch('ajax-brands/update',[BrandAjaxController::class, 'update'])->name('ajax-brands.update');
Route::get('ajax-brands/show',[BrandAjaxController::class, 'show'])->name('ajax-brands.show');
Route::delete('ajax-brands/delete',[BrandAjaxController::class, 'destroy'])->name('ajax-brands.destroy');


Route::get('ajax-models',[CarModelAjaxController::class, 'index'])->name('ajax-models.index');
Route::get('ajax-models/fetch',[CarModelAjaxController::class, 'fetchModel'])->name('ajax-models.fetch');
Route::post('ajax-models/store',[CarModelAjaxController::class, 'store'])->name('ajax-models.store');
Route::get('ajax-models/edit',[CarModelAjaxController::class, 'edit'])->name('ajax-models.edit');
Route::patch('ajax-models/update',[CarModelAjaxController::class, 'update'])->name('ajax-models.update');
Route::get('ajax-models/show',[CarModelAjaxController::class, 'show'])->name('ajax-models.show');
Route::delete('ajax-models/delete',[CarModelAjaxController::class, 'destroy'])->name('ajax-models.destroy');





