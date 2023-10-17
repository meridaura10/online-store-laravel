<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $categories = Category::query()->with('subcategories.translations','subcategories', 'translations', 'image', 'subcategories.image')->whereNull('parent_id')->get();
        
        View::composer(['home.categoryList', 'livewire.header.catalog'], function ($view) use ($categories) {
            $view->with('categories', $categories);
        });
    }
}
