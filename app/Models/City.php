<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'area_id',
    ];
    public function area(){
        return $this->belongsTo(Area::class);
    }
    public function scopebyArea($query,$value){
        return $query->where('area_id',$value);
    }
    public function scopeWithWarehouses($query)
    {
        $query->whereHas('warehouses');
    }
    public function scopeSearch($query, $value)
    {
        $query->where('name', 'like', "%$value%");
    }


    public function warehouses(){
        return $this->hasMany(Warehouse::class);
    }
}
