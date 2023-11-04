<?php

namespace App\Http\Livewire\Category;

use App\Http\Livewire\Components\ProductList;
use App\Http\Livewire\Filters\CheckBox;
use App\Http\Livewire\Filters\Input;
use App\Http\Livewire\Filters\Range;
use App\Http\Livewire\Filters\Util\Filter;
use App\Http\Livewire\Filters\Util\Filters;
use App\Models\Category;
use App\Models\Product;
use App\Models\Sku;
use App\Services\Filters\Products\ProductFiltersToCategory;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Show extends ProductList
{
    public Category $category;
    public $categoriesIds;
    public function mount(Category $category)
    {
        $this->category = $category->load('subcategories.image','subcategories.translations','subcategories');
        $this->categoriesIds = $category->subcategories->pluck('id')->push($category->id)->toArray();

        $this->init();
    }

    public function makeQuery(): Builder
    {
        return Sku::query()->where('status', 1)->where('quantity', '>', 0)->whereHas('product', function ($q) {
            $q->where('status',1)->whereHas('categories', function ($q) {
                $q->whereIn('category_id', $this->categoriesIds);
            });
        });
    }
    public function contentHeader(): View
    {
        return view('category.content-header',[
            'category' => $this->category,
        ]);
    }
    public function filters(): Filters
    {
        $filter = new ProductFiltersToCategory($this->category,$this->categoriesIds);
        return $filter->get();
    }
    public function title(): string
    {
        return $this->category->name;
    }
}
