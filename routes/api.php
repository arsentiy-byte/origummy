<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('app.url_base_path'))->group(function () {
    Route::prefix('v1')->group(function () {
    });
});
