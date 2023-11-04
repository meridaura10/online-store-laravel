<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [HomeController::class,'index'])->name('home');


Route::prefix('cabinet')->middleware('auth')->name('cabinet.')->controller(CabinetController::class)->group(function () {
    Route::get('/cabinet', 'index')->name('index');
    Route::get('/orders','orders')->name('orders');
    Route::get('/user','user')->name('user');
});

Route::prefix('brands')->name('brands.')->controller(BrandController::class)->group(function () {
    Route::get('/{brand:slug}', 'show')->name('show');
});


Route::prefix('order')->name('orders.')->controller(OrderController::class)->group(function () {
    Route::get('/checkout', 'checkout')->name('checkout')->middleware(['basket.items']);
    Route::post('/response/{payment}', 'response')->name('payment.response');
    Route::get('/response/{payment}', 'response')->name('payment.response');
    Route::post('/callback/{payment}', 'callback')->name('payment.callback');
});

Route::get('/basket', [BasketController::class,'index'])->name('basket.index');
Route::get('/categories/{category:slug}', [CategoryController::class,'show'])->name('categories.show');
Route::get('/product/{sku:slug}',[ProductController::class,'show'])->name('product.show');


