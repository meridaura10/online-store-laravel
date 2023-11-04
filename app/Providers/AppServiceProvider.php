<?php

namespace App\Providers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;
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
        $categories = Cache::remember('categories', 3600, function () {
            return Category::query()
                ->with('subcategories', 'translations', 'image', 'brands.image')
                ->whereNull('parent_id')
                ->get();
        });
        
        View::composer(['home.category-list', 'livewire.header.catalog','livewire.admin.product.form'], function ($view) use ($categories) {
            $view->with('categories', $categories);
        });
    }
}
