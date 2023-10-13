<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sku extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $fillable = ['quantity', 'price', 'product_id', 'status'];

    public function getSeoData(){
        return [
            'title' => $this->name,
            'description' => null,
        ];
    }
    

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class,'relation')->orderBy('order');
    }
    public function bannerImage()
    {
        return $this->morphOne(Image::class,'relation')->orderBy('order', 'asc');
    }
    public function values()
    {
        return $this->belongsToMany(OptionValue::class, 'sku_variations');
    }
    public function variations(){
        return $this->HasMany(SkuVariation::class);
    }
    public function reviews(){
        return $this->hasMany(SkuReview::class);
    }
    protected function name() : Attribute
    {
        $options = '';
        foreach($this->values as $value) {
            $options = $options . ' ' . $value->value;
        }

        return Attribute::make(
            get: fn () => $this->product->name . $options
        );
    }
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating');
    }
}
