<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    use Translatable;
    public $translatedAttributes = ['title'];

    public function values()
    {
        return $this->hasMany(OptionValue::class);
    }

    public function scopeSearch($query, $value)
    {
        return $query->whereTranslationLike('title', "%$value%");
    }
    public function scopeSearchToValue($query, $value)
    {
        $query->whereHas('values', function ($q) use ($value) {
            return $q->whereTranslationLike('value', "%$value%");
        });
    }
}
