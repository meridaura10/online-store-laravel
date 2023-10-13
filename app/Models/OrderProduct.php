<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','sku_id','quantity','price','name'];

    public function sku(){
        return $this->belongsTo(Sku::class);
    }
}
