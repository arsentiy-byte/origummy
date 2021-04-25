<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('app.url_base_path'))->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', 'Api\Auth\LoginController')->name('api-auth-login');

        Route::middleware('auth:api-student,api-employee')->group(function () {
            Route::get('logout', 'Api\Auth\LogoutController')->name('api-auth-logout');
            Route::get('user', 'Api\Auth\UserController')->name('api-auth-user');
        });
    });

    Route::prefix('v1')->group(function () {
    });
});
