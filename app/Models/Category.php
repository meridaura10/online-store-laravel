<?php

namespace App\Models;

use App\Models\Product;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $fillable = ['parent_id', 'status','slug'];

    public function getSeoData()
    {
        return [
            'title' => $this->name,
            'description' => null,
            'image' => $this->image->url,
            'route' => "admin.categories.seo",
            'url' => '/categories/*',
        ];
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function properties(){
        return $this->belongsToMany(Property::class);
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
        return $this->belongsTo(self::class, 'parent_id')->with('parent','translations');
    }
    public function subcategories()
    {
        return $this->hasMany(self::class, 'parent_id')->with('subcategories','translations','image');
    }
    public function scopeStatus($query, $value)
    {
        return $query->whereStatus($value);
    }
    public function seo()
    {
        return $this->morphOne(Seo::class, 'relation');
    }


    // SCOPE 

    public function scopeParent($query, $value)
    {
        return $query->where('parent_id', $value);
    }
    public function scopeSearch($query, $value)
    {
        return $query->whereTranslationLike('name', "%$value%")->orWhere(function($q) use($value) {
            $q->whereHas('parent',function($q) use($value) {
                $q->whereTranslationLike('name', "%$value%");
            });
        });
    }
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
