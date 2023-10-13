<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
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
    public function products()
    {
        return $this->hasOne(Product::class);
    }
}
