<?php

use Illuminate\Support\Facades\Route;

Route::prefix(config('app.url_base_path'))->group(function () {
    Route::prefix('api')->group(function () {
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

            /**
             * Products' routes
             */
            Route::get('products', 'Api\V1\ProductController@getProducts')->name('products.index');
            Route::get('products/search', 'Api\V1\ProductController@productSearch')->name('products.search');
            Route::get('products/{product}', 'Api\V1\ProductController@getProductById')->name('product.by_id');
            Route::post('products', 'Api\V1\ProductController@createProduct')->name('products.create');
            Route::put('products/{product}', 'Api\V1\ProductController@updateProduct')->name('product.update');
            Route::delete('products/{product}', 'Api\V1\ProductController@deleteProduct')->name('product.delete');
            Route::get('products/by-category/{category}', 'Api\V1\ProductController@getProductsByCategory')->name('product.by_category');

            /**
             * Promotions' routes
             */
            Route::get('promotions', 'Api\V1\PromotionController@getPromotions')->name('promotions.index');
            Route::get('promotions/types', 'Api\V1\PromotionController@getPromotionTypes')->name('promotions.by_category');
            Route::get('promotions/search', 'Api\V1\PromotionController@promotionSearch')->name('promotions.search');
            Route::get('promotions/{promotion}', 'Api\V1\PromotionController@getPromotionById')->name('promotion.by_id');
            Route::post('promotions', 'Api\V1\PromotionController@createPromotion')->name('promotions.create');
            Route::put('promotions/{promotion}', 'Api\V1\PromotionController@updatePromotion')->name('promotion.update');
            Route::delete('promotions/{promotion}', 'Api\V1\PromotionController@deletePromotion')->name('promotion.delete');

            /**
             * Orders' routes
             */
            Route::post('order', 'Api\V1\OrderController@order')->name('order');
            Route::get('orders', 'Api\V1\OrderController@getOrders')->name('orders.index');
            Route::get('orders/{order}', 'Api\V1\OrderController@getOrderById')->name('order.by_id');
            Route::get('orders/by_client/{client}', 'Api\V1\OrderController@getOrderByClient')->name('order.by_client');

            /**
             * Clients' routes
             */
            Route::get('clients', 'Api\V1\ClientController@getClients')->name('clients.index');
            Route::get('clients/{client}', 'Api\V1\ClientController@getClientById')->name('client.by_id');

            /**
             * Banners
             */
            Route::get('banners', 'Api\V1\BannersController@getBanners')->name('banners.index');
            Route::post('banners', 'Api\V1\BannersController@manageBanners')->name('banners.manage');
        });
    });
});
