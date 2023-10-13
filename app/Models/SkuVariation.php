<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkuVariation extends Model
{
    use HasFactory;

    protected $fillable = ['sku_id', 'option_value_id'];

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
    public function optionValue()
    {
        return $this->belongsTo(OptionValue::class);
    }
}
