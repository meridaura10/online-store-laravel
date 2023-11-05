<?php


namespace App\Services\Filters\Products;

use App\Contracts\Filters\ProductFiltersToModel;
use App\Http\Livewire\Filters\CategoryFilter;
use App\Http\Livewire\Filters\Range;
use App\Http\Livewire\Filters\Util\Filters;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Sku;

class ProductFiltersToBrand implements ProductFiltersToModel
{
    public Brand $brand;
    public function __construct(Brand $brand)
    {
        $this->brand = $brand;
    }
    public function get(): Filters
    {
        return new Filters(
            new Range(
                key: str()->slug('price'),
                title: trans('base.price'),
                field: 'price',
                attributes: $this->price(),
            ),
            new CategoryFilter(
                key: str()->slug('categories'),
                title: trans('base.categories'),
                field: 'product.categories',
                relatedField: 'category_id',
                values: $this->categories(),
            ),
        );
    }
    public function categories()
    {
        $category = Category::query()->where('status', 1)->whereHas('products', function ($q) {
            return $q->where('brand_id', $this->brand->id)->where('status', 1)->whereHas('skus', function ($q) {
                return $q->where('status', 1)->where('quantity', '>', 0);
            });
        })
        ->with('translations','subcategories.translations','parent.translations','parent.parent.translations')
        ->get()
        ->mapToGroups(function($item){
            $parent = $item->parent ? $item->parent->parent ? $item->parent->parent : $item->parent : $item;
            return [$parent->id => [
                'category' => [
                    $item->id => $item->name,
                ],
                'parentName' => $parent->name,
            ]];
        })->toArray();
        return $category;
    }
    public function price()
    {
        $query = Sku::query()->where('status', 1)->where('quantity', '>', 0)->whereHas('product', function ($q) {
            $q->where('status', 1)->where('brand_id', $this->brand->id);
        });

        return ['max' => $query->max('price') ?? 0, 'min' => $query->min('price') ?? 0];
    }
}
