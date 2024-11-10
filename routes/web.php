<?php

use Illuminate\Support\Facades\Route;

Route::get('/{catchAll}', function () {
    return view('welcome');
})->where('catchAll', '.*');
