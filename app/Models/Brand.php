<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

    public function getSeoData()
    {
        return [
            'title' => $this->name,
            'description' => null,
            'image' => $this->image->url,
            'route' => "admin.brands.seo",
            'url' => '/brands/*',
        ];
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'relation');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
    public function scopeSearch($query, $value)
    {
        return $query->where('name', 'like', '%' . $value . '%');
    }
    public function seo()
    {
        return $this->morphOne(Seo::class, 'relation');
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
