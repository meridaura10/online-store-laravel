<?php

use App\Http\Livewire\Util\Alert;
use App\Services\AlertService;
use App\Services\BasketService;
use App\Services\Filters\ProductsFilters;
use App\Services\SeoService;

if (! function_exists('basket')) {
    function basket()
    {
        return resolve(BasketService::class);
    }
}

if (! function_exists('alert')) {
    function alert()
    {
        return resolve(AlertService::class);
    
    }
}

if (! function_exists('seo')) {
    function seo()
    {
        return resolve(SeoService::class);
    
    }
}


