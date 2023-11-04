<?php


namespace App\Services\Filters\Products;

use App\Http\Livewire\Filters\CheckBox;
use App\Http\Livewire\Filters\Range;
use App\Http\Livewire\Filters\Util\Filters;
use App\Models\Brand;
use App\Models\Category;
use App\Models\OptionValue;
use App\Models\PropertyValue;
use App\Models\Sku;

class ProductFiltersToCategory
{
    public Category $category;
    public $categoriesIds;
    public function __construct(Category $category,$categoriesIds)
    {
        $this->category = $category;
        $this->categoriesIds = $categoriesIds;
    }
    public function get(): Filters
    {
        $properties = $this->properties();
        $options = $this->options();
        return new Filters(
            new Range(
                key: str()->slug('price'),
                title: 'price',
                field: 'price',
                attributes: $this->price(),
            ),
            new CheckBox(
                key: str()->slug('brands'),
                title: 'brands',
                field: 'product.brand',
                relatedField: 'brand_id',
                values: $this->brands(),
            ),

            ...array_map(function ($key, $items) {
                return new CheckBox(
                    key: str()->slug($key),
                    title: $key,
                    field: 'product.propertiesValues',
                    relatedField: 'property_value_id',
                    values: $items,
                );
            }, array_keys($properties), $properties),

            ...array_map(function ($key, $items) {
                return new CheckBox(
                    key: str()->slug($key),
                    title: $key,
                    field: 'values',
                    relatedField: 'option_value_id',
                    values: $items,
                );
            }, array_keys($options), $options),
        );
    }
    public function brands()
    {
        return Brand::query()->whereHas('products.categories', function ($q) {
            $q->whereIn('category_id', $this->categoriesIds);
        })->whereHas('products.sku', function ($q) {
            $q->where('quantity', '>', 0);
        })->get()
            ->pluck('name', 'id')
            ->toArray();
    }
    public function options()
    {
        return OptionValue::whereHas('skus', function ($q) {
            $q->where('quantity', '>', 0)
                ->whereHas('product', function ($q) {
                    $q->whereHas('categories', function ($q) {
                        $q->whereIn('categories.id', $this->categoriesIds);
                    });
                });
        })
        ->with('translations', 'option.translations')
        ->get()
        ->mapToGroups(function ($item) {
            return [$item->option->title => $item];
        })
        ->map(function ($i) {
            return $i->pluck('value', 'id');
        })->toArray();
    }
    
    function properties()
    {
        $properties = PropertyValue::query()
            ->with('products', 'translations', 'property.translations')
            ->whereHas('products', function ($q) {
                $q->where('status', 1)
                    ->whereHas('skus', function ($q) {
                        $q->where('status', 1)
                            ->where('quantity', '>', 0);
                    })
                    ->whereHas('categories', function ($q) {
                        $q->whereIn('categories.id', $this->categoriesIds);
                    });
            })
            ->withCount([
                'products' => function ($q) {
                    $q->whereHas('categories', function ($q) {
                        $q->whereIn('category_id', $this->categoriesIds);
                    });
                }
            ])->get()
            ->mapToGroups(function ($item) {
                if ($item->property_id !== 4) {
                    return [$item->property->title => $item];
                }
            })
            ->map(function ($items) {
                return $items->pluck('value', 'id');
            })->toArray();
        return $properties;
    }
    public function price()
    {
        $query = Sku::query()->where('status', 1)->where('quantity', '>', 0)->whereHas('product', function ($q) {
            $q->where('status',1)->whereHas('categories', function ($q) {
                $q->whereIn('category_id', $this->categoriesIds);
            });
        });
        
        return ['max' => $query->max('price'), 'min' => $query->min('price')];
    }
}
