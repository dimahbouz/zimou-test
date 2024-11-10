<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('/auth/register', [App\Http\Controllers\Authentication\AuthController::class, 'register']);
    Route::post('/auth/login', [App\Http\Controllers\Authentication\AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [App\Http\Controllers\Authentication\AuthController::class, 'user']);
        Route::post('/auth/logout', [App\Http\Controllers\Authentication\AuthController::class, 'logout']);
    });
});
