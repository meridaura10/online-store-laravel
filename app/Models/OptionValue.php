<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionValue extends Model
{
    use HasFactory;
    use Translatable;

    protected $connection = "mysql";

    protected $fillable = ['option_id'];

    public $translatedAttributes = ['value'];

    public function option()
    {
        return $this->belongsTo(Option::class);
    }
    public function skus()
    {
        return $this->belongsToMany(Sku::class, 'sku_variations');
    }
}
