<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BasketItem extends Model
{
    use HasFactory;

    protected $fillable = ['sku_id','quantity','basket_id'];

    public function basket(){
        return $this->belongsTo(Basket::class);
    }
    public function sku(){
        return $this->belongsTo(Sku::class);
    }
    protected function sum(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->sku->price * $this->quantity
        );
    }
}
