<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PropertyController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\SkuController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'admin.index')->name('index');
Route::view('/users', 'admin.user.index')->name('users.index');

Route::prefix('products')->name('products.')->controller(ProductController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{product}/show','show')->name('show');
    Route::get('/{product}/edit', 'edit')->name('edit');

    Route::prefix('{product}/skus')->name('skus.')->controller(SkuController::class)->group(function () {
        Route::get('/','index')->name('index');
        Route::get('/seo','seo')->name('seo');
        Route::get('/form','form')->name('form');
    });
});

Route::prefix('seo')->name('seos.')->controller(SeoController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{seo}/edit', 'edit')->name('edit');
});

Route::prefix('categories')->name('categories.')->controller(CategoryController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{category}/edit', 'edit')->name('edit');
    Route::get('{category}/seo/','seo')->name('seo');
});

Route::prefix('orders')->name('orders.')->controller(OrderController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{order}', 'show')->name('show');
});

Route::prefix('brands')->name('brands.')->controller(BrandController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{brand}/edit', 'edit')->name('edit');
    Route::get('{brarnd}/seo/','seo')->name('seo');
});

Route::prefix('options')->name('options.')->controller(OptionController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{option}/edit', 'edit')->name('edit');
});

Route::prefix('properties')->name('properties.')->controller(PropertyController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::get('/{property}/edit', 'edit')->name('edit');
});
