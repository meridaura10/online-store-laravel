<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','session_id','lifetime'];

    protected $casts = [
        'lifetime' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function basketItems(){
        return $this->hasMany(BasketItem::class);
    }
}
