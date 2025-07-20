<?php

declare(strict_types=1);

use App\Http\Controllers\Api\v1\TireMaintenanceController;
use Illuminate\Support\Facades\Route;

Route::prefix('tire-maintenance')
    ->name('api-tire-maintenance')
    ->controller(TireMaintenanceController::class)
    ->group(function () {
        Route::get('/', 'index')
            ->name('index');
        Route::post('/', 'store')
            ->name('store');
        Route::put('/process/{request_id}', 'process')
            ->name('process');
});
