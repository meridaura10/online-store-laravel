<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['parent_id', 'status'];

    public function products()
    {
        return $this->belongsToManyf(Product::class);
    }
    public function attributes(){
        return $this->belongsToMany(Attribute::class);
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'relation');
    }
    public function brands()
    {
        return $this->belongsToMany(Brand::class);
    }
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
    public function scopeStatus($query, $value)
    {
        return $query->whereStatus($value);
    }
    public function scopeParent($query, $value)
    {
        return $query->where('parent_id', $value);
    }
    // public function scopeSearch($query, $value)
    // {
    //     return $query->where('name', 'like', '%' . $value . '%');
    // }
    public function scopeOrderByBrands($query, $key, $direction)
    {
        return $query->with([$key => function ($query) use ($direction) {
            $query->orderBy('name', $direction);
        }]);
    }

    public function scopeWithBrands($query, $brandIds)
    {
        $isAll = array_search('all', $brandIds);
        if ($isAll === false) {
            return $query->whereHas('brands', function ($query) use ($brandIds) {
                $query->whereIn('brands.id', $brandIds);
            });
        }
    }
}
