<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/auth/register', [App\Http\Controllers\Authentication\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Authentication\AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [App\Http\Controllers\Authentication\AuthController::class, 'user']);
        Route::post('/auth/logout', [App\Http\Controllers\Authentication\AuthController::class, 'logout']);
        Route::get('/packages', [\App\Http\Controllers\Packages\PackageController::class, 'index']);
        Route::get('/stores', [\App\Http\Controllers\Stores\StoreController::class, 'index']);
        Route::get('/package_statuses', [\App\Http\Controllers\Packages\PackageStatusController::class, 'index']);
        Route::get('/delivery_types', [\App\Http\Controllers\Packages\DeliveryTypeController::class, 'index']);
        Route::get('/wilayas', [\App\Http\Controllers\Wilayas\WilayaController::class, 'index']);
        Route::get('/communes', [\App\Http\Controllers\Communes\CommuneController::class, 'index']);
        Route::post('/packages', [\App\Http\Controllers\Packages\PackageController::class, 'store']);
    });
});
