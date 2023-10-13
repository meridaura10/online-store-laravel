<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    use Translatable;
    public $translatedAttributes = ['title'];
    protected $fillable = ['property_id'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'attribute_category', 'attribute_id', 'category_id');
    }
    public function scopeSearch($query, $value)
    {
        return $query->whereTranslationLike('title', "%$value%");
    }
}
