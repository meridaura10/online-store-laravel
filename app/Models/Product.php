<?php

namespace App\Models;

use App\Http\Livewire\Filters\Util\Filters;
use App\Models\Category;
use App\Services\Filters\ProductsFilters;
use Illuminate\Database\Query\Builder;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name'];

    protected $fillable = ['brand_id', 'status'];


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function skus()
    {
        return $this->hasMany(Sku::class);
    }
    public function sku()
    {
        return $this->hasOne(Sku::class);
    }
    public function properties()
    {
        return $this->hasMany(ProductProperty::class);
    }
    public function propertiesValues()
    {
        return $this->belongsToMany(PropertyValue::class, 'product_properties');
    }
    public function scopeSearch($query, $value)
    {
        return $query->whereTranslationLike('name', "%$value%");
    }
    public function scopeFilterByCategory($query, $categoryId)
    {
        return $query->whereHas('categories', function ($q) use ($categoryId) {
            $q->where('categories.id', $categoryId);
        });
    }
    
    public function scopeSortByCategory($query, $key, $direction)
    {
        return $query->join('category_product', 'products.id', '=', 'category_product.product_id')
            ->join('categories', 'category_product.category_id', '=', 'categories.id')
            ->join('category_translations', 'categories.id', '=', 'category_translations.category_id')
            ->where('category_translations.locale', app()->getLocale())
            ->orderBy('category_translations.name', $direction);
    }

    public function scopeSortByBrand($query, $value, $direction)
    {
        return $query->select('products.*')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->orderBy('brands.name', $direction);
    }
    public function scopeStatus($query, $value)
    {
        return $query->whereStatus($value);
    }
    public function scopeBrand($query, $value)
    {
        return $query->where('brand_id', $value);
    }
}
