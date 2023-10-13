<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        "currency",
        "amount",
        "status",
        "type",
        "system",
        'payable_id',
        'payment_expired_time',
        'payment_page_url',
        'payable_type',
    ];
    public $incrementing = false; 
    protected $keyType = 'string'; 
    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
    
    public function payable()
    {
        return $this->morphTo();
    }
}
