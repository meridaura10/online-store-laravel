<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'address',
        'city_id',
        'number',
    ];
    public function scopeSearch($query, $value)
    {
        $query->where('address', 'like', "%$value%");
    }
    public function scopeByCity($query, $value)
    {
        $query->where('city_id', $value);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
