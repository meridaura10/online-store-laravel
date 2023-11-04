<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    use Translatable;

    protected $translatedAttributes = ['title'];

    protected $fillable = ['parent_id'];

    public function scopeSearch($query, $value)
    {
        $query->whereTranslationLike('title', "%$value%")
            ->orWhereHas('values', function ($q) use ($value) {
                return $q->search($value);
            })->orWhereHas('parent', function ($q) use ($value) {
                return $q->whereTranslationLike('title', "%$value%");
            });
    }

    public function parent()
    {
        return $this->belongsTo(Property::class, 'parent_id');
    }
    public function subproperties()
    {
        return $this->hasMany(Property::class, 'parent_id');
    }
    public function values()
    {
        return $this->hasMany(PropertyValue::class);
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
