<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('app.url_base_path'))->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'Api\AuthController@login')->name('auth-login');

        Route::middleware('auth:user')->group(function () {
            Route::get('logout', 'Api\AuthController@logout')->name('auth-logout');
            Route::get('user', 'Api\AuthController@user')->name('auth-user');
        });
    });

    Route::prefix('v1')->group(function () {
        Route::post('categories', 'Api\V1\CategoryController@createCategory')->name('categories.create');
        Route::put('categories/{category}', 'Api\V1\CategoryController@updateCategory')->name('categories.update');
    });
});
