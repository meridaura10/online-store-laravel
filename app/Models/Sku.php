<?php

namespace App\Models;

use App\Http\Livewire\Sorts\Sorts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sku extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $fillable = ['quantity', 'price', 'product_id', 'status','slug'];

    public function getSeoData()
    {
        return [
            'title' => $this->name,
            'description' => null,
            'image' => $this->bannerImage->url,
            'route' => 'admin.products.skus.seo',
            'url' => '/products/*',
        ];
    }
    public function scopeFiltered($query, $filters, $values)
    {
        foreach ($filters as $filter) {
            $query = $filter->apply($query, array_key_exists($filter->key, $values) ? $values[$filter->key] : null);
        }
        return $query;
    }
    public function scopeSorting($query,Sorts $sorts,$sort)
    {
        if ($sort) {
            return $sorts->sort($sort)?->apply($query);
        }  
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function seo()
    {
        return $this->morphOne(Seo::class, 'relation');
    }
    public function images()
    {
        return $this->morphMany(Image::class, 'relation')->orderBy('order');
    }
    public function bannerImage()
    {
        return $this->morphOne(Image::class, 'relation')->orderBy('order', 'asc');
    }
    public function values()
    {
        return $this->belongsToMany(OptionValue::class, 'sku_variations');
    }
    public function variations()
    {
        return $this->HasMany(SkuVariation::class);
    }
    public function reviews()
    {
        return $this->hasMany(SkuReview::class);
    }
    public function scopeSortByRating($query,$direction){
        return $query->join('sku_reviews', 'sku_reviews.sku_id', '=', 'skus.id')
        ->selectRaw('skus.*, AVG(sku_reviews.rating) as avg_rating')
        ->groupBy('skus.id')
        ->orderBy('avg_rating', $direction);
    }
    protected function name(): Attribute
    {
        $options = '';
        foreach ($this->values as $value) {
            $options = $options . ' ' . $value->value;
        }

        return Attribute::make(
            get: fn () => $this->product->name . $options
        );
    }
    public function getAverageRatingAttribute()
    {
        return $this->reviews->avg('rating');
    }
}
