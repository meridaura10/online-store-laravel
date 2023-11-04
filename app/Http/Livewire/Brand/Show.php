<?php

namespace App\Http\Livewire\Brand;

use App\Http\Livewire\Components\ProductList;
use App\Http\Livewire\Filters\Util\Filters;
use App\Models\Brand;
use App\Models\Sku;
use App\Services\Filters\Products\ProductFiltersToBrand;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends ProductList
{
    public Brand $brand;
    public function mount(Brand $brand)
    {
        $this->brand = $brand;
        $this->init();
    }
    public function makeQuery(): Builder
    {
        return Sku::query()->whereHas('product', function ($q) {
            return $q->where('brand_id', $this->brand->id);
        });
    }
    public function contentHeader(): View
    {
        return view('brand.content-header',[
            'brand' => $this->brand,
        ]);
    }
    public function filters(): Filters
    {
        $service = new ProductFiltersToBrand($this->brand);
        return $service->get();
    }
}
