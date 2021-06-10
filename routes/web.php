<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::prefix('web')->group(function () {
    Route::prefix('v1')->group(function () {
        /**
         * Categories
         */
        Route::prefix('categories')->group(function () {
            Route::get('main_page', 'Visualization\V1\CategoryController@getCategoriesAtMainPage')->name('web.categories.main_page');
            Route::get('menu', 'Visualization\V1\CategoryController@getCategoriesAtMenu')->name('web.categories.menu');
        });

        /**
         * Products
         */
        Route::prefix('products')->group(function () {
            Route::get('by_category/{category_slug}', 'Visualization\V1\ProductController@getProductsByCategorySlug')->name('web.products.by_category');
        });

        /**
         * Orders
         */
        Route::prefix('orders')->group(function () {
            Route::get('by_client/{phone}', 'Visualization\V1\OrderController@getClientOrders')->name('web.orders.by_client');
        });
    });
});

Route::get('/', function () {
    return response('Hello');
})->name('index');
