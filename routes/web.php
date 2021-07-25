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

Route::prefix(config('app.url_base_path'))->group(function () {
    Route::prefix('web')->group(function () {
        Route::get('login', function () {
            return view('auth.login');
        })->name('web-login');

        Route::prefix('auth')->group(function () {
            Route::post('login', 'Visualization\AuthController@login')->name('web-auth-login');

            Route::middleware('web-auth')->group(function () {
                Route::get('logout', 'Visualization\AuthController@logout')->name('web-auth-logout');
                Route::get('user', 'Visualization\AuthController@user')->name('web-auth-user');
            });
        });

        Route::prefix('v1')->group(function () {
            /**
             * Categories
             */
            Route::prefix('categories')->group(function () {
                Route::get('main_page', 'Visualization\V1\CategoryController@getCategoriesAtMainPage')->name('web-categories-main_page');
                Route::get('menu', 'Visualization\V1\CategoryController@getCategoriesAtMenu')->name('web-categories-menu');
            });

            /**
             * Products
             */
            Route::prefix('products')->group(function () {
                Route::get('by_category/{category_slug}', 'Visualization\V1\ProductController@getProductsByCategorySlug')->name('web-products-by_category');
                Route::get('with/promotions', 'Visualization\V1\ProductController@getProductsWithPromotions')->name('web-products-with_promotions');
            });

            /**
             * Orders
             */
            Route::prefix('orders')->group(function () {
                Route::get('by_client/{phone}', 'Visualization\V1\OrderController@getClientOrders')->name('web-orders-by_client');
            });

            Route::get('statistics', 'Visualization\V1\IndexController@getStatistics')->name('web-statistics');
        });
    });
});

Route::get('/admin/{vue?}', function () {
    return view('admin');
})->where('vue', '[\/\w\.-]*')->middleware('web-auth')->name('admin');

Route::get('/{vue?}', function () {
    return view('user');
})->where('vue', '[\/\w\.-]*')->name('index');
