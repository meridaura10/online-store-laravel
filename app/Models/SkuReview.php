<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkuReview  extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'sku_id', 'comment', 'rating'];
    protected $casts = [
        'rating' => 'integer',
    ];

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
