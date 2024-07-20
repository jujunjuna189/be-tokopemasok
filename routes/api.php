<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function ($router) {
    // Auth
    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('login', [App\Http\Controllers\Api\v1\Auth\AuthController::class, 'login']);
        Route::post('register', [App\Http\Controllers\Api\v1\Auth\AuthController::class, 'register']);
    });

    // User
    Route::group(['prefix' => 'user-address'], function ($router) {
        Route::get('/', [App\Http\Controllers\Api\v1\User\UserAddressController::class, 'get'])->middleware('auth:sanctum');
        Route::post('/create', [App\Http\Controllers\Api\v1\User\UserAddressController::class, 'create'])->middleware('auth:sanctum');
        Route::post('/update', [App\Http\Controllers\Api\v1\User\UserAddressController::class, 'update'])->middleware('auth:sanctum');
        Route::post('/delete', [App\Http\Controllers\Api\v1\User\UserAddressController::class, 'delete'])->middleware('auth:sanctum');
    });

    // Product
    Route::group(['prefix' => 'product'], function ($router) {
        Route::get('/', [App\Http\Controllers\Api\v1\Product\ProductController::class, 'get']);
        Route::post('/create', [App\Http\Controllers\Api\v1\Product\ProductController::class, 'create'])->middleware('auth:sanctum');
        Route::post('/update', [App\Http\Controllers\Api\v1\Product\ProductController::class, 'update'])->middleware('auth:sanctum');
        Route::post('/delete', [App\Http\Controllers\Api\v1\Product\ProductController::class, 'delete'])->middleware('auth:sanctum');

        Route::group(['prefix' => 'price'], function ($router) {
            Route::get('/', [App\Http\Controllers\Api\v1\Product\ProductPriceController::class, 'get']);
            Route::post('/create', [App\Http\Controllers\Api\v1\Product\ProductPriceController::class, 'create'])->middleware('auth:sanctum');
            Route::post('/update', [App\Http\Controllers\Api\v1\Product\ProductPriceController::class, 'update'])->middleware('auth:sanctum');
            Route::post('/delete', [App\Http\Controllers\Api\v1\Product\ProductPriceController::class, 'delete'])->middleware('auth:sanctum');
        });
    });

    // Cart
    Route::group(['prefix' => 'cart'], function ($router) {
        Route::get('/', [App\Http\Controllers\Api\v1\Cart\CartController::class, 'get'])->middleware('auth:sanctum');
        Route::post('/create', [App\Http\Controllers\Api\v1\Cart\CartController::class, 'create'])->middleware('auth:sanctum');
        Route::post('/update', [App\Http\Controllers\Api\v1\Cart\CartController::class, 'update'])->middleware('auth:sanctum');
        Route::post('/delete', [App\Http\Controllers\Api\v1\Cart\CartController::class, 'delete'])->middleware('auth:sanctum');
    });

    // Order
    Route::group(['prefix' => 'order'], function ($router) {
        Route::get('/', [App\Http\Controllers\Api\v1\Order\OrderController::class, 'get'])->middleware('auth:sanctum');
        Route::post('/create', [App\Http\Controllers\Api\v1\Order\OrderController::class, 'create'])->middleware('auth:sanctum');
        Route::post('/delete', [App\Http\Controllers\Api\v1\Order\OrderController::class, 'delete'])->middleware('auth:sanctum');
        // Order status
        Route::group(['prefix' => 'status'], function ($router) {
            Route::post('/create', [App\Http\Controllers\Api\v1\Order\OrderStatusController::class, 'create'])->middleware('auth:sanctum');
        });
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
