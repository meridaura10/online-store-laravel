<?php

namespace App\Models;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        "payment_id",
        "order_id",
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function payments()
    {
        return $this->morphMany(Payment::class, 'payable');
    }
}
