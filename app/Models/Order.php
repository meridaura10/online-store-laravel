<?php

namespace App\Models;

use App\Models\OrderPayment;
use App\Models\OrderProduct;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory;
    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'amount',
        'status',
        'user_id',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }
    public function scopeStatus($query,$value){
        $query->where('status',$value);
    }
    public function scopePaymentSystem($query,$value){
        return $query->whereHas('payments', function ($query) use ($value) {
            $query->where('system', $value);
        });
    }
    public function scopeDateFrom($query,$value){
        $startDate = Carbon::parse($value)->startOfDay();
        $query->where('created_at','>',$startDate);
    }    
    public function scopeDate($query, $value) {
        $date = Carbon::parse($value)->startOfDay();
        $endDate = $date->copy()->endOfDay();
    
        $query->where('created_at', '>=', $date)
              ->where('created_at', '<=', $endDate);
    }
    public function scopeDateTo($query, $value)
    {
        $startDate = Carbon::parse($value)->endOfDay();

        $query->where('created_at', '<', $startDate);
    }
    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }
    public function address()
    {
        return $this->hasOne(OrderAddress::class);
    }
    public function payments()
    {
        
        return $this->morphMany(Payment::class, 'payable');
    }
    
    public function customer(){
        return $this->hasOne(OrderCustomer::class);
    }
}    
