<?php

use App\Http\Controllers\BrandAjaxController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ModeleAjaxController;
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
Route::get('/get-models/{brand}', [ModeleController::class, 'getModelsByBrand'])->name('get-models');



Route::get('ajax-brands',[BrandAjaxController::class, 'index'])->name('ajax-brands.index');
Route::get('ajax-brands/fetch',[BrandAjaxController::class, 'fetchBrand'])->name('ajax-brands.fetch');
Route::post('ajax-brands/store',[BrandAjaxController::class, 'store'])->name('ajax-brands.store');
Route::get('ajax-brands/edit',[BrandAjaxController::class, 'edit'])->name('ajax-brands.edit');
Route::patch('ajax-brands/update',[BrandAjaxController::class, 'update'])->name('ajax-brands.update');
Route::get('ajax-brands/show',[BrandAjaxController::class, 'show'])->name('ajax-brands.show');
Route::delete('ajax-brands/delete',[BrandAjaxController::class, 'destroy'])->name('ajax-brands.destroy');


Route::get('ajax-models',[ModeleAjaxController::class, 'index'])->name('ajax-models.index');
Route::get('ajax-models/fetch',[ModeleAjaxController::class, 'fetchModel'])->name('ajax-models.fetch');
Route::post('ajax-models/store',[ModeleAjaxController::class, 'store'])->name('ajax-models.store');
Route::get('ajax-models/edit',[ModeleAjaxController::class, 'edit'])->name('ajax-models.edit');
Route::patch('ajax-models/update',[ModeleAjaxController::class, 'update'])->name('ajax-models.update');
Route::get('ajax-models/show',[ModeleAjaxController::class, 'show'])->name('ajax-models.show');
Route::delete('ajax-models/delete',[ModeleAjaxController::class, 'destroy'])->name('ajax-models.destroy');






