<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class,'index'])->name('home');


Route::prefix('cabinet')->name('cabinet.')->controller(CabinetController::class)->group(function () {
    Route::get('/cabinet', 'index')->name('index');
    Route::get('/orders','orders')->name('orders');
    Route::get('/user','user')->name('user');
});


Route::prefix('order')->name('orders.')->controller(OrderController::class)->group(function () {
    Route::get('/checkout', 'checkout')->name('checkout')->middleware(['basket.items']);
    Route::post('/response/{payment}', 'response')->name('payment.response');
    Route::post('/callback/{payment}', 'callback')->name('payment.callback');
    Route::get('/{order}','show')->name('show');
});

Route::get('/basket', [BasketController::class,'index'])->name('basket.index');
Route::get('/categories/{category}', [CategoryController::class,'show'])->name('categories.show');
Route::get('/product/{sku}',[ProductController::class,'show'])->name('product.show');


