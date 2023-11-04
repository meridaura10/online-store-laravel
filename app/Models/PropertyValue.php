<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model
{
    use HasFactory;
    use Translatable;

    protected $translatedAttributes = ['value'];

    protected $fillable = ['property_id'];

    public function scopeSearch($query,$value){
        $query->whereTranslationLike('value', "%$value%");
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public function products(){
        return $this->belongsToMany(Product::class, 'product_properties');
    }
}
