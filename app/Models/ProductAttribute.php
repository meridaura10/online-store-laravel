<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['product_id','attribute_value_id'];

    public function attributeValue(){
        return $this->belongsTo(AttributeValue::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
