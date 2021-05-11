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
        /**
         * Categories' routes
         */
        Route::get('categories', 'Api\V1\CategoryController@getCategories')->name('categories.index');
        Route::get('categories/search', 'Api\V1\CategoryController@categorySearch')->name('categories.search');
        Route::get('categories/{category}', 'Api\V1\CategoryController@getCategoryById')->name('category.by_id');
        Route::post('categories', 'Api\V1\CategoryController@createCategory')->name('categories.create');
        Route::put('categories/{category}', 'Api\V1\CategoryController@updateCategory')->name('category.update');
        Route::delete('categories/{category}', 'Api\V1\CategoryController@deleteCategory')->name('category.delete');
    });
});
